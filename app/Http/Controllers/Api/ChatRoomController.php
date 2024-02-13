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
use App\Models\Emossions;
use App\Models\Design;
use App\Models\GiftCategory;
use App\Models\RoomMember;

class ChatRoomController extends Controller
{
    public function index(){
        try{
            $rooms = DB::table('chat_rooms')
            -> join('countries' , 'chat_rooms.country_id' , '=' , 'countries.id')
            -> join('themes' , 'chat_rooms.themeId' , 'themes.id')
            -> join('app_users' , 'chat_rooms.userId' , 'app_users.id')
            -> select('chat_rooms.*' , 'countries.icon as flag' , 'app_users.tag as admin_tag' , 
            'app_users.name as admin_name' , 'app_users.img as admin_img' , 'themes.img as room_bg') -> get();
            return $rooms ;
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
        -> join('themes' , 'chat_rooms.themeId' , 'themes.id')
        -> select('chat_rooms.*' , 'countries.icon as flag' , 'app_users.tag as admin_tag' , 
        'app_users.name as admin_name' , 'app_users.img as admin_img' , 'themes.img as room_bg') -> where( 'chat_rooms.id' , '=' , $room_id) -> first();

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

    public function getRoomByAdmin($admin_id){
        try{
            $room = DB::table('chat_rooms')
            -> join('countries' , 'chat_rooms.country_id' , '=' , 'countries.id')
            -> join('app_users' , 'chat_rooms.userId' , 'app_users.id')
            -> join('themes' , 'chat_rooms.themeId' , 'themes.id')
            -> select('chat_rooms.*' , 'countries.icon as flag' , 'app_users.tag as admin_tag' , 
            'app_users.name as admin_name' , 'app_users.img as admin_img' , 'themes.img as room_bg') -> where( 'chat_rooms.userId' , '=' , $admin_id) -> first();
    
            if($room){
                $room_id = $room  -> id ;
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

            if($user && $room){
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
                    ]);
                    $talkers_count = $room -> talkers_count - 1 ;
                    $room -> update([
                       'talkers_count' => $talkers_count
                    ]);

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

}
