<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserNotification;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;


class UserNotificationController extends Controller
{
    public function createUserNotification($type , $notified_user , $action_user , $title , $content 
    , $title_ar , $content_ar){

        try{
           UserNotification::create([
            'type' => $type,
            'notified_user' => $notified_user,
            'action_user' => $action_user,
            'title' => $title,
            'content' => $content,
            'title_ar' => $title_ar,
            'content_ar' => $content_ar,
           ]);
            return response()->json(['state' => 'success' , 'message' => 'Notification has been sent successfully']);

        }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }
      
    }

    function getAllUserNotifications($user_id){
        try{
           $notifications = DB::table('user_notifications')
           -> join('app_users as notified_user' , 'user_notifications.notified_user' , '=' , 'notified_user.id')
           -> leftJoin('app_users as action_user' , 'user_notifications.notified_user' , '=' , 'action_user.id')
           -> select('user_notifications.*' , 'notified_user.name as notified_user_name' ,
            'notified_user.tag as notified_user_tag' , 'notified_user.img as notified_user_img' , 
            'action_user.name as action_user_name' , 'action_user.tag as action_user_tag' , 
            'action_user.img as action_user_img' )
            -> where('user_notifications.notified_user' , '=' , $user_id)-> get();
            return response()->json(['state' => 'success' , 'notifications' => $notifications]);

        }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }
    }
}
