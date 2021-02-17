<?php

use Abraham\TwitterOAuth\TwitterOAuth;
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
function cleanParametersFromUrl($url)
{

    // If URL has ? paramters.
    if (strpos($url, '?') !== false) {

        //Catch and select first part.
        $urlarray = explode("?", $url);
        $newurl = $urlarray[0];

    } else {

        $newurl = $url;

    }

    return $newurl;
}

function getTweetVideo($tweet)
{
    $sizeOfArray = count($tweet->extended_entities->media[0]->video_info->variants);

    $videoUrls = array();
    $videoUrlsIndexPoint = 0;
    for ($i = 0; $i < $sizeOfArray; $i++) {
        // can be video/mp4 , application/x-mpegURL
        $typeOfContent = $tweet->extended_entities->media[0]->video_info->variants[$i]->content_type;

        if ($typeOfContent == "video/mp4") {
            $videoUrls[$videoUrlsIndexPoint]["bitrate"] = $tweet->extended_entities->media[0]->video_info->variants[$i]->bitrate;
            $videoUrls[$videoUrlsIndexPoint]["url"] = cleanParametersFromUrl($tweet->extended_entities->media[0]->video_info->variants[$i]->url);
            //Have to make index point+1 on each object added.
            $videoUrlsIndexPoint++;
        }
    }

    return $videoUrls;
}
function getTweetInfo($connection, $tweetid)
{
    $tweet = $connection->get('statuses/show', [
        'id' => $tweetid,
        'tweet_mode' => 'extended',
        'include_entities' => 'true',
    ]);
    return $tweet;
}

Route::get(
    '/tweets', function () {
        $consumer_key = env('TWITTER_CONSUMER_KEY');
        $consumer_secret_key = env('TWITTER_CONSUMER_SECRET');
        $access_token = env('TWITTER_ACCESS_TOKEN');
        $access_token_secret = env('TWITTER_ACCESS_TOKEN_SECRET');
        $connection = new TwitterOAuth($consumer_key, $consumer_secret_key, $access_token, $access_token_secret);
        $content = $connection->get("account/verify_credentials");

        $tweet_id = "1362069297389010946"; // Example_Tweet_id  get
        $tweet = getTweetInfo($connection, $tweet_id);
        $tweet_video = getTweetVideo($tweet);
        $source = $tweet_video[0]['url'];

        $location = '../storage/app/videos/video.mp4';
        $fp = fopen($location, "w+");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $source);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
    }
);

Route::get('/search/match-score-details/{match_id}', 'SofascoreController@searchMatchScores');
Route::get('/today/matches', 'SofascoreController@matchesForToday')->name('today_matches');
Route::get('/search/match/{id}/{competition}', 'SofascoreController@searchMatchWithId');

Route::get('/update_score_home', 'SofascoreController@updateRecordsCorrectScore');

Route::get('/score_home/date/{new_date?}', 'SofascoreController@index');
