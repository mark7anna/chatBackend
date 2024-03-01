<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AgencyMember;
use App\Models\AgencyMemberStatistics;
use App\Models\ChatRoom;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AppUser;
use App\Models\ChargingOpration;
use Carbon\Carbon;
use App\Models\Country;
use App\Models\Themes;
use App\Models\Mic;
use App\Models\Emossions;
use App\Models\Design;
use App\Models\GiftCategory;
use App\Models\GiftTransaction;
use App\Models\Level;
use App\Models\LuckyCase;
use App\Models\Rollet;
use App\Models\RolletUSer;
use App\Models\RoomAdmin;
use App\Models\RoomBlock;
use App\Models\RoomMember;
use App\Models\Wallet;

class ChatRoomController extends Controller
{
    public function index(){
        try{
            $rooms = DB::table('chat_rooms')
            -> join('countries' , 'chat_rooms.country_id' , '=' , 'countries.id')
            -> join('themes' , 'chat_rooms.themeId' , 'themes.id')
            -> join('app_users' , 'chat_rooms.userId' , 'app_users.id')
            -> select('chat_rooms.*' , 'countries.icon as flag' , 'app_users.tag as admin_tag' , 
            'app_users.name as admin_name' , 'app_users.img as admin_img' , 'themes.img as room_bg')
            -> where('state' , '=' , 1)
            -> get();
            
            $data = [] ;
            foreach($rooms as $room){
                $members = RoomMember::where('room_id' , '=' , $room -> id) -> get();
                if(count($members) > 0 ){
                  array_push($data , $room);
                }
            }

            
            return $data ;
        } catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }
        
    }

    public function search($txt){
        try{
            $rooms = DB::table('chat_rooms')
            -> join('countries' , 'chat_rooms.country_id' , '=' , 'countries.id')
            -> join('themes' , 'chat_rooms.themeId' , 'themes.id')
            -> join('app_users' , 'chat_rooms.userId' , 'app_users.id')
            -> select('chat_rooms.*' , 'countries.icon as flag' , 'app_users.tag as admin_tag' , 
            'app_users.name as admin_name' , 'app_users.img as admin_img' , 'themes.img as room_bg') 
            -> where('chat_rooms.tag' , 'like' , '%' .$txt . '%' )
            ->orWhere('chat_rooms.name', 'like', '%' . $txt . '%')
            -> where('state' , '=' , 1)

            ->get();
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
        -> join('themes' , 'chat_rooms.themeId' , 'themes.id')
        -> select('chat_rooms.*' , 'countries.icon as flag' , 'app_users.tag as admin_tag' , 
        'app_users.name as admin_name' , 'app_users.img as admin_img' , 'themes.img as room_bg')
         -> where( 'chat_rooms.id' , '=' , $room_id)
         -> where('chat_rooms.state' , '=' , 1)
          -> first();
          
          if($room){
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
     
     
              foreach( $mics as $mic){
                 $designs = DB::table('design_purchases') 
                 ->join('designs' , 'design_purchases.design_id' , 'designs.id')
                 ->select('designs.*' , 'design_purchases.available_until' , 'design_purchases.count' , 
                 'design_purchases.isDefault' , 'design_purchases.design_cat') -> where('design_purchases.user_id' , '=' , $mic -> user_id)
                 -> where('designs.category_id' , '=' , 4)
                 -> where('design_purchases.isDefault' , '=' , 1)
                 -> get();
                 if(count ($designs) > 0 ){
                       $design = $designs[0];
                       if(Carbon::parse($design -> available_until) -> startOfDay() >= Carbon::now() -> startOfDay()){
                         $mic -> frame =  $designs[0] -> motion_icon  ;
                       } else {
                         $mic -> frame =  ''  ;
                       }
                 } else {
                     $mic -> frame =  ""  ;
                 }
                 
                }
     
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
                
                
                 
     
                foreach( $members as $member){
                 $entering = DB::table('design_purchases') 
                 ->join('designs' , 'design_purchases.design_id' , 'designs.id')
                 ->select('designs.*' , 'design_purchases.available_until' , 'design_purchases.count' , 
                 'design_purchases.isDefault' , 'design_purchases.design_cat') -> where('design_purchases.user_id' , '=' , $member -> user_id)
                 -> where('designs.category_id' , '=' , 5)
                 -> where('design_purchases.isDefault' , '=' , 1) -> get();

                 $pubbling = DB::table('design_purchases') 
                 ->join('designs' , 'design_purchases.design_id' , 'designs.id')
                 ->select('designs.*' , 'design_purchases.available_until' , 'design_purchases.count' , 
                 'design_purchases.isDefault' , 'design_purchases.design_cat') -> where('design_purchases.user_id' , '=' , $member -> user_id)
                 -> where('designs.category_id' , '=' , 6)
                 -> where('design_purchases.isDefault' , '=' , 1) -> get();


                 $banners = DB::table('design_purchases') 
                 ->join('designs' , 'design_purchases.design_id' , 'designs.id')
                 ->select('designs.*' , 'design_purchases.available_until' , 'design_purchases.count' , 
                 'design_purchases.isDefault' , 'design_purchases.design_cat') -> where('design_purchases.user_id' , '=' , $member -> user_id)
                 -> where('designs.category_id' , '=' , 3)
                 -> where('design_purchases.isDefault' , '=' , 1) -> get();
                
                 
                 if(count ($entering) > 0 ){
                       $design = $entering[0];
                       if(Carbon::parse($design -> available_until) -> startOfDay() >= Carbon::now() -> startOfDay()){
                         $member -> entery =  $design -> motion_icon  ;
                         $member -> entery_audio =  $design -> audio_url  ;
                         $member -> entery_name = $design -> name ;
                       } else {
                         $member -> entery =  ''  ;
                         $member -> entery_audio = '' ;
                         $member -> entery_name = '';
                       }
                 } else {
                     $member -> entery =  ""  ;
                     $member -> entery_audio = '' ;
                     $member -> entery_name = '';
                 }
                 
                    
                    
              if( count($pubbling) > 0 ){
                    $design = $pubbling[0];
                    if(Carbon::parse($design -> available_until) -> startOfDay() >= Carbon::now() -> startOfDay()){
                        $member -> pubble =  $design -> motion_icon  ;
                      } else {
                        $member -> pubble =  ''  ;
                      }
                 } else {
                    $member -> pubble =  ''  ;
                 }

                 if( count($banners) > 0 ){
                    $design = $banners[0];
                    if(Carbon::parse($design -> available_until) -> startOfDay() >= Carbon::now() -> startOfDay()){
                        $member -> banner =  $design -> motion_icon  ;
                      } else {
                        $member -> banner =  ''  ;
                      }
                 } else {
                    $member -> banner =  ''  ;
                 }
                 
                 
                }
             
     
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
            
                     //get room cup
     
                     $roomCup = (int) GiftTransaction::Where('room_id' , '=' ,  $room_id) 
                     -> whereDate('sendDate' ,  Carbon::today() )->sum('total');
                   
     
     
     
                    return response()->json(['state' => 'success' , 'room' => $room , 'mics' => $mics , 'members' => $members , 'followers' => $followers ,
                     'admins' => $admins , 'blockers' => $blockers , 'roomCup' => $roomCup]);

          } else {
            return response()->json(['state' => 'failed' , 'message' => 'this Room is Disable']);
          }
       
   
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
            'state' => 1,
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

    public function getRoomBasicData(){
        try{
            $emossions = Emossions::all();
            $themes = Themes::all();
            $gifts = Design::Where('category_id' , '=' , 11) -> get();
            $giftCategories = GiftCategory::where('enable' , '=' , 1) -> orderBy('id', 'asc') -> get();
    
            return response()->json(['state' => 'success' , 'emossions' => $emossions , 'themes' => $themes , 
            'gifts' => $gifts , 'giftCategories' => $giftCategories ]);
        }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }
      

    }

    public function updateRoomName(Request $request){
        try{
            $room = ChatRoom::find($request -> id);
            if($room){
                $room -> update([
                    'name' => $request -> name 
                ]);
                
                return $this -> getRoom($request -> id);

            } else {
                return response()->json(['state' => 'failed' , 'message' => 'Sorry! we can not find this room']); 
            }

        }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }
    }

    public function updateRoomHelloText(Request $request){
        try{
            $room = ChatRoom::find($request -> id);
            if($room){
                $room -> update([
                    'hello_message' => $request -> hello_message 
                ]);
                
                return $this -> getRoom($request -> id);

            } else {
                return response()->json(['state' => 'failed' , 'message' => 'Sorry! we can not find this room']); 
            }

        }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }
    }

    public function updateRoomPassword(Request $request){
        try{
            $room = ChatRoom::find($request -> id);
            if($room){
                $room -> update([
                    'state' => $request -> password == '' ? 0 : 1  ,
                    'password' => $request -> password
                ]);
                
                return $this -> getRoom($request -> id);

            } else {
                return response()->json(['state' => 'failed' , 'message' => 'Sorry! we can not find this room']); 
            }

        }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }
    }

    public function updateRoomImage(Request $request){
        try{
          $room = ChatRoom::find($request -> id);
          if($room){
            if($request -> img){
              $img = time() . '.' . $request->img->extension();
              $request->img->move(('images/Rooms'), $img);
          } else {
              $img = "";
          }
            $room -> update ([
              'img' => $img, 
            ]);
          }
         
           return $this -> getUserData($request -> user_id);
        }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);
  
        }
      }

      public function updateRoomCategory(Request $request){
        try{
            $room = ChatRoom::find($request -> id);
            if($room){
                $room -> update([
                    'subject' => $request -> subject 
                ]);
                
                return $this -> getRoom($request -> id);

            } else {
                return response()->json(['state' => 'failed' , 'message' => 'Sorry! we can not find this room']); 
            }

        }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }
    }



    public function getRoomByAdmin($admin_id){
        try{
            $room = DB::table('chat_rooms')
            -> join('countries' , 'chat_rooms.country_id' , '=' , 'countries.id')
            -> join('app_users' , 'chat_rooms.userId' , 'app_users.id')
            -> join('themes' , 'chat_rooms.themeId' , 'themes.id')
            -> select('chat_rooms.*' , 'countries.icon as flag' , 'app_users.tag as admin_tag' , 
            'app_users.name as admin_name' , 'app_users.img as admin_img' , 'themes.img as room_bg') -> where( 'chat_rooms.userId' , '=' , $admin_id) -> first();
    
            if($room){
                return $this -> getRoom($room -> id);
            } else {
                return response()->json(['state' => 'failed' , 'message' => 'user hase no room']);
     
            }
        } catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }
   
    }

    public function trackUser($user_id){
        try{
            $user = AppUser::find($user_id);
            if($user){
                if($user -> isInRoom > 0){
                                     
                    return $this -> getRoom($user -> isInRoom);

                } else {
                    return response()->json(['state' => 'failed' , 'message' => 'sorry this user does not exsist in any room']);

                }
            } else {
                return response()->json(['state' => 'failed' , 'message' => 'sorry we can not find this user']);
    
            }
            
        }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }
        
    }

    public function enterRoom(Request $request){
      try{
        $user = AppUser::find($request -> user_id);
        $room = ChatRoom::find($request -> room_id);
        if($user && $room){
             
            $user -> update([
               'isInRoom' => $room -> id
            ]);
            $roomMembers = RoomMember::where('room_id' , '=' , $room -> id) -> where('user_id' , '=' , $user -> id) -> get();
            if(count($roomMembers) == 0 ){
                RoomMember::create([
                    'room_id' =>  $room -> id ,
                    'user_id' => $user -> id
                ]);
            }
            return $this -> getRoom($room -> id);


        } else {
            return response()->json(['state' => 'failed' , 'message' => "sorry we can not find the user or the room"]);
        }
      }catch(QueryException $ex){
        return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

      }
    }

    public function exitRoom(Request $request){
        try{
            $user = AppUser::find($request -> user_id);
            $room = ChatRoom::find($request -> room_id);
            if($user && $room){
                 
                $user -> update([
                   'isInRoom' => 0
                ]);
                $roomMembers = RoomMember::where('room_id' , '=' , $room -> id) -> where('user_id' , '=' , $user -> id) -> get();
                if(count($roomMembers) > 0 ){
                    $roomMembers[0] -> delete();
                }
                return $this -> getRoom($room -> id);
    
    
            } else {
                return response()->json(['state' => 'failed' , 'message' => "sorry we can not find the user or the room"]);
            }
          }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);
    
          }
    }

    public function useMic(Request $request){
        try{
            $user = AppUser::find($request -> user_id);
            $room = ChatRoom::find($request -> room_id);
            $mics = Mic::where('room_id' , '=' , $request -> room_id) ->where ('order' , $request -> mic) -> get() ;
            $userMics = Mic::where('room_id' , '=' , $request -> room_id) ->where ('user_id' , $request -> user_id) -> get() ;
             
            if($user && $room){
                if(count($userMics) > 0){
                    $userMic = $userMics[0];
                    $userMic -> update([
                        'user_id'  => 0 ,
                     ]);
                     $talkers_count = $room -> talkers_count - 1 ;
                     $room -> update([
                        'talkers_count' => $talkers_count
                     ]);
                     $this -> updateHostAgencyRecords($request -> user_id , 0);
                }

               if(count($mics) >  0){
                $mic = $mics[0];
                if($mic -> isClosed == 0 && $mic -> user_id == 0){
                    $mic -> update([
                        'user_id'  => $user -> id ,
                    ]);
                     $talkers_count = $room -> talkers_count + 1 ;
                     $room -> update([
                        'talkers_count' => $talkers_count
                     ]);
                     $this -> updateHostAgencyRecords($request -> user_id , 1);
                    return $this -> getRoom($room -> id);

                } else {
                    return response()->json(['state' => 'failed' , 'message' => "sorry this mic is close or not empty"]);

                }

               } else {
                return response()->json(['state' => 'failed' , 'message' => "sorry we can not find the mic"]);

               }
            }else {
                return response()->json(['state' => 'failed' , 'message' => "sorry we can not find the user or the room"]);
            }
        }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);
    
          }
    }
    public function leaveMic(Request $request){
        try{
            $user = AppUser::find($request -> user_id);
            $room = ChatRoom::find($request -> room_id);
            if($request -> mic > 0){
                $mics = Mic::where('room_id' , '=' , $request -> room_id) ->where ('order' , $request -> mic) -> get() ;

            } else {
                $mics = Mic::where('room_id' , '=' , $request -> room_id) ->where ('user_id' , $request -> user_id) -> get() ;

            }

            if($user && $room){
               if(count($mics) >  0){
                $mic = $mics[0];
                
                    $mic -> update([
                       'user_id'  => 0 ,
                       'counter' => 0

                    ]);
                    $talkers_count = $room -> talkers_count - 1 ;
                    $room -> update([
                       'talkers_count' => $talkers_count
                    ]);

                    $this -> updateHostAgencyRecords($request -> user_id , 0);
                    return $this -> getRoom($room -> id);


               } else {
                return response()->json(['state' => 'failed' , 'message' => "sorry we can not find the mic"]);

               }
            }else {
                return response()->json(['state' => 'failed' , 'message' => "sorry we can not find the user or the room"]);
            }
        }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);
    
          }
    }


     //////////////////Host Agency Statics///////////////////////////
     public function updateHostAgencyRecords($user_id , $state){
          try{
            $members = AgencyMember::where('user_id' , '=' , $user_id) -> get();
            if(count($members) > 0){
                //this user is a host agency member let's fill his time sheet
                if($state  == 1){
                    //start a new session 
                    AgencyMemberStatistics::create([
                        'user_id' => $user_id,
                        'agency_id' => $members[0] -> agency_id,
                        'start_time' => Carbon::now(),
                        'end_time' => Carbon::now(),
                        'net_hours' => 0,
                    ]);
                } else {
                    // end up the current session
                    $sessions = AgencyMemberStatistics::Where('user_id' , '=' , $user_id) -> where('net_hours' , '=' , 0) -> get() ;
                    $count = Count($sessions);
                    if($count > 0){
                        $session = $sessions[$count -1] ;
                        $end_time = Carbon::now();
                        $mins = $end_time->diffInMinutes($session -> start_time);
                        $session  -> update([
                            'end_time' => $end_time ,
                            'net_hours' => $mins,
                        ]);
                    }
                }
            } else {
                // this is a normal user let him alone :)
            }
          }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

          }
     }




     ///////////////////////////////////////////////////////////////


    public function lockMic(Request $request){
       try{
        if($request -> mic > 0){
            $mics = Mic::where('room_id' , '=' , $request -> room_id) ->where ('order' , $request -> mic) -> get() ;

        } else {
            $mics = Mic::where('room_id' , '=' , $request -> room_id) -> get() ;

        }
        foreach( $mics as $mic){
            $mic -> update([
                "isClosed" => 1 ,
                "user_id" => 0
            ]);
        }
        return $this -> getRoom($request -> room_id);


       } catch(QueryException $ex){
        return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

      }
    }
    public function unlockMic(Request $request){
        try{
            if($request -> mic > 0){
                $mics = Mic::where('room_id' , '=' , $request -> room_id) ->where ('order' , $request -> mic) -> get() ;
    
            } else {
                $mics = Mic::where('room_id' , '=' , $request -> room_id) -> get() ;
    
            }
            foreach( $mics as $mic){
                $mic -> update([
                    "isClosed" => 0 ,
                    "user_id" => 0
                ]);
            }
            return $this -> getRoom($request -> room_id);
    
    
           } catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);
    
          }
    }
    
    public function chnageRoomBg(Request $request){
        try{
         
           $room = ChatRoom::find($request -> room_id);
           $bg = Themes::find($request -> bg);
           if($room && $bg){
            $room -> update([
              'themeId' =>  $bg  -> id 
            ]);
            
            return $this -> getRoom($request -> room_id);
           } else {
            return response()->json(['state' => 'failed' , 'message' => "sorry we can not find the room or theme"]);

           }
         
    
    
           } catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);
    
          }
    }

    public function getRoomCup($room_id){
        try{
            // $daily = DB::table('gift_transactions') -> 
            // join('app_users' , 'app_users.id' , 'gift_transactions.sender_id')
            // ->leftJoin('levels as share_level' ,function ($join) {
            //     $join->on('app_users.share_level_id', '=', 'share_level.id');
            //     })->leftJoin('levels as karizma_level' ,function ($join) {
            //         $join->on('app_users.karizma_level_id', '=', 'karizma_level.id');
            //     }) 
            //     ->leftJoin('levels as charging_level' ,function ($join) {
            //         $join->on('app_users.charging_level_id', '=', 'charging_level.id');
            //     })
            
            // -> select('gift_transactions.*' , 'app_users.name as sender_name' , 'app_users.tag as sender_tag' ,
            // 'app_users.img as sender_img' , 'share_level.icon  as sender_share_level' , 
            // 'karizma_level.icon as sender_karizma_level' , 'charging_level.icon as sender_karizma_level')
            //  -> where('gift_transactions.room_id' , '=' , $room_id)
            //  -> whereDate('sendDate' ,  Carbon::today() ) -> get();
            
            $daily = GiftTransaction::Where('room_id' , '=' ,  $room_id) 
            -> whereDate('sendDate' ,  Carbon::today() ) 
             -> groupBy('sender_id') ->selectRaw('sender_id, sum(total) as sum') 
             -> orderBy('sum' , 'DESC')
             -> get();

             $weekly = GiftTransaction::Where('room_id' , '=' ,  $room_id) 
             -> whereBetween('sendDate', [Carbon::now() -> subDays(7), Carbon::now()])
              -> groupBy('sender_id') ->selectRaw('sender_id, sum(total) as sum') 
              -> orderBy('sum' , 'DESC')
              -> get();

              $fromDate = Carbon::now()-> subDays(30);
              $tillDate = Carbon::now();

              $monthly = GiftTransaction::Where('room_id' , '=' ,  $room_id) 
              -> whereBetween('sendDate', [ $fromDate ,  $tillDate ])
               -> groupBy('sender_id') ->selectRaw('sender_id, sum(total) as sum')
               -> orderBy('sum' , 'DESC')
               -> get();

              return response()->json(['state' => 'success' , 'daily' => $daily , 'weekly' => $weekly , 'monthly' => $monthly]);


        }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);
 
        }
    }

    public function getAppCup(){
        try{
            //daily , weekly , monthly , 
               //bigger sender , bigger reciver , bigger room

               $fromDate = Carbon::now()-> subDays(30);
               $tillDate = Carbon::now();

            $daily = GiftTransaction::whereDate('sendDate' ,  Carbon::today() ) 
             -> groupBy('sender_id') ->selectRaw('sender_id, sum(total) as sum')  -> orderBy('sum' , 'DESC') -> get();
             $weekly = GiftTransaction::whereBetween('sendDate', [Carbon::now() -> subDays(7), Carbon::now()])
              -> groupBy('sender_id') ->selectRaw('sender_id, sum(total) as sum')  -> orderBy('sum' , 'DESC') -> get();
              $monthly = GiftTransaction::whereBetween('sendDate', [ $fromDate ,  $tillDate ])
               -> groupBy('sender_id') ->selectRaw('sender_id, sum(total) as sum')  -> orderBy('sum' , 'DESC') -> get();


               $dailyK = GiftTransaction::whereDate('sendDate' ,  Carbon::today() ) 
               -> groupBy('receiver_id') ->selectRaw('receiver_id, sum(total) as sum')  -> orderBy('sum' , 'DESC') -> get();
               $weeklyK = GiftTransaction::whereBetween('sendDate', [Carbon::now() -> subDays(7), Carbon::now()])
                -> groupBy('receiver_id') ->selectRaw('receiver_id, sum(total) as sum')  -> orderBy('sum' , 'DESC') -> get();
                $monthlyK = GiftTransaction::whereBetween('sendDate', [ $fromDate ,  $tillDate ])
                 -> groupBy('receiver_id') ->selectRaw('receiver_id, sum(total) as sum')  -> orderBy('sum' , 'DESC') -> get();  
                 
                 $dailyR = GiftTransaction::whereDate('sendDate' ,  Carbon::today() ) 
                 -> groupBy('room_id') ->selectRaw('room_id, sum(total) as sum')  -> orderBy('sum' , 'DESC') -> get();
                 $weeklyR = GiftTransaction::whereBetween('sendDate', [Carbon::now() -> subDays(7), Carbon::now()])
                  -> groupBy('room_id') ->selectRaw('room_id, sum(total) as sum')  -> orderBy('sum' , 'DESC') -> get();
                  $monthlyR = GiftTransaction::whereBetween('sendDate', [ $fromDate ,  $tillDate ])
                   -> groupBy('room_id') ->selectRaw('room_id, sum(total) as sum')  -> orderBy('sum' , 'DESC') -> get(); 

            // if(count($daily) > 0)    {
            //     $dailyFan = $daily[0];
            //     $user = $this -> getUserData($dailyFan -> sender_id);
            //     $dailyFan -> user = $user ;
            // } else {
            //     $dailyFan = null ;
            // }
            $dailyFans = [] ;

            for($i = 0 ; $i < count($daily) ; $i++){
                    $dailyFan = $daily[$i];
                    $user = $this -> getUserData($dailyFan -> sender_id);
                    $dailyFan -> user = $user ; 
                    array_push($dailyFans ,  $dailyFan);
                  
            }


            $weekFans = [] ;

            for($i = 0 ; $i < count($weekly) ; $i++){
                $weekFan = $weekly[$i];
                $user = $this -> getUserData($weekFan -> sender_id);
                $weekFan -> user = $user ;
                array_push($weekFans ,  $weekFan);
              
               }

               $monthFans = [] ;

               for($i = 0 ; $i < count($monthly) ; $i++){
                   $monthFan = $monthly[$i];
                   $user = $this -> getUserData($monthFan -> sender_id);
                   $monthFan -> user = $user ;
                   array_push($monthFans ,  $monthFan);
                 
                  }

                  $dailyFanKs = [] ;

                  for($i = 0 ; $i < count($dailyK) ; $i++){
                    $dailyFanK = $dailyK[$i];
                    $user = $this -> getUserData($dailyFanK -> receiver_id);
                    $dailyFanK -> user = $user ;
                      array_push($dailyFanKs ,  $dailyFanK);
                    
                     
                    }
                    $weekFanKs = [] ;

                    for($i = 0 ; $i < count($weeklyK) ; $i++){
                        $weekFanK = $weeklyK[$i];
                        $user = $this -> getUserData($weekFanK -> receiver_id);
                        $weekFanK -> user = $user ;
                        array_push($weekFanKs ,  $weekFanK);

                    }

                    $monthFanKs = [] ;

                    for($i = 0 ; $i < count($monthlyK) ; $i++){
                        $monthFanK = $monthlyK[$i];
                        $user = $this -> getUserData($monthFanK -> receiver_id);
                        $monthFanK -> user = $user ;
                        array_push($monthFanKs ,  $monthFanK);

                    }

                    $dailyRooms = [] ;

                    for($i = 0 ; $i < count($dailyR) ; $i++){
                        $dailyRoom = $dailyR[$i];
                        $room = ChatRoom::find($dailyRoom -> room_id);
                        $admin = Appuser::find($room -> userId);
                        $room -> admin_img = $admin -> img ; 
                        $dailyRoom -> room = $room ;
                        array_push($dailyRooms ,  $dailyRoom);

                    }

                    $weeklyRs = [] ;

                    for($i = 0 ; $i < count($weeklyR) ; $i++){
                        $weekRoom = $weeklyR[$i];
                        $room = ChatRoom::find($weekRoom -> room_id);
                        $admin = Appuser::find($room -> userId);
                        $room -> admin_img = $admin -> img ; 
                        $weekRoom -> room = $room ;
                        array_push($weeklyRs ,  $weekRoom);

                    }
                    

                    $monthRooms = [] ;

                    for($i = 0 ; $i < count($monthlyR) ; $i++){
                        $monthRoom = $monthlyR[$i];
                        $room = ChatRoom::find($monthRoom -> room_id);
                        $admin = Appuser::find($room -> userId);
                        $room -> admin_img = $admin -> img ; 
                        $monthRoom -> room = $room ;
                        array_push($monthRooms ,  $monthRoom);

                    }
                      
                
    

            

              return response()->json(['state' => 'success' , 
              'dailyFans' => $dailyFans , 'weekFans' => $weekFans , 'monthFans' => $monthFans ,
              'dailyFanKs' => $dailyFanKs , 'weekFanK' => $weekFanKs , 'monthFanKs' => $monthFanKs,
              'dailyRooms' => $dailyRooms , 'weeklyRs' => $weeklyRs , 'monthRooms' => $monthRooms]);
        }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);
 
        }
    }

    public function getUserData ($id) {
        try{
          $users = DB::table('app_users')
          -> join('wallets' , 'app_users.id' , '=','wallets.user_id')
          -> join('levels as share_level' , 'share_level.id' , '=' , 'app_users.share_level_id' )
          -> join('levels as karizma_level' , 'karizma_level.id' , '=' , 'app_users.karizma_level_id' )
          -> join('levels as charging_level' , 'charging_level.id' , '=' , 'app_users.charging_level_id')
          -> join('countries' , 'countries.id' , '=' , 'app_users.country')
  
          -> select('app_users.*' , 'wallets.gold' , 'wallets.diamond' , 
          'share_level.order as share_level_order' , 'share_level.points as share_level_points' , 'share_level.icon as share_level_icon' ,
          'karizma_level.order as karizma_level_order' , 'karizma_level.points as karizma_level_points' , 'karizma_level.icon as karizma_level_icon' ,
          'charging_level.order as charging_level_order' , 'charging_level.points as charging_level_points' , 'charging_level.icon as charging_level_icon' ,
          'countries.name as country_name' , 'countries.icon as country_flag') 
          -> where('app_users.id' , '=' , $id)-> get();
  
  
                  if(count($users) > 0){
                   return  $user = $users[0] ;
                   return $user ;

                  } else {
                        return null ;
    }
          
        } catch(QueryException $ex){
            return null ;
  
        }
  
  
      }

    public function addRoomAdmin(Request $request){
        try{
            $user = AppUser::find($request -> user_id);
            $room = ChatRoom::find($request -> room_id);
            if($user && $room){
                 $admins = RoomAdmin::where('room_id' , '=' , $request -> room_id)
                 -> where('user_id' , '=' , $request -> user_id ) -> get();
                 if(count($admins) == 0){
                    RoomAdmin::create([
                        'room_id' => $request -> room_id,
                        'user_id' => $request -> user_id
                    ]);
                    
                    return $this -> getRoom($request -> room_id);
                 } else {
                    return response()->json(['state' => 'failed' , 'message' => 'this user is already an admin in this room']); 
                 }
                 

            } else {
                return response()->json(['state' => 'failed' , 'message' => 'can not find the user or the room']); 
            }

        } catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }

    }

    public function removeRoomAdmin(Request $request){
        try{
            $user = AppUser::find($request -> user_id);
            $room = ChatRoom::find($request -> room_id);
            if($user && $room){
                 $admins = RoomAdmin::where('room_id' , '=' , $request -> room_id)
                 -> where('user_id' , '=' , $request -> user_id ) -> get();
                 if(count($admins) >  0){
                    $admins[0] -> delete();
                    
                    return $this -> getRoom($request -> room_id);
                 } else {
                    return response()->json(['state' => 'failed' , 'message' => 'this user is already an admin in this room']); 
                 }
                 

            } else {
                return response()->json(['state' => 'failed' , 'message' => 'can not find the user or the room']); 
            }

        } catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }

    }
    public function toggleCounter($room_id ){
         try{
            $room = ChatRoom::find($room_id);
            if($room){
                $room -> update([
                   'isCounter' => $room -> isCounter == 0 ? 1 : 0 
                ]);
                return $this -> getRoom($room_id);
            } else {
                return response()->json(['state' => 'failed' , 'message' => 'can not find  the room']); 

            }

         }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);
        }

    }

    public function blockRoomMember(Request $request){
       try{
          $user = AppUser::find($request -> user_id);
          $room = ChatRoom::find($request -> room_id);
          if($user && $room){
            $until = Carbon::now() ;
            if($request ->block_type == "HOUR"){
                $until = Carbon::now() -> addHours(1);
            }  else if($request ->block_type == "DAY"){
                $until = Carbon::now() -> addDays(1);
            } else {
                $until = Carbon::now() -> addYears(1);
            }
            RoomBlock::create([
                'room_id' => $request ->room_id ,
                'user_id' => $request ->user_id ,
                'blocked_date' => Carbon::now(),
                'block_type' => $request ->block_type ,
                'block_until' =>  $until
            ]);
            
            return $this -> getRoom($request -> room_id);
          }else {
            return response()->json(['state' => 'failed' , 'message' => 'can not find  the room or the user']); 
          }
            
          
       }catch(QueryException $ex){
        return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);
        }
         
    }

    public function unBlockRoomMember(Request $request){
      try{
        $user = AppUser::find($request -> user_id);
        $room = ChatRoom::find( $request -> room_id);
        $block = RoomBlock::where('room_id' , '=' , $request -> room_id) 
        -> where('user_id' , '=' , $request -> user_id)-> get();
        if($user && $room ){
            if(count($block) > 0)
            $block[0] -> delete();
            return $this -> getRoom($request -> room_id);

           
        }else{
            return response()->json(['state' => 'failed' , 'message' => 'can not find  the room or the user']); 
        }
      }catch(QueryException $ex){
        return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);
        }
    }

    public function createLuckyCase(Request $request){
      try{
        $room = ChatRoom::find($request -> room_id);
        $user = AppUser::find($request -> user_id);
        if( $room && $user){
            $lucky =   LuckyCase::create([
                'type' => $request -> type,
                'value' => $request -> value,
                'user_id' => $request -> user_id,
                'room_id' => $request -> room_id,
                'out_value' => 0,
                'created_date' => Carbon::now()
            ]);

            return response()->json(['state' => 'success' , 'lucky' => $lucky]); 
 
        
        } else {
            return response()->json(['state' => 'failed' , 'message' => 'can not find  the room or the user']); 
        }

      }catch(QueryException $ex){
        return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);
        }
    }

    public function useLuckyCase(Request $request){
        try{
            $room = ChatRoom::find($request -> room_id);
            $user = AppUser::find($request -> user_id);
            $lucky = LuckyCase::find($request -> lucky_id);
            if($room && $user && $lucky){
                 if(($lucky -> out_value + $request -> value) <= $lucky -> value){
                    $lucky -> update([
                       'out_value' => $lucky -> out_value + $request -> value
                    ]);

                    $wallets = Wallet::where('user_id' , '=' , $request -> user_id) -> get();
                    if(count( $wallets) > 0){
                        $wallet =  $wallets[0];
                        $wallet -> update([
                           'gold' => $wallet -> gold + $request -> value
                        ]);
                    }

                    ChargingOpration::create([
                        'user_id' => $request -> user_id ,
                        'gold' => $request -> value,
                        'source' => "LUCKY CASE",
                        'state' => 1,
                        'charging_date' => Carbon::now()
                    ]);
                    $this -> checkToUp( $request -> user_id);
                    $lucky = LuckyCase::find($request -> lucky_id);
                    return response()->json(['state' => 'success' , 'lucky' => $lucky]); 

                 } else {
                    return response()->json(['state' => 'failed' , 'message' => 'case is empty !']); 

                 }

            } else {
                return response()->json(['state' => 'failed' , 'message' => 'can not find  the room or the user or the lucky case']); 

            }
        }catch(QueryException $ex){
        return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);
        }
    }

    public function checkToUp($user_id){
        try{
            $user = AppUser::find($user_id);
            if($user){
                $operations = ChargingOpration::where('user_id' , '=' , $user_id) -> get();
                $current_level = Level::find($user -> charging_level_id);
                $totalChargeValue = 0 ;
                $up_level = 0 ;
                foreach( $operations as  $operation){
                    $totalChargeValue  +=  $operation -> gold ;
                }
                if($current_level -> points > $totalChargeValue){
                    //do no thing
                    return 'not upgrade';
                } else {
                    $up_level = Level::Where('type' , '=' , 2) 
                    -> where('points' , '>=' ,$totalChargeValue )  ->orderBy('points', 'ASC') -> get()[0] -> id;
                 $user -> update([
                    'charging_level_id' => $up_level 
                 ]);
                }




            }
        } catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }
    }

    public function CreateRollet(Request $request){
        try{
            $room = ChatRoom::find($request -> room_id);
            $user = AppUser::find($request -> user_id);
            if($room && $user){
                $activeRollets = Rollet::where('room_id' , '=' , $request -> room_id)
                -> where('state' , '<' , 2)
                -> get();
                if(count($activeRollets) == 0){
                    //create rollet
                    $id =Rollet::create([
                        'room_id' => $request -> room_id,
                        'type' => $request -> type,
                        'value' =>  $request -> value,
                        'member_count' =>  $request -> adminShare ,
                        'actual_member_count' => $request -> adminShare  ,
                        'adminShare' => $request -> adminShare,
                        'state' => 0,
                        'winner_id' => 0
                    ]) -> id;
                    if($id > 0){
                         if($request -> adminShare == 1){

                         return  $this -> addUserToRollet(  $id , $request -> user_id);
                
                         } else {
                           return $this -> getRollet($id );

                         }
                    }
                } else {
                    //show rollet
                    $rolletID =  $activeRollets[0] -> id ;
                     return $this -> getRollet($rolletID );
                }


            } else {
                return response()->json(['state' => 'failed' , 'message' => 'can not find  the room or the user']); 

            }

        }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }

    }


    public function getRollet($rolletID){
       
        $rollet = DB::table('rollets')
         -> leftJoin('rollet_u_sers' , 'rollets.id' , '=' , 'rollet_u_sers.rollet_id')
         ->join('app_users' ,function ($join) {
            $join->on('app_users.id', '=', 'rollet_u_sers.user_id');
           })-> select('rollets.*' , 'rollet_u_sers.id as rollet_user_id' , 'app_users.name as user_name' ,
           'app_users.img as user_img')
           -> where('rollets.id' , '=' ,  $rolletID ) -> get();
           if( $rollet -> state == 0 ){
            $rollet_state = 'PENDING' ;
           } else if($rollet -> state == 1){
            $rollet_state = 'RUNNING' ;
           } else {
            $rollet_state = "";
           }
           

        return response()->json(['state' => 'success' , 'rollet' => $rollet , 'rollet_state' => $rollet_state]); 
    }

    public function addUserToRollet($rollet_id , $user_id ){
        try{
            $rollet = Rollet::find($rollet_id);
            if($rollet){
                if($rollet -> actual_member_count < $rollet -> member_count){
                    $member_id =  RolletUSer::create([
                        'rollet_id' => $rollet_id,
                        'user_id' => $user_id
                    ]) -> id;

                    if($member_id > 0){
                        $wallets = Wallet::where('user_id' , '=' , $user_id) -> get();
                        if(count ( $wallets) > 0){
                            $wallet =  $wallets[0];
                            $wallet -> update([
                                 'gold' => $wallet -> gold - $rollet -> value
                            ]);
                        }
                    }
                    $rollet -> update([
                        $rollet -> actual_member_count => $rollet -> actual_member_count + 1
                    ]);

                       return $this -> getRollet($rollet -> id);

                } else {
                    return response()->json(['state' => 'failed' , 'message' => 'can not add user to the full rollet']); 

                }
            }

        
    
         
        }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }
 
    }

    public function deleteRollet($rollet_id ){
       try{
         $rollet = Rollet::find($rollet_id);
         if($rollet ){
            $users = RolletUSer::where('rollet_id' , '=' , $rollet_id) -> get();
            foreach($users as $user){
                $wallets = Wallet::where('user_id' , '=' , $user -> user_id) -> get();
                $wallet = $wallets[0];
                $wallet -> update([
                    'gold' => $wallet -> gold + $rollet -> value
                ]);
                
            }
            $rollet -> delete();
            return response()->json(['state' => 'success' , 'message' => 'rollet deleted successfully']);

         }
       }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }
    }

    public function StartRollet($rollet_id){
        try{
            $rollet = Rollet::find($rollet_id);
            if($rollet){
                $rollet -> update([
                    'state' => 1
                ]);
                return $this -> getRollet($rollet -> id);
            } else {
                return response()->json(['state' => 'failed' , 'message' => 'can not find the rollet']); 

            }

        }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }

    }

    public function rolletLoser($rollet_id , $loser){
        try{
            $rollet = Rollet::find($rollet_id);
            if($rollet){
                $members = RolletUSer::Where('user_id' , '=' , $loser) -> get();
                if(count( $members) > 0){
                   $member = $members[0];
                   $member -> delete();
                } 
               
                return $this -> endRollet($rollet -> id);
            } else {
                return response()->json(['state' => 'failed' , 'message' => 'can not find the rollet']); 

            }

        }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }
    }
    public function endRollet($rollet_id){
        try{
            $rollet = Rollet::find($rollet_id);
            if($rollet){
                $members = RolletUSer::Where('rollet_id' , '=' , $rollet_id) -> get();
                if(count( $members) == 1){
                   $winner = $members[0];
                   $rollet -> update([
                    'winner_id' => $winner -> user_id ,
                    'state' => 2
                   ]);
                   $winner -> delete();
                } 
               
                return $this -> getRollet($rollet -> id);
            } else {
                return response()->json(['state' => 'failed' , 'message' => 'can not find the rollet']); 

            }

        }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }

    }

}
