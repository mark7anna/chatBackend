<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PushNotificationController extends Controller
{
    
    public function sendNotificationToUser($token , $title , $message){
        $headers = [
           "Content-Type" => "application/json",
           'Authorization' => 'key=AAAApSeXnMc:APA91bG-7NnK_dTYnoCeZ0BPxR5oGJCtn7_mg5lVhG_AtMHDYrrQZ16dgcFV3iXC128SmXco1YUa50STSfBZzxCenXxqwwC2GtbtiMenkjpSnQkCBMLYCo5DEMxP01lLjcF0Q9rMtDiU'
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
