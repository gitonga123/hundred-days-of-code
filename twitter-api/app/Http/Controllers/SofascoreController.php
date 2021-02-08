<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use JsonMachine\JsonMachine;
use JsonMachine\JsonDecoder\ExtJsonDecoder;


class SofascoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($date = '2021-02-05')
    {
        $base_file = $date . '_base.json';
        $predict_file = $date . '_predict.json';

        $predicted_file = empty($this->checkIfFileExists($predict_file)) ? $this->writePredictedToFIle($predict_file, $date) : $this->checkIfFileExists($predict_file);

        $match_file = empty($this->checkIfFileExists($base_file)) ? $this->writeBaseToFile($base_file, $date) : $this->checkIfFileExists($base_file);
        $result = $this->processMatchResults($match_file, $date, $predicted_file);

    }

    public function processMatchResults($match_file, $date, $predicted_file)
    {
        $match_details = JsonMachine::fromFile($match_file, '/events');
        foreach ($match_details as $key => $value) {
            $event_date_time = $this->convertTimestampToDateTimeWithTimeZone(
                $value['startTimestamp'], $date
            );
            if ($event_date_time) {
                $full_match_details = $this->processPredictedMatchDetails(
                    $predicted_file, $value['id']
                );
                $full_match_details['competition'] = $value['tournament']['category']['flag'] . ' ' . $value['tournament']['name'];
                $full_match_details['player_1'] = $value['homeTeam']['name'];
                $full_match_details['player_2'] = $value['awayTeam']['name'];
                $full_match_details['result'] = $value['winnerCode'];
                $full_match_details['score'] = $value['homeScore']['normaltime'] ."-" . $value['awayScore']['normaltime'];
            }
        }

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
            if ($key == $match_id) {
                dd($key, $match_id);
                $predictor = $this->getProviderPredictions($key);
                if ($predictor) {
                    $calculation = $this->convertFractionToDecimal(
                        $value['choices'][0]['fractionalValue'],
                        $value['choices'][1]['fractionalValue']
                    );
                    $reformated_predicted_details[$key] = [
                        'id' => $key,
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
                Log::info($reformated_predicted_details);  
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
    public function checkIfFileExists($file_name)
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
