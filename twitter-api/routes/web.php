<?php

use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Route;
use App\Models\Sofascore;

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
    '/', function () {
        $competition = Sofascore::all('competition')->unique('competition');
        $records = Sofascore::orderBy('id', 'desc')->take(20)->get();
        return view('welcome', compact('competition', 'records'));
    }
);

Route::post('/search_match_records/score_home', 'SofascoreController@searchRecords');

Route::get(
    '/tweets', function () {
        return view('tweets');
    }
);

Route::get('/update_score_home', 'SofascoreController@updateRecordsCorrectScore');

Route::get('/score_home/date/{new_date?}', 'SofascoreController@index');

