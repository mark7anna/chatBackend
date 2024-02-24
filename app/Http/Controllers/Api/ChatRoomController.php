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
use Carbon\Carbon;
use App\Models\Country;
use App\Models\Themes;
use App\Models\Mic;
use App\Models\Emossions;
use App\Models\Design;
use App\Models\GiftCategory;
use App\Models\GiftTransaction;
use App\Models\RoomAdmin;
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
            $designs = DB::table('design_purchases') 
            ->join('designs' , 'design_purchases.design_id' , 'designs.id')
            ->select('designs.*' , 'design_purchases.available_until' , 'design_purchases.count' , 
            'design_purchases.isDefault' , 'design_purchases.design_cat') -> where('design_purchases.user_id' , '=' , $member -> user_id)
            -> where('designs.category_id' , '=' , 5)
            -> where('design_purchases.isDefault' , '=' , 1)
            -> get();
            if(count ($designs) > 0 ){
                  $design = $designs[0];
                  if(Carbon::parse($design -> available_until) -> startOfDay() >= Carbon::now() -> startOfDay()){
                    $member -> entery =  $designs[0] -> motion_icon  ;
                  } else {
                    $member -> entery =  ''  ;
                  }
            } else {
                $member -> entery =  ""  ;
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

                $transactions = GiftTransaction::Where('room_id' , '=' ,  $room_id) -> get();

                $roomCup = (int) GiftTransaction::Where('room_id' , '=' ,  $room_id) 
                -> whereDate('sendDate' ,  Carbon::today() )->sum('total');




               return response()->json(['state' => 'success' , 'room' => $room , 'mics' => $mics , 'members' => $members , 'followers' => $followers ,
                'admins' => $admins , 'blockers' => $blockers , 'roomCup' => $roomCup]);
   
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
                // $room_id = $room  -> id ;
                // $mics = DB::table('mics')
                // -> leftJoin('app_users' , 'mics.user_id' , '=' , 'app_users.id')
                // ->leftJoin('levels as share_level' ,function ($join) {
                //  $join->on('app_users.share_level_id', '=', 'share_level.id');
                //  })->leftJoin('levels as karizma_level' ,function ($join) {
                //      $join->on('app_users.karizma_level_id', '=', 'karizma_level.id');
                //  }) 
                //  ->leftJoin('levels as charging_level' ,function ($join) {
                //      $join->on('app_users.charging_level_id', '=', 'charging_level.id');
                //  }) -> select('mics.*' , 'app_users.tag as mic_user_tag' , 'app_users.name as mic_user_name' ,
                //  'app_users.img as mic_user_img' , 'app_users.gender as mic_user_gender' , 'app_users.birth_date as mic_user_birth_date' ,
                //  'share_level.icon as mic_user_share_level' , 'karizma_level.icon as mic_user_karizma_level' ,
                //   'charging_level.icon as mic_user_charging_level') 
                //   -> where('mics.room_id' , '=' , $room_id)-> get();
         
                //   $members = DB::table('room_members')
                //   -> leftJoin('app_users' , 'room_members.user_id' , '=' , 'app_users.id')
                //   ->leftJoin('levels as share_level' ,function ($join) {
                //    $join->on('app_users.share_level_id', '=', 'share_level.id');
                //    })->leftJoin('levels as karizma_level' ,function ($join) {
                //        $join->on('app_users.karizma_level_id', '=', 'karizma_level.id');
                //    }) 
                //    ->leftJoin('levels as charging_level' ,function ($join) {
                //        $join->on('app_users.charging_level_id', '=', 'charging_level.id');
                //    }) -> select('room_members.*' , 'app_users.tag as mic_user_tag' , 'app_users.name as mic_user_name' ,
                //    'app_users.img as mic_user_img' , 'app_users.gender as mic_user_gender' , 'app_users.birth_date as mic_user_birth_date' ,
                //    'share_level.icon as mic_user_share_level' , 'karizma_level.icon as mic_user_karizma_level' ,
                //     'charging_level.icon as mic_user_charging_level') 
                //     -> where('room_members.room_id' , '=' , $room_id)-> get();
         
                //     $admins = DB::table('room_admins')
                //     -> leftJoin('app_users' , 'room_admins.user_id' , '=' , 'app_users.id')
                //     ->leftJoin('levels as share_level' ,function ($join) {
                //      $join->on('app_users.share_level_id', '=', 'share_level.id');
                //      })->leftJoin('levels as karizma_level' ,function ($join) {
                //          $join->on('app_users.karizma_level_id', '=', 'karizma_level.id');
                //      }) 
                //      ->leftJoin('levels as charging_level' ,function ($join) {
                //          $join->on('app_users.charging_level_id', '=', 'charging_level.id');
                //      }) -> select('room_admins.*' , 'app_users.tag as mic_user_tag' , 'app_users.name as mic_user_name' ,
                //      'app_users.img as mic_user_img' , 'app_users.gender as mic_user_gender' , 'app_users.birth_date as mic_user_birth_date' ,
                //      'share_level.icon as mic_user_share_level' , 'karizma_level.icon as mic_user_karizma_level' ,
                //       'charging_level.icon as mic_user_charging_level') 
                //       -> where('room_admins.room_id' , '=' , $room_id)-> get();
         
                //       $followers = DB::table('room_follows')
                //       -> leftJoin('app_users' , 'room_follows.user_id' , '=' , 'app_users.id')
                //       ->leftJoin('levels as share_level' ,function ($join) {
                //        $join->on('app_users.share_level_id', '=', 'share_level.id');
                //        })->leftJoin('levels as karizma_level' ,function ($join) {
                //            $join->on('app_users.karizma_level_id', '=', 'karizma_level.id');
                //        }) 
                //        ->leftJoin('levels as charging_level' ,function ($join) {
                //            $join->on('app_users.charging_level_id', '=', 'charging_level.id');
                //        }) -> select('room_follows.*' , 'app_users.tag as mic_user_tag' , 'app_users.name as mic_user_name' ,
                //        'app_users.img as mic_user_img' , 'app_users.gender as mic_user_gender' , 'app_users.birth_date as mic_user_birth_date' ,
                //        'share_level.icon as mic_user_share_level' , 'karizma_level.icon as mic_user_karizma_level' ,
                //         'charging_level.icon as mic_user_charging_level') 
                //         -> where('room_follows.room_id' , '=' , $room_id)-> get();
         
                //      $blockers = DB::table('room_blocks')
                //       -> leftJoin('app_users' , 'room_blocks.user_id' , '=' , 'app_users.id')
                //       ->leftJoin('levels as share_level' ,function ($join) {
                //        $join->on('app_users.share_level_id', '=', 'share_level.id');
                //        })->leftJoin('levels as karizma_level' ,function ($join) {
                //            $join->on('app_users.karizma_level_id', '=', 'karizma_level.id');
                //        }) 
                //        ->leftJoin('levels as charging_level' ,function ($join) {
                //            $join->on('app_users.charging_level_id', '=', 'charging_level.id');
                //        }) -> select('room_blocks.*' , 'app_users.tag as mic_user_tag' , 'app_users.name as mic_user_name' ,
                //        'app_users.img as mic_user_img' , 'app_users.gender as mic_user_gender' , 'app_users.birth_date as mic_user_birth_date' ,
                //        'share_level.icon as mic_user_share_level' , 'karizma_level.icon as mic_user_karizma_level' ,
                //         'charging_level.icon as mic_user_charging_level') 
                //         -> where('room_blocks.room_id' , '=' , $room_id)-> get();


                        
                // $roomCup = GiftTransaction::Where('room_id' , '=' ,  $room_id) 
                // -> whereDate('sendDate' ,  Carbon::today() )->sum('total');
                
                //         return response()->json(['state' => 'success' , 'room' => $room , 'mics' => $mics , 'members' => $members , 'followers' => $followers ,
                //          'admins' => $admins , 'blockers' => $blockers , 'roomCup' => $roomCup]);
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

            if(count($daily) > 0)    {
                $dailyFan = $daily[0];
                $user = $this -> getUserData($dailyFan -> sender_id);
                $dailyFan -> user = $user ;
            } else {
                $dailyFan = null ;
            }
            if(count($weekly) > 0)    {
                $weekFan = $weekly[0];
                $user = $this -> getUserData($weekFan -> sender_id);
                $weekFan -> user = $user ;
            } else {
                $weekFan = null ;
            }
            if(count($monthly) > 0)    {
                $monthFan = $monthly[0];
                $user = $this -> getUserData($monthFan -> sender_id);
                $monthFan -> user = $user ;
            } else {
                $monthFan = null ;
            }


            if(count($dailyK) > 0)    {
                $dailyFanK = $dailyK[0];
                $user = $this -> getUserData($dailyFanK -> receiver_id);
                $dailyFanK -> user = $user ;
            } else {
                $dailyFanK = null ;
            }
            if(count($weeklyK) > 0)    {
                $weekFanK = $weeklyK[0];
                $user = $this -> getUserData($weekFanK -> receiver_id);
                $weekFanK -> user = $user ;
            } else {
                $weekFanK = null ;
            }
            if(count($monthlyK) > 0)    {
                $monthFanK = $monthlyK[0];
                $user = $this -> getUserData($monthFanK -> receiver_id);
                $monthFanK -> user = $user ;
            } else {
                $monthFanK = null ;
            }

            
            if(count($dailyR) > 0)    {
                $dailyRoom = $dailyR[0];
                $room = ChatRoom::find($dailyRoom -> room_id);
                $dailyRoom -> room = $room ;
            } else {
                $dailyRoom = null ;
            }
            if(count($weeklyR) > 0)    {
                $weekRoom = $weeklyR[0];
                $room = ChatRoom::find($weekRoom -> room_id);
                $weekRoom -> room = $room ;
            } else {
                $weekRoom = null ;
            }
            if(count($monthlyR) > 0)    {
                $monthRoom = $monthlyR[0];
                $room = ChatRoom::find($monthRoom -> room_id);
                $monthRoom -> room = $room ;
            } else {
                $monthRoom = null ;
            }

            

        


              return response()->json(['state' => 'success' , 
              'dailyFan' => $dailyFan , 'weekFan' => $weekFan , 'monthFan' => $monthFan ,
              'dailyFanK' => $dailyFanK , 'weekFanK' => $weekFanK , 'monthFanK' => $monthFanK ,
              'dailyRoom' => $dailyRoom , 'weekRoom' => $weekRoom , 'monthRoom' => $monthRoom]);
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

}
