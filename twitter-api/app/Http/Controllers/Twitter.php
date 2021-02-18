<?php

namespace App\Http\Controllers;

use Abraham\TwitterOAuth\TwitterOAuth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Twitter extends Controller
{
    public $user_id;

    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    public function index()
    {
        $time_lines = $this->getUserTimeline($this->user_id);
        array_map(
            array(
                $this,
                "getVideo"
            ),
            $time_lines
        );
        return response()->json(['success' => true, 'message' => 'Action Complete']);
    }

    public function getUserTimeline($user_id)
    {
        $url = "https://api.twitter.com/2/users/{$user_id}/tweets?max_results=20";
        $token = env('TWITTER_BEARER_TOKEN');
        $response = Http::withToken($token)->get($url, ['max_results' => 10]);
        $response_data_array = json_decode($response->body(), true);
        $time_lines = [];
        foreach ($response_data_array['data'] as $key => $value) {
            $time_lines[] = $value['id'];
        }
        return $time_lines;
    }

    public function getVideo($tweet_id)
    {
        $consumer_key = env('TWITTER_CONSUMER_KEY');
        $consumer_secret_key = env('TWITTER_CONSUMER_SECRET');
        $access_token = env('TWITTER_ACCESS_TOKEN');
        $access_token_secret = env('TWITTER_ACCESS_TOKEN_SECRET');
        $connection = new TwitterOAuth(
            $consumer_key,
            $consumer_secret_key,
            $access_token,
            $access_token_secret
        );
        $content = $connection->get("account/verify_credentials");

        $tweet = $this->getTweetInfo($connection, $tweet_id);
        $tweet_video = $this->getTweetVideo($tweet);
        
        $source = $this->getVideoWithGreaterQuality($tweet_video);
        $file_name = "{$tweet_id}.mp4";
        $location = $this->getPathVideo($file_name);
        
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

    public function getVideoWithGreaterQuality($array_videos)
    {
        $max_val = $array_videos[0]['bitrate'];
        $url = $array_videos[0]['url'];
        foreach ($array_videos as $key => $value) {
            $next_val = $value['bitrate'];
            if ($next_val > $max_val) {
                $max_val = $next_val;
                if ($value['url']) {
                    $url = $value['url'];
                }
                Log::info($url);
            }
        }

        return $url;
    }

    public function getPathVideo($file_name)
    {
        Storage::disk('local')->put($file_name, "");
        $path =  Storage::disk('local')->path($file_name);
        return $path;
    }

    public function getTweetInfo($connection, $tweetid)
    {
        $tweet = $connection->get(
            'statuses/show',
            [
                'id' => $tweetid,
                'tweet_mode' => 'extended',
                'include_entities' => 'true',
            ]
        );
        return $tweet;
    }

    public function getTweetVideo($tweet)
    {
        $sizeOfArray = count($tweet->extended_entities->media[0]->video_info->variants);

        $videoUrls = array();
        $videoUrlsIndexPoint = 0;
        for ($i = 0; $i < $sizeOfArray; $i++) {
            // can be video/mp4 , application/x-mpegURL
            $typeOfContent = $tweet->extended_entities->media[0]->video_info->variants[$i]->content_type;

            if ($typeOfContent == "video/mp4") {
                $videoUrls[$videoUrlsIndexPoint]["bitrate"] = $tweet->extended_entities->media[0]->video_info->variants[$i]->bitrate;
                $videoUrls[$videoUrlsIndexPoint]["url"] = $this->cleanParametersFromUrl(
                    $tweet->extended_entities->media[0]->video_info->variants[$i]->url
                );
                //Have to make index point+1 on each object added.
                $videoUrlsIndexPoint++;
            }
        }

        return $videoUrls;
    }

    public function cleanParametersFromUrl($url)
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

}
