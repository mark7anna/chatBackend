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

              return response()->json(['state' => 'success' , 'message' => 'User created successfully !!' , 'user' => $user]);

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

          return response()->json(['state' => 'success' , 'message' => 'User Login successfully !!' , 'user' => $user]);

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
      $user = DB::table('app_users')
      -> join('wallets' , 'app_users.id' , '=','wallets.user_id')
      -> join('levels as share_level' , 'share_level.id' , '=' , 'app_users.share_level_id' )
      -> join('levels as karizma_level' , 'karizma_level.id' , '=' , 'app_users.karizma_level_id' )
      -> join('levels as charging_level' , 'charging_level.id' , '=' , 'app_users.charging_level_id')
      -> select('app_users.*' , 'wallets.gold' , 'wallets.diamond' , 
      'share_level.order as share_level_order' , 'share_level.points as share_level_points' , 'share_level.icon as share_level_icon' ,
      'karizma_level.order as karizma_level_order' , 'karizma_level.points as karizma_level_points' , 'karizma_level.icon as karizma_level_icon' ,
      'charging_level.order as charging_level_order' , 'charging_level.points as charging_level_points' , 'charging_level.icon as charging_level_icon') 
      -> where('app_users.id' , '=' , $id)-> get();
      
      return $user ;

    }


}
