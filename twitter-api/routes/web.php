<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get(
    '/', 'SofascoreController@home'
);

Route::post('/search_match_records/score_home', 'SofascoreController@searchRecords');
Route::post('/update_time_to_pick_event', 'SettingsController@store');

Route::get('/tweet-timeline', 'Twitter@index');

Route::get('/search/match-score-details/{match_id}', 'SofascoreController@searchMatchScores');
Route::get('/today/matches', 'SofascoreController@matchesForToday')->name('today_matches');
Route::get('/search/match/{id}/{competition}', 'SofascoreController@searchMatchWithId');

Route::get('/update_score_home', 'SofascoreController@updateRecordsCorrectScore');
Route::get(
    '/view_similar_matches/{sofascore}',
    'SofascoreController@viewSimilarRecords'
);

Route::get('/score_home/date/{new_date?}', 'SofascoreController@index');
Route::get('/update_midnight/scores', 'SofascoreController@indexProcessMidnight');
