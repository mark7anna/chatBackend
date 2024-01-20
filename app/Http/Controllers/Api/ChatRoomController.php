<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChatRoom;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AppUser;
use Carbon\Carbon;
use App\Models\Country;
use App\Models\Themes;
use App\Models\Mic;



class ChatRoomController extends Controller
{
    public function index(){
        try{
            $rooms = DB::table('chat_rooms')
            -> join('countries' , 'chat_rooms.country_id' , '=' , 'countries.id')
            -> join('app_users' , 'chat_rooms.userId' , 'app_users.id')
            -> select('chat_rooms.*' , 'countries.icon as flag' , 'app_users.tag as admin_tag' , 
            'app_users.name as admin_name' , 'app_users.img as admin_img') -> get();
            return $rooms ;
        } catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }
        
    }

    public function search($txt){
        try{
            $rooms = DB::table('chat_rooms')
            -> join('countries' , 'chat_rooms.country_id' , '=' , 'countries.id')
            -> join('app_users' , 'chat_rooms.userId' , 'app_users.id')
            -> select('chat_rooms.*' , 'countries.icon as flag' , 'app_users.tag as admin_tag' , 
            'app_users.name as admin_name' , 'app_users.img as admin_img') 
            -> where('chat_rooms.tag' , 'like' , '%' .$txt . '%' )
            ->orWhere('chat_rooms.name', 'like', '%' . $txt . '%')->get();
            return $rooms ;
        } catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }
        
    }
 
    public function checkRoom($user_id){
        try{
            $rooms = ChatRoom::where('userId' , '=' , $user_id) -> get();
            if(count($rooms) > 0){

                //getRoom
                return $this -> getRoom($rooms[0] -> id);
            } else {
               //createRoom
               return $this -> createRoom($user_id);
            }

        } catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }
    }

    public function getRoom($room_id){
        $room = DB::table('chat_rooms')
        -> join('countries' , 'chat_rooms.country_id' , '=' , 'countries.id')
        -> join('app_users' , 'chat_rooms.userId' , 'app_users.id')
        -> select('chat_rooms.*' , 'countries.icon as flag' , 'app_users.tag as admin_tag' , 
        'app_users.name as admin_name' , 'app_users.img as admin_img') -> where( 'chat_rooms.id' , '=' , $room_id) -> first();

       $mics = DB::table('mics')
       -> leftJoin('app_users' , 'mics.user_id' , '=' , 'app_users.id')
       ->leftJoin('levels as share_level' ,function ($join) {
        $join->on('app_users.share_level_id', '=', 'share_level.id');
        })->leftJoin('levels as karizma_level' ,function ($join) {
            $join->on('app_users.karizma_level_id', '=', 'karizma_level.id');
        }) 
        ->leftJoin('levels as charging_level' ,function ($join) {
            $join->on('app_users.charging_level_id', '=', 'charging_level.id');
        }) -> select('mics.*' , 'app_users.tag as mic_user_tag' , 'app_users.name as mic_user_name' ,
        'app_users.img as mic_user_img' , 'app_users.gender as mic_user_gender' , 'app_users.birth_date as mic_user_birth_date' ,
        'share_level.icon as mic_user_share_level' , 'karizma_level.icon as mic_user_karizma_level' ,
         'charging_level.icon as mic_user_charging_level') 
         -> where('mics.room_id' , '=' , $room_id)-> get();

         $members = DB::table('room_members')
         -> leftJoin('app_users' , 'room_members.user_id' , '=' , 'app_users.id')
         ->leftJoin('levels as share_level' ,function ($join) {
          $join->on('app_users.share_level_id', '=', 'share_level.id');
          })->leftJoin('levels as karizma_level' ,function ($join) {
              $join->on('app_users.karizma_level_id', '=', 'karizma_level.id');
          }) 
          ->leftJoin('levels as charging_level' ,function ($join) {
              $join->on('app_users.charging_level_id', '=', 'charging_level.id');
          }) -> select('room_members.*' , 'app_users.tag as mic_user_tag' , 'app_users.name as mic_user_name' ,
          'app_users.img as mic_user_img' , 'app_users.gender as mic_user_gender' , 'app_users.birth_date as mic_user_birth_date' ,
          'share_level.icon as mic_user_share_level' , 'karizma_level.icon as mic_user_karizma_level' ,
           'charging_level.icon as mic_user_charging_level') 
           -> where('room_members.room_id' , '=' , $room_id)-> get();

           $admins = DB::table('room_admins')
           -> leftJoin('app_users' , 'room_admins.user_id' , '=' , 'app_users.id')
           ->leftJoin('levels as share_level' ,function ($join) {
            $join->on('app_users.share_level_id', '=', 'share_level.id');
            })->leftJoin('levels as karizma_level' ,function ($join) {
                $join->on('app_users.karizma_level_id', '=', 'karizma_level.id');
            }) 
            ->leftJoin('levels as charging_level' ,function ($join) {
                $join->on('app_users.charging_level_id', '=', 'charging_level.id');
            }) -> select('room_admins.*' , 'app_users.tag as mic_user_tag' , 'app_users.name as mic_user_name' ,
            'app_users.img as mic_user_img' , 'app_users.gender as mic_user_gender' , 'app_users.birth_date as mic_user_birth_date' ,
            'share_level.icon as mic_user_share_level' , 'karizma_level.icon as mic_user_karizma_level' ,
             'charging_level.icon as mic_user_charging_level') 
             -> where('room_admins.room_id' , '=' , $room_id)-> get();

             $followers = DB::table('room_follows')
             -> leftJoin('app_users' , 'room_follows.user_id' , '=' , 'app_users.id')
             ->leftJoin('levels as share_level' ,function ($join) {
              $join->on('app_users.share_level_id', '=', 'share_level.id');
              })->leftJoin('levels as karizma_level' ,function ($join) {
                  $join->on('app_users.karizma_level_id', '=', 'karizma_level.id');
              }) 
              ->leftJoin('levels as charging_level' ,function ($join) {
                  $join->on('app_users.charging_level_id', '=', 'charging_level.id');
              }) -> select('room_follows.*' , 'app_users.tag as mic_user_tag' , 'app_users.name as mic_user_name' ,
              'app_users.img as mic_user_img' , 'app_users.gender as mic_user_gender' , 'app_users.birth_date as mic_user_birth_date' ,
              'share_level.icon as mic_user_share_level' , 'karizma_level.icon as mic_user_karizma_level' ,
               'charging_level.icon as mic_user_charging_level') 
               -> where('room_follows.room_id' , '=' , $room_id)-> get();

            $blockers = DB::table('room_blocks')
             -> leftJoin('app_users' , 'room_blocks.user_id' , '=' , 'app_users.id')
             ->leftJoin('levels as share_level' ,function ($join) {
              $join->on('app_users.share_level_id', '=', 'share_level.id');
              })->leftJoin('levels as karizma_level' ,function ($join) {
                  $join->on('app_users.karizma_level_id', '=', 'karizma_level.id');
              }) 
              ->leftJoin('levels as charging_level' ,function ($join) {
                  $join->on('app_users.charging_level_id', '=', 'charging_level.id');
              }) -> select('room_blocks.*' , 'app_users.tag as mic_user_tag' , 'app_users.name as mic_user_name' ,
              'app_users.img as mic_user_img' , 'app_users.gender as mic_user_gender' , 'app_users.birth_date as mic_user_birth_date' ,
              'share_level.icon as mic_user_share_level' , 'karizma_level.icon as mic_user_karizma_level' ,
               'charging_level.icon as mic_user_charging_level') 
               -> where('room_blocks.room_id' , '=' , $room_id)-> get();
       
               return response()->json(['state' => 'success' , 'room' => $room , 'mics' => $mics , 'members' => $members , 'followers' => $followers ,
                'admins' => $admins , 'blockers' => $blockers]);
   
    }
    public function createRoom($user_id){
        $user = AppUser::find($user_id);
        $theme = Themes::where('isMain' , '=' , 1) -> first();
        $country = Country::first();
        if($user){
         $tag = (int)(date('Ymd') . rand(1, 100));
          $id = ChatRoom::create([
            'tag' => $tag,
            'name' => $user-> name,
            'img' => $user -> img,
            'state' => 0,
            'password' => "",
            'userId' => $user_id,
            'subject' => "CHAT",
            'talkers_count' => 0,
            'starred' => 0, 
            'isBlocked' => 0,
            'blockedDate' => Carbon::now(),
            'blockedUntil' => Carbon::now(),
            'createdDate' => Carbon::now(),
            'isTrend' => 0,
            'details' => "",
            'micCount' => 12,
            'enableMessages' => 1,
            'reportCount' => 0,
            'themeId' => $theme -> id,
            'country_id' => $user -> country > 0 ? $user -> country : $country -> id
           ]) -> id;
          
           if($id){
            //craete mics
             for($i = 0 ; $i < 12 ; $i++){
                Mic::create([
                    'room_id' => $id ,
                    'order' =>  $i + 1,
                    'user_id' => 0,
                    'isClosed' => 0,
                    'isMute' => 0,
                ]);
             }
           }
           return $this -> getRoom($id);
       
        }
    }
}
