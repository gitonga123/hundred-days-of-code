<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use NotificationChannels\Telegram\TelegramChannel;
use Illuminate\Support\Facades\Storage;
use NotificationChannels\Telegram\TelegramFile;

class Telegram extends Controller
{
    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }
    
    public function index()
    {

    }

    public function toTelegram($notifiable)
    {

        $file = Storage::disk('local')->path('1362122141735378950.mp4');
        return TelegramFile::create()->content('Sample *video* notification!')
            >to($notifiable->telegram_user_id) 
            ->video($file);
    }
}
