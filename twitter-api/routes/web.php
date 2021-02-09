<?php

use Illuminate\Routing\Route as RoutingRoute;
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
    '/', function () {
        return view('welcome');
    }
);

Route::get(
    '/tweets', function () {
        return view('tweets');
    }
);

Route::get('/update_score_home', 'SofascoreController@updateRecordsCorrectScore');

Route::get('/score_home/{date}', 'SofascoreController@index')->where(
    ['date' => "/\d{4}\-\d{2}-\d{2}/"]
);
