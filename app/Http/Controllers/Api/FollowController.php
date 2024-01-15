<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Follower;
use App\Models\Following;
use App\Models\Friend;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class FollowController extends AppUserController
{
    public function followUser(Request $request){
        try{
          Follower::create([
             'user_id' => $request -> user_id ,
             'follower_id' => $request -> follower_id ,
             'following_date' => Carbon::now()
          ]);
          //check if the follower_id is following the user_id and if true => make them friends
            
          $check = Follower::where('user_id' , '=' , $request -> follower_id)
          -> where('follower_id' , '=' , $request -> user_id) -> get();
          if(count($check) > 0){
             Friend::create([
                'user_id' => $request -> user_id,
                'friend_id' => $request -> friend_id,
                'friendship_date' => Carbon::now()
             ]);
           }
           return $this -> getUserData($request -> user_id);

          
        }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }

    }

    public function unFollowUser(Request $request){
        try{
         
            $follow = Follower::where('user_id' , '=' , $request -> user_id)
            -> where('follower_id' , '=' , $request -> follower_id) -> get();
            if(count($follow) > 0 ){
                $follow[0] -> delete();
                $check1 = Friend::where('user_id' , '=' , $request -> user_id)
                -> wher('friend_id' , '=' , $request -> follower_id) -> get();
                if(count($check1) > 0){
                    $check1[0] -> delete();
                }
                $check2 = Friend::where('user_id' , '=' , $request -> follower_id)
                -> wher('friend_id' , '=' , $request -> user_id) -> get();
                if(count($check2) > 0){
                    $check2[0] -> delete();
                }
            } 
           return $this -> getUserData($request -> user_id);
          
        }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }

    }
}
