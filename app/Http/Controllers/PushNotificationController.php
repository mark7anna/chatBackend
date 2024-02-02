<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PushNotificationController extends Controller
{
    
    public function sendNotificationToUser($token , $title , $message){
        $headers = [
           "Content-Type" => "application/json",
           "Authorization" => "key=AAAA9KG6GqI:APA91bE3eRJUYtH33C8bpKWdyi4tcQwmIqhSq3_IPNUnjrAXUnyN3tNSfxiY8uS_DJ1zGgQD8XVDtANvBOnd3703JE77iTQjWoVAuCh6Q_KEDnxWP-1KWs44eCcIuLhRY14ELm7eKywN"
        ];
        $response = Http::withHeaders($headers)->post('https://fcm.googleapis.com/fcm/send', [
            "to" => $token,
            "notification" => [
                "title" => $title ,
                "body" => $message ,
                "sound" => "default"
            ],
            "android" => [
                "priority" => "HEIG",
                "notification" => [
                    "notification_priority" => "PRIORITY_MAX",
                    "sound" => "default",
                    "default_sound" => true,
                    "default_vibrate_timings" => true,
                    "default_light_settings" => true
                ]
            ],
            "data" => [
                "type" => "order",
                "id" => "87",
                "click_action" => "FLUTTER_NOTIFICATION_CLICK"
            ],
          ]);
          $res = $response->json();
         //   dd($res);
    }
    public function sendNotificationToApp(){

    }
}
