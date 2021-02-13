<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\SfDates;
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
    public function index($new_date = '2021-01-01')
    {
        try {

            $sf_dates = SfDates::where('processed', 0)->first();
            if (!$sf_dates) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'No more dates to process. Thank You',
                    ]
                );
            }
            $date = $sf_dates->event_date;
            $base_file = $date . '_base.json';
            $predict_file = $date . '_predict.json';

            $predicted_file = empty($this->checkIfFileExists($predict_file, false)) ? $this->writePredictedToFIle($predict_file, $date) : $this->checkIfFileExists($predict_file, false);

            $match_file = empty($this->checkIfFileExists($base_file)) ? $this->writeBaseToFile($base_file, $date) : $this->checkIfFileExists($base_file);
            $number_of_records = $this->processMatchResults($match_file, $date, $predicted_file);
            SfDates::where('id', $sf_dates->id)
                ->update(['processed' => 1, 'number_of_records' => $number_of_records]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false]);
        }

    }

    /**
     * Update Records for correct score if it exists
     * Given the sets for both players, determine who wins the match
     *
     * @return mixed
     */
    public function updateRecordsCorrectScore()
    {
        $result = Sofascore::select(
            'id',
            'away_score',
            'updated_score',
            'correct_score',
            'home_score',
            'match_id'
        )->where('updated_score', 0)->take(1000)->get();
        foreach ($result as $record) {
            if ($record->home_score) {
                $winner = $this->determineWinner(
                    $record->home_score, $record->away_score
                );
                if ($winner === 1) {
                    Sofascore::where('id', $record->id)
                        ->update(['updated_score' => 1]);
                    Log::error('Correct Score not found for record -> ' . $record->match_id);
                } else if ($winner) {
                    Sofascore::where('id', $record->id)
                        ->update(['correct_score' => $winner, 'updated_score' => 1]);
                    Log::info('Updating correct score of record -> ' . $record->match_id);
                }
            }

        }
        if (count($result) == 0) {
            Log::info('Zero records found for correct score');
        }
        return response()->json(['success' => true, 'message' => 'Number of records -> ' . count($result)]);
    }

    /**
     * Update the records for total scores for each and total
     * Given the sets for both players
     *
     * @return mixed
     */
    public function updateTotalScores()
    {
        $result = Sofascore::select(
            'id',
            'away_score',
            'updated_score',
            'correct_score',
            'home_score',
            'match_id'
        )->where(
            'updated_score', 1
        )->whereNotNull('correct_score')->take(1000)->get();
        foreach ($result as $record) {
            if (!empty($record->home_score) && !empty($record->away_score)) {
                $winner = $this->determineTotalScore(
                    $record->home_score, $record->away_score
                );
                Sofascore::where(
                    'id',
                    $record->id
                )->update($winner);
                Log::info('Updating total score of record -> ' . $record->match_id);
            }

        }
        if (count($result) == 0) {
            Log::info('Zero records found for total scores');
        }
        return response()->json(['success' => true, 'message' => 'Number of records -> ' . count($result)]);
    }

    /**
     * Process match results. Combine events and the predicted outcome
     *
     * @param string $match_file //path to the file location
     * @param string $date // date which the event took place
     * @param string $predicted_file //path to the file location
     *
     * @return void
     */
    public function processMatchResults($match_file, $date, $predicted_file)
    {
        $full_match_details = [];
        $match_details = JsonMachine::fromFile($match_file, '/events');
        $index = 0;
        foreach ($match_details as $key => $value) {
            
            if (array_key_exists('winnerCode', $value) && $value['tournament']['slug'] != 'ukraine-win-cup' && $value['winnerCode'] != 0) {
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
                        $index++;
                    }
                }
            }
        }
        return $index;
    }

    /**
     * Create the processed match details in the \App\Models\Sofascore
     *
     * @param array $full_match_details // array of match details to create
     *
     * @return void
     */
    public function createProcessMatchResults($full_match_details)
    {
        try {
            Sofascore::create($full_match_details);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * Determine the Winner given the set of scores
     *
     * @param string $home_score //set details for home scores
     * @param string $away_score // set details for away score
     *
     * @return mixed
     */
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

    /**
     * Determine the total scores given the set of scores
     *
     * @param string $home_score //set details for home scores
     * @param string $away_score // set details for away score
     *
     * @return mixed
     */
    public function determineTotalScore($home_score, $away_score)
    {
        $homeScore = json_decode($home_score, true);
        $awayScore = json_decode($away_score, true);
        $home = 0;
        $away = 0;
        $count = 1;
        while ($count < 8) {
            $key = "period" . $count;
            if (array_key_exists($key, $homeScore)) {
                $home += intval($homeScore[$key]);
                $away += intval($awayScore[$key]);
            }

            $count += 1;
        }

        return [
            'home_total' => $home,
            'away_total' => $away,
            'both_total' => $away + $home,
            'updated_score' => 2,
        ];
    }

    /**
     * Convert Timestamp to Date with timezone and compare if is equal to
     * input date
     *
     * @param string $timestamp //the time stamp to convert
     * @param string $input_date //input date
     *
     * @return mixed
     */
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

    /**
     * Convert Timestamp to Date with timezone and compare if is equal to
     * input date
     *
     * @param string $timestamp //the time stamp to convert
     * @param string $input_date //input date
     *
     * @return mixed
     */
    public function convertTimestampToDateTimeWithTimeZoneToday($timestamp, $input_date)
    {
        $date = new \DateTime("@" . $timestamp);
        $date->setTimezone(new \DateTimeZone('Africa/Nairobi'));
        $format_1 = $date->format('Y-m-d');
        if ($format_1 == $input_date) {
            return $date->format('H:i');
        }
        return false;
    }

    /**
     * Process Predicted match details and return an array
     *
     * @param string $predicted_file // path to the file
     * @param int $match_id // id of the current match
     *
     * @return array
     */
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
     * @param string $home_value //home value
     * @param string $away_value //away value
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
     * Home page.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        $competition = Sofascore::all('competition')->unique('competition');
        $records = Sofascore::orderBy('id', 'desc')->take(20)->get();
        $request = new \stdClass;
        $request->home_odd = '';
        $request->away_odd = '';
        $request->competition = '';
        $request->actual_value_home = '';
        $request->expected_value_home = '';
        $request->expected_value_away = '';
        $request->actual_value_away = '';
        $total_records = Sofascore::count();
        return view('welcome', compact('competition', 'records', 'request', 'total_records'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function searchRecords(Request $request)
    {
        $search_params = $request->only(
            [
                'home_odd', 'away_odd', 'competition', 'actual_value_home',
                'expected_value_home', 'expected_value_away', 'actual_value_away',
            ]
        );
        $new_search_params = array_filter($search_params);
        $competition = Sofascore::all('competition')->unique('competition');
        $records = Sofascore::where($new_search_params)->get();
        $total_records = Sofascore::count();

        return view('welcome', compact('competition', 'records', 'request', 'total_records'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function matchesForToday()
    {
        date_default_timezone_set("Africa/Nairobi");
        $today = date('Y-m-d');
        $base_file = $today . '_today_base.json';
        $match_file = empty($this->checkIfFileExists($base_file)) ? $this->writeBaseToFile($base_file, $today) : $this->checkIfFileExists($base_file);
        $store_map_id = [];
        $match_details = JsonMachine::fromFile($match_file, '/events');
        $current_time = Setting::whereNotNull('current_time')->orderBy('id', 'desc')->first();
        $date_time = $current_time->current_time;
        $result = true;
        foreach ($match_details as $key => $value) {
            if ($value['tournament']['slug'] != 'ukraine-win-cup') {
                $event_date_time = $this->convertTimestampToDateTimeWithTimeZoneToday(
                    $value['startTimestamp'],
                    $today
                );

                if ($event_date_time == $date_time) {
                    $store_map_id[] = [
                        'id' => $value['id'],
                        'competition' => $value['tournament']['category']['flag'] . ' ' . $value['tournament']['name'],
                        'home_player' => $value['homeTeam']['name'],
                        'away_player' => $value['awayTeam']['name'],
                        'result' => $value['winnerCode']
                    ];
                }
            }
        }

        return view('today_matches', compact('store_map_id', 'result', 'current_time'));
    }

    /**
     * Search match by id.
     *
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function searchMatchWithId($id, $competition)
    {
        $predicted_array = $this->getMatchDetail($id);
        $calc_odds = false;
        $result = [];
        if ($predicted_array['home_odd'] && $predicted_array['away_odd']) {
            $calc_odds = $this->convertFractionToDecimal(
                $predicted_array['home_odd'], $predicted_array['away_odd']
            );

            $result = $this->searchForMatchWithThisDetails($predicted_array, $calc_odds, $competition);
        }
        return json_encode($result);
    }

    public function searchForMatchWithThisDetails($predicted_array, $calc_odds, $competition)
    {
        $search = [
            'home_odd' => rtrim($calc_odds[0]),
            'away_odd' => rtrim($calc_odds[1]),
            'competition' => $competition,
            'actual_value_home' => $predicted_array['home']['actual'],
            'expected_value_home' => $predicted_array['home']['expected'],
            'expected_value_away' => $predicted_array['away']['expected'],
            'actual_value_away' => $predicted_array['away']['actual'],
        ];
        $new_search = array_filter($search);
        $results = Sofascore::where($new_search)->get();

        return $results;
    }

    public function getMatchDetail($match_id)
    {
        $predicted_array = [];
        $predicted_array['home_odd'] = false;
        $predicted_array['away_odd'] = false;
        try {
            $response = Http::get(
                "https://api.sofascore.com/api/v1/event/{$match_id}/provider/1/winning-odds"
            );
            if ($response->status() == 404) {
                return $predicted_array;
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
            if (array_key_exists('fractionalValue', $details['home'])) {
                $predicted_array['home_odd'] = $details['home']['fractionalValue'];
            }
            if (array_key_exists('fractionalValue', $details['away'])) {
                $predicted_array['away_odd'] = $details['away']['fractionalValue'];
            }

            return $predicted_array;

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $predicted_array;
        }
    }

    /**
     * Update the specified resource from storage.
     *
     * @return void
     */
    public function updateSfDates()
    {
        $year = 2020;
        $month = "08";
        $day = 31;
        while ($day > 0) {
            $date = $year . '-' . $month . '-' . $day;
            if ($day < 10) {
                $date = $year . '-' . $month . '-' . '0' .$day;
            }
            SfDates::create(
                [
                    'event_date' => $date,
                ]
            );
            $day -= 1;
        }
    }
}
