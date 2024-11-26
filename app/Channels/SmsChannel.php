<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;

class SmsChannel
{
    public function send($notifiable, $notification): void
    {
        $notification->toSms($notifiable);
//        dd($notification);
//        dd( $notifiable , $notification->toSms($notifiable) );

        // Send SMS
    }
}
