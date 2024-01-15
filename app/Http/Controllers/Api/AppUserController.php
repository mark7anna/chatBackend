<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AppUser;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Auth\Events\Login;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppUserController extends Controller
{
    public function Register(Request $request){
       $tag = (int)(date('Ymd') . rand(1, 100));
       $share_level_id =  DB::table('levels') -> where('type' , '=' , 0) ->orderBy('id', 'asc')->first() -> id;
       $karizma_level_id =  DB::table('levels') -> where('type' , '=' , 1) ->orderBy('id', 'asc')->first() -> id;
       $charging_level_id =  DB::table('levels') -> where('type' , '=' , 2) ->orderBy('id', 'asc')->first() -> id;
       if($request -> name){
           // create app user object 
        try{
         $user = AppUser::create([
            'tag' => $tag,
            'name' => $request -> name,
            'img' => $request -> img ?? "",
            'share_level_id' => $share_level_id,
            'karizma_level_id' => $karizma_level_id,
            'charging_level_id' =>$charging_level_id ,
            'phone' => $request -> phone ?? "",
            'email' => $request -> email ?? "",
            'password' => $request -> password ?? "",
            'isChargingAgent' => 0,
            'isHostingAgent' => 0,
            'registered_at' => Carbon::now(),
            'last_login'  => Carbon::now(),
            'birth_date' => Carbon::parse("1/1/2000"),
            'enable' => 1,
            'ipAddress' => $request -> ipAddress,
            'macAddress' => $request -> macAddress,
            'deviceId' => $request -> deviceId,
            'isOnline' => 1,
            'isInRoom' => 0,
            'country' => 0,
            'register_with' => $request -> register_with
           ]);

           if($user){
              // create wallet for the user
              Wallet::create([
                'user_id' => $user -> id,
                'gold' => 0,
                'diamond' => 0
              ]);

               return $this -> getUserData($user -> id);
           } else {
            return response()->json(['state' => 'failed' , 'message' => 'User not Created !!']);
           }
           return $user ;
        } catch(QueryException $ex){

            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);
            

        }
  
       } else {
        return response()->json(['state' => 'failed' , 'message' => 'Full Name is Required']);
       }
    }

    public function Login($user , Request $request){
      try{
         $user -> update([
            'last_login'  => Carbon::now(),
            'ipAddress' => $request -> ipAddress,
            'macAddress' => $request -> macAddress,
            'deviceId' => $request -> deviceId,
            'isOnline' => 1,
          ]);
          

          return $this -> getUserData($user -> id);

      } catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);
      }
   

    }


    public function checkUserLoginOrRegister(Request $request){
       if($request -> register_with == "GOOGLE"){
         $users = AppUser::where('email' , '=' , $request -> email) -> get();
       } elseif($request -> register_with == "FACEBOOK"){
         $users = AppUser::where('email' , '=' , $request -> email) -> get(); 
       } elseif($request -> register_with == "PHONE"){
         $users = AppUser::where('phone' , '=' , $request -> phone) -> get(); 
       }
        if( count($users) > 0 ){
         //login
         return $this -> Login($users[0] , $request);
        } else {
         //register
         return $this -> Register($request);
        }

    }

    public function getUserData ($id) {
      try{
        $users = DB::table('app_users')
        -> join('wallets' , 'app_users.id' , '=','wallets.user_id')
        -> join('levels as share_level' , 'share_level.id' , '=' , 'app_users.share_level_id' )
        -> join('levels as karizma_level' , 'karizma_level.id' , '=' , 'app_users.karizma_level_id' )
        -> join('levels as charging_level' , 'charging_level.id' , '=' , 'app_users.charging_level_id')
        -> select('app_users.*' , 'wallets.gold' , 'wallets.diamond' , 
        'share_level.order as share_level_order' , 'share_level.points as share_level_points' , 'share_level.icon as share_level_icon' ,
        'karizma_level.order as karizma_level_order' , 'karizma_level.points as karizma_level_points' , 'karizma_level.icon as karizma_level_icon' ,
        'charging_level.order as charging_level_order' , 'charging_level.points as charging_level_points' , 'charging_level.icon as charging_level_icon') 
        -> where('app_users.id' , '=' , $id)-> get();

        $followers = DB::table('followers')
        -> join('app_users' , 'followers.user_id' , '=' , 'app_users.id')
        ->join('levels as share_level' ,function ($join) {
          $join->on('app_users.share_level_id', '=', 'share_level.id');
         })
         ->join('levels as karizma_level' ,function ($join) {
          $join->on('app_users.karizma_level_id', '=', 'karizma_level.id');
          }) 
          ->join('levels as charging_level' ,function ($join) {
              $join->on('app_users.charging_level_id', '=', 'charging_level.id');
          }) -> select('followers.*' , 'app_users.name as follower_name' , 'app_users.tag as follower_tag' ,
          'app_users.img as follower_img' , 'app_users.gender as follower_gender' , 'share_level.icon as share_level_img' ,
          'karizma_level.icon as karizma_level_img' , 'charging_level.icon as charging_level_img') -> where('followers.follower_id' , '=' , $id) -> get();

          $followings = DB::table('followers')
          -> join('app_users' , 'followers.follower_id' , '=' , 'app_users.id')
          ->join('levels as share_level' ,function ($join) {
            $join->on('app_users.share_level_id', '=', 'share_level.id');
           })
           ->join('levels as karizma_level' ,function ($join) {
            $join->on('app_users.karizma_level_id', '=', 'karizma_level.id');
            }) 
            ->join('levels as charging_level' ,function ($join) {
                $join->on('app_users.charging_level_id', '=', 'charging_level.id');
            }) -> select('followers.*' , 'app_users.name as follower_name' , 'app_users.tag as follower_tag' ,
            'app_users.img as follower_img' , 'app_users.gender as follower_gender' , 'share_level.icon as share_level_img' ,
            'karizma_level.icon as karizma_level_img' , 'charging_level.icon as charging_level_img') -> where('followers.user_id' , '=' , $id) -> get();

            $friends1 = DB::table('friends')
            -> join('app_users' , 'friends.user_id' , '=' , 'app_users.id')
            ->join('levels as share_level' ,function ($join) {
              $join->on('app_users.share_level_id', '=', 'share_level.id');
             })
             ->join('levels as karizma_level' ,function ($join) {
              $join->on('app_users.karizma_level_id', '=', 'karizma_level.id');
              }) 
              ->join('levels as charging_level' ,function ($join) {
                  $join->on('app_users.charging_level_id', '=', 'charging_level.id');
              }) -> select('friends.*' , 'app_users.name as follower_name' , 'app_users.tag as follower_tag' ,
              'app_users.img as follower_img' , 'app_users.gender as follower_gender' , 'share_level.icon as share_level_img' ,
              'karizma_level.icon as karizma_level_img' , 'charging_level.icon as charging_level_img') -> where('friends.friend_id' , '=' , $id) -> get();

              $friends2 = DB::table('friends')
              -> join('app_users' , 'friends.friend_id' , '=' , 'app_users.id')
              ->join('levels as share_level' ,function ($join) {
                $join->on('app_users.share_level_id', '=', 'share_level.id');
               })
               ->join('levels as karizma_level' ,function ($join) {
                $join->on('app_users.karizma_level_id', '=', 'karizma_level.id');
                }) 
                ->join('levels as charging_level' ,function ($join) {
                    $join->on('app_users.charging_level_id', '=', 'charging_level.id');
                }) -> select('friends.*' , 'app_users.name as follower_name' , 'app_users.tag as follower_tag' ,
                'app_users.img as follower_img' , 'app_users.gender as follower_gender' , 'share_level.icon as share_level_img' ,
                'karizma_level.icon as karizma_level_img' , 'charging_level.icon as charging_level_img') -> where('friends.user_id' , '=' , $id) -> get();

                $friends = array_merge($friends1 ->toArray() , $friends2 ->toArray()) ;

                $visitors = DB::table('visitors')
                -> join('app_users' , 'visitors.visitor_id' , '=' , 'app_users.id')
                ->join('levels as share_level' ,function ($join) {
                  $join->on('app_users.share_level_id', '=', 'share_level.id');
                 })
                 ->join('levels as karizma_level' ,function ($join) {
                  $join->on('app_users.karizma_level_id', '=', 'karizma_level.id');
                  }) 
                  ->join('levels as charging_level' ,function ($join) {
                      $join->on('app_users.charging_level_id', '=', 'charging_level.id');
                  }) -> select('visitors.*' , 'app_users.name as follower_name' , 'app_users.tag as follower_tag' ,
                  'app_users.img as follower_img' , 'app_users.gender as follower_gender' , 'share_level.icon as share_level_img' ,
                  'karizma_level.icon as karizma_level_img' , 'charging_level.icon as charging_level_img') -> where('visitors.user_id' , '=' , $id) -> get(); 

        
        if(count($users) > 0){
          $user = $users[0] ;
          return response()->json(['state' => 'success' , 'user' => $user , 'followers' => $followers , 'followings' => $followings , 'friends' => $friends , 'visitors' => $visitors]);
        } else {
      
          return response()->json(['state' => 'notFound' , 'message' => "Sorry ! we can not find this user" ]);
        }
        
      } catch(QueryException $ex){
        return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

      }


    }

    public function search($txt){
      try{
        $users = DB::table('app_users')
        -> join('wallets' , 'app_users.id' , '=','wallets.user_id')
        -> join('levels as share_level' , 'share_level.id' , '=' , 'app_users.share_level_id' )
        -> join('levels as karizma_level' , 'karizma_level.id' , '=' , 'app_users.karizma_level_id' )
        -> join('levels as charging_level' , 'charging_level.id' , '=' , 'app_users.charging_level_id')
        -> select('app_users.*' , 'wallets.gold' , 'wallets.diamond' , 
        'share_level.order as share_level_order' , 'share_level.points as share_level_points' , 'share_level.icon as share_level_icon' ,
        'karizma_level.order as karizma_level_order' , 'karizma_level.points as karizma_level_points' , 'karizma_level.icon as karizma_level_icon' ,
        'charging_level.order as charging_level_order' , 'charging_level.points as charging_level_points' , 'charging_level.icon as charging_level_icon') 
        -> where('app_users.tag' , 'like' , '%' .$txt . '%' )
        ->orWhere('app_users.name', 'like', '%' . $txt . '%')->get();

        return $users ;
      } catch(QueryException $ex){
        return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);
      }

    }

}
