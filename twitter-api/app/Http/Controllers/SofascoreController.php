<?php

namespace App\Http\Controllers;

use App\Models\Sofascore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use JsonMachine\JsonMachine;

class SofascoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($date = '2021-01-03')
    {
        try {
            $base_file = $date . '_base.json';
            $predict_file = $date . '_predict.json';

            $predicted_file = empty($this->checkIfFileExists($predict_file, false)) ? $this->writePredictedToFIle($predict_file, $date) : $this->checkIfFileExists($predict_file, false);

            $match_file = empty($this->checkIfFileExists($base_file)) ? $this->writeBaseToFile($base_file, $date) : $this->checkIfFileExists($base_file);
            $this->processMatchResults($match_file, $date, $predicted_file);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false]);
        }

    }

    public function updateRecordsCorrectScore()
    {
        $result = Sofascore::where('updated_score', 0)->take(1500)->get();
        foreach ($result as $record) {
            if ($record->home_score) {
                $winner = $this->determineWinner(
                    $record->home_score, $record->away_score
                );
                if ($winner === 1) {
                    Sofascore::where('id', $record->id)
                        ->update(['updated_score' => 1]);
                    Log::error('Score not found for record -> ' . $record->match_id);
                } else if ($winner) {
                    Sofascore::where('id', $record->id)
                        ->update(['correct_score' => $winner, 'updated_score' => 1]);
                    Log::info('Updating score record -> ' . $record->match_id);
                }
            }

        }
        dd(count($result));
        return;
    }

    public function processMatchResults($match_file, $date, $predicted_file)
    {
        $full_match_details = [];
        $match_details = JsonMachine::fromFile($match_file, '/events');
        $index = 0;
        foreach ($match_details as $key => $value) {
            if ($value['tournament']['slug'] != 'ukraine-win-cup') {
                $event_date_time = $this->convertTimestampToDateTimeWithTimeZone(
                    $value['startTimestamp'], $date
                );
                if ($event_date_time) {
                    $full_match_details = $this->processPredictedMatchDetails(
                        $predicted_file, $value['id']
                    );
                    if ($full_match_details) {
                        $full_match_details['competition'] = $value['tournament']['category']['flag'] . ' ' . $value['tournament']['name'];
                        $full_match_details['player_1'] = $value['homeTeam']['name'];
                        $full_match_details['player_2'] = $value['awayTeam']['name'];
                        $full_match_details['result'] = $value['winnerCode'];
                        $full_match_details['home_score'] = json_encode($value['homeScore']);
                        $full_match_details['away_score'] = json_encode($value['awayScore']);
                        $full_match_details['match_id'] = $value['id'];
                        $full_match_details['event_date'] = $event_date_time;

                        $this->createProcessMatchResults($full_match_details);
                        Log::info('Processing id --> ' . $value['id']);
                    }
                }
            }
        }
    }

    public function createProcessMatchResults($full_match_details)
    {
        try {
            Sofascore::create($full_match_details);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function determineWinner($home_score, $away_score)
    {
        $homeScore = json_decode($home_score, true);
        $awayScore = json_decode($away_score, true);
        $home = 0;
        $away = 0;
        $count = 1;

        if (empty($homeScore) || empty($awayScore)) {
            return 1;
        }
        if (array_key_exists('normaltime', $homeScore) || array_key_exists('normaltime', $awayScore)) {
            return $homeScore['normaltime'] . "-" . $awayScore['normaltime'];
        }

        while (($home < 3 || $away < 3) && $count < 10) {
            $key = "period" . $count;
            if (array_key_exists($key, $homeScore)) {
                if ($homeScore[$key] > $awayScore[$key]) {
                    $home += 1;
                }
                if ($awayScore[$key] > $homeScore[$key]) {
                    $away += 1;
                }
            }

            $count += 1;
        }
        if ($home > 0 || $away > 0) {
            return $home . "-" . $away;
        }

        return 1;

    }

    public function convertTimestampToDateTimeWithTimeZone($timestamp, $input_date)
    {
        $date = new \DateTime("@" . $timestamp);
        $date->setTimezone(new \DateTimeZone('Africa/Nairobi'));
        $format_1 = $date->format('Y-m-d');
        if ($format_1 == $input_date) {
            return $date->format('Y-m-d H:i:s');
        }
        return false;
    }

    public function processPredictedMatchDetails($predicted_file, $match_id)
    {
        $predicted_details = JsonMachine::fromFile($predicted_file, '/odds');
        $reformated_predicted_details = [];
        foreach ($predicted_details as $key => $value) {
            if (intval($key) == $match_id) {
                $predictor = $this->getProviderPredictions($key);
                if ($predictor) {
                    $calculation = $this->convertFractionToDecimal(
                        $value['choices'][0]['fractionalValue'],
                        $value['choices'][1]['fractionalValue']
                    );
                    $reformated_predicted_details = [
                        'home_change' => $value['choices'][0]['change'],
                        'away_change' => $value['choices'][1]['change'],
                        'home_odd' => $calculation[0],
                        'away_odd' => $calculation[1],
                        'expected_value_home' => $predictor['home']['expected'],
                        'actual_value_home' => $predictor['home']['actual'],
                        'expected_value_away' => $predictor['away']['expected'],
                        'actual_value_away' => $predictor['away']['actual'],
                    ];
                }
            }
        }
        return $reformated_predicted_details;
    }

    /**
     * Get Provider predictions details
     *
     * @param [string] $predicted_id // the unifying id
     *
     * @return mixed
     */
    public function getProviderPredictions($predicted_id)
    {
        $predicted_array = [];
        try {
            $response = Http::get(
                "https://api.sofascore.com/api/v1/event/{$predicted_id}/provider/1/winning-odds"
            );
            if ($response->status() == 404) {
                return false;
            }
            $details = json_decode($response->body(), true);
            if ($details['home']) {
                $predicted_array['home'] = [
                    'expected' => $details['home']['expected'],
                    'actual' => $details['home']['actual'],
                ];
            } else {
                $predicted_array['home'] = [
                    'expected' => null,
                    'actual' => null,
                ];
            }
            if ($details['away']) {
                $predicted_array['away'] = [
                    'expected' => $details['away']['expected'],
                    'actual' => $details['away']['actual'],
                ];
            } else {
                $predicted_array['away'] = [
                    'expected' => null,
                    'actual' => null,
                ];
            }

            return $predicted_array;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $predicted_array;
        }

    }

    /**
     * Convert Fraction string to Decimal
     *
     * @param [string] $home_value
     * @param [string] $away_value
     *
     * @return array
     */
    public function convertFractionToDecimal($home_value, $away_value)
    {

        $numbers_home = explode("/", $home_value);
        $numbers_away = explode("/", $away_value);

        $home_odd = bcdiv(
            $numbers_home[0] / $numbers_home[1], 1, 2
        );
        $away_odd = bcdiv(
            $numbers_away[0] / $numbers_away[1], 1, 2
        );
        if ($home_odd < 1 || $away_odd < 1) {
            return [$home_odd + 1, $away_odd + 1];
        }
        return [
            $home_odd,
            $away_odd,
        ];
    }

    /**
     * Check if file exists in local storage
     *
     * @param string $file_name // the name of file to check if it exists
     *
     * @return mixed
     */
    public function checkIfFileExists($file_name, $full_path = true)
    {
        try {
            $match_info = Storage::disk('local')->exists($file_name) ? Storage::disk('local')->path($file_name) : [];
            return $match_info;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    /**
     * Write the model prediction to file
     *
     * @param string $file_name // the name of the file
     * @param string $date // the date of the event
     *
     * @return bool
     */
    public function writePredictedToFIle($file_name, $date)
    {
        try {
            $response = Http::get(
                "https://api.sofascore.com/api/v1/sport/table-tennis/odds/1/{$date}"
            );
            Storage::disk('local')->put($file_name, $response->body());
            return Storage::disk('local')->path($file_name);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    /**
     * This function writes the content of the network response to file
     * Base is the list of scheduled events on the day
     *
     * @param string $file_name // the name of the file
     * @param string $date // the date the event took place
     *
     * @return bool
     */
    public function writeBaseToFile($file_name, $date)
    {
        try {
            $response = Http::get(
                "https://api.sofascore.com/api/v1/sport/table-tennis/scheduled-events/{$date}"
            );
            Storage::disk('local')->put($file_name, $response->body());
            return Storage::disk('local')->path($file_name);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
