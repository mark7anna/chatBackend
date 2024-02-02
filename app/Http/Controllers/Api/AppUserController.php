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
use App\Models\Tag;
use App\Models\Usertags;
use App\Models\Block;
use App\Models\UserReport;
use App\Models\Country;
use App\Models\Follower;



class AppUserController extends Controller
{
    public function Register(Request $request){
       $tag = (int)(date('Ymd') . rand(1, 100));
       $country = Country::first();

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
            'country' => $country -> id,
            'register_with' => $request -> register_with,
            'token' => $request -> token
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
             'token' => $request -> token
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
        -> join('countries' , 'countries.id' , '=' , 'app_users.country')

        -> select('app_users.*' , 'wallets.gold' , 'wallets.diamond' , 
        'share_level.order as share_level_order' , 'share_level.points as share_level_points' , 'share_level.icon as share_level_icon' ,
        'karizma_level.order as karizma_level_order' , 'karizma_level.points as karizma_level_points' , 'karizma_level.icon as karizma_level_icon' ,
        'charging_level.order as charging_level_order' , 'charging_level.points as charging_level_points' , 'charging_level.icon as charging_level_icon' ,
        'countries.name as country_name' , 'countries.icon as country_flag') 
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

                  $tags = DB::table('usertags')
                  -> join('tags' , 'usertags.tag_id' , "=" , "tags.id")
                  -> select('tags.*' , 'usertags.user_id')
                  ->where('usertags.user_id' , '=' , $id) -> get();

                  $blocks = DB::table('blocks')
                  -> join('app_users' , 'app_users.id' , '=' ,'blocks.blocke_user')
                  -> select('blocks.*' , 'app_users.name as blocked_name' , 'app_users.tag as blocked_tag')
                  -> where('blocks.user_id' , '=' , $id) -> get();
                if(count($users) > 0){
                  $user = $users[0] ;
                  return response()->json(['state' => 'success' , 'user' => $user , 'followers' => $followers , 
                  'followings' => $followings , 'friends' => $friends , 'visitors' => $visitors , 'tags' => $tags , 'blocks' => $blocks]);
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
        -> join('countries' , 'countries.id' , '=' , 'app_users.country')

        -> select('app_users.*' , 'wallets.gold' , 'wallets.diamond' , 
        'share_level.order as share_level_order' , 'share_level.points as share_level_points' , 'share_level.icon as share_level_icon' ,
        'karizma_level.order as karizma_level_order' , 'karizma_level.points as karizma_level_points' , 'karizma_level.icon as karizma_level_icon' ,
        'charging_level.order as charging_level_order' , 'charging_level.points as charging_level_points' , 'charging_level.icon as charging_level_icon' ,
        'countries.name as country_name' , 'countries.icon as country_flag') 
        -> where('app_users.tag' , 'like' , '%' .$txt . '%' )
        ->orWhere('app_users.name', 'like', '%' . $txt . '%')->get();

        return $users ;
      } catch(QueryException $ex){
        return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);
      }

    }

    function getHoppies(){
      try{
          $tags = Tag::where('type' , '=' , 1) -> get();
          return response()->json(['state' => 'success' , 'tags' => $tags ]);
  
      }catch(QueryException $ex){
          return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);
  
      }
    }
    function addHoppy(Request $request){
      try{
        if($request ->  state == "ADD"){
           Usertags::create([
          'user_id' => $request ->user_id ,
          'tag_id' => $request -> tag_id
        ]);
        } else if($request ->  state == "DEL"){
          $userTags = Usertags::where('user_id' , '=' , $request -> user_id)
          -> where('tag_id' , '=' , $request -> tag_id) -> get();
          if(count($userTags) > 0){
            $userTags[0] -> delete();
          }
        }
       
         return $this -> getUserData($request -> user_id);
      }catch(QueryException $ex){
          return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

      }
    }

    public function updateUserName(Request $request){
      try{
        $user = AppUser::find($request -> user_id) ;
        if($user){
          $user -> update ([
            'name' => $request -> name
          ]);
        }
       
         return $this -> getUserData($request -> user_id);
      }catch(QueryException $ex){
          return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

      }
    }

    public function updateUserBirthdate(Request $request){
      try{
        $user = AppUser::find($request -> user_id) ;
        if($user){
          $user -> update ([
            'birth_date' => Carbon::parse($request -> birth_date), 
          ]);
        }
       
         return $this -> getUserData($request -> user_id);
      }catch(QueryException $ex){
          return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

      }
    }

    public function updateUserCountry(Request $request){
      try{
        $user = AppUser::find($request -> user_id) ;
        if($user){
          $user -> update ([
            'country' => $request -> country, 
          ]);
        }
       
         return $this -> getUserData($request -> user_id);
      }catch(QueryException $ex){
          return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

      }
    }

    public function updateUserProfile(Request $request){
      try{
        $user = AppUser::find($request -> user_id) ;
        if($user){
          if($request -> img){
            $img = time() . '.' . $request->img->extension();
            $request->img->move(('images/AppUsers'), $img);
        } else {
            $img = "";
        }
          $user -> update ([
            'img' => $img, 
          ]);
        }
       
         return $this -> getUserData($request -> user_id);
      }catch(QueryException $ex){
          return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

      }
    }

    public function updateUserCoverPhoto(Request $request){
      try{
        $user = AppUser::find($request -> user_id) ;
        if($user){
          if($request -> cover){
            $cover = time() . '.' . $request->cover->extension();
            $request->cover->move(('images/AppUsers/Covers'), $cover);
        } else {
            $cover = "";
        }
          $user -> update ([
            'cover' => $cover, 
          ]);
        }
       
         return $this -> getUserData($request -> user_id);
      }catch(QueryException $ex){
          return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

      }
    }

    public function updateUserStatus(Request $request){
      try{
        $user = AppUser::find($request -> user_id) ;
        if($user){
          $user -> update ([
            'status' => $request -> status, 
          ]);
        }
       
         return $this -> getUserData($request -> user_id);
      }catch(QueryException $ex){
          return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

      }
    }

    public function getUserDesigns($user_id){
      try{
        $designs = DB::table('design_purchases') 
        ->join('designs' , 'design_purchases.design_id' , 'designs.id')
        ->select('designs.*' , 'design_purchases.available_until' , 'design_purchases.count' , 
        'design_purchases.isDefault' , 'design_purchases.design_cat') -> where('design_purchases.user_id' , '=' , $user_id)
        -> get();
        $gifts = DB::table('gift_transactions') 
        ->join('designs' , 'gift_transactions.gift_id' , 'designs.id')
        ->select('designs.*' , 'gift_transactions.sendDate as  available_until' ,
         'gift_transactions.count' , 'gift_transactions.count as isDefault' , 'gift_transactions.count as design_cat' ) -> where('gift_transactions.receiver_id' , '=' , $user_id)
        -> get();

        return response()->json(['state' => 'success' , 'designs' => $designs , 'gifts' => $gifts ]);

      }catch(QueryException $ex){
        return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);
      }
 

    }


    public function reportUser(Request $request){
      try{
        $user = AppUser::find($request -> user_id) ;
        $reported_user = AppUser::find($request -> reported_user) ;
        if($user && $reported_user){
          UserReport::create([
            'user_id' => $request -> user_id,
            'category_id' => $request -> category_id,
            'reported_user' => $request -> reported_user,
            'description' => $request -> description,
            'screen_shot' => ""
          ]);
          return response()->json(['state' => 'success' , 'message' => "we have recived your report and will deal wit it !"]);

        } else {
          return response()->json(['state' => 'failed' , 'message' => "Soryy You Can not block this user"]);

        }

      }catch(QueryException $ex){
        return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);
      }
    }
    public function blockUser(Request $request){
      try{
        $user = AppUser::find($request -> user_id) ;
        $blocked_user = AppUser::find($request -> blocke_user) ;
        $blocks = Block::where('user_id' , '=' ,$request -> user_id)
        -> where('blocke_user' , '=' ,$request -> blocke_user) -> get();
        if($user && $blocked_user && count($blocks) == 0){
          Block::create([
            'user_id' => $request -> user_id,
            'blocke_user' => $request -> blocke_user,
            'blocked_date' =>  Carbon::now()
          ]);
          return $this -> getUserData($request -> user_id);
        } else {
          return response()->json(['state' => 'failed' , 'message' => "Soryy You Can not block this user"]);

        }
      }catch(QueryException $ex){
        return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);
      }
    }
    public function unblockUser(Request $request){
      try{
        $user = AppUser::find($request -> user_id) ;
        $blocked_user = AppUser::find($request -> blocke_user) ;
        $blocks = Block::where('user_id' , '=' ,$request -> user_id)
        -> where('blocke_user' , '=' ,$request -> blocke_user) -> get();
        if($user && $blocked_user && count($blocks) >  0){
          $blocks[0] -> delete();
          return $this -> getUserData($request -> user_id);
           
        } else {
          return response()->json(['state' => 'failed' , 'message' => "Soryy You Can not block this user"]);

        }
      }catch(QueryException $ex){
        return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);
      }
    }


    public function followUser(Request $request){
      try{
        $user = AppUser::find($request -> user_id) ;
        $followed_user = AppUser::find($request -> follower_id) ;
    
        if($user && $followed_user){
          Follower::create([
            'user_id' => $request -> user_id,
            'follower_id' => $request -> follower_id,
            'following_date' =>  Carbon::now()
          ]);
          return $this -> getUserData($request -> user_id);
        } else {
          return response()->json(['state' => 'failed' , 'message' => "Soryy You Can not follow this user"]);

        }
      }catch(QueryException $ex){
        return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);
      }
    }

    public function unfollowkUser(Request $request){
      try{
        $user = AppUser::find($request -> user_id) ;
        $followed_user = AppUser::find($request -> follower_id) ;
        $folloings = Follower::where('user_id' , '=' ,$request -> user_id)
        -> where('follower_id' , '=' ,$request -> follower_id) -> get();
        if($user && $followed_user && count($folloings) >  0){
          $folloings[0] -> delete();
          return $this -> getUserData($request -> user_id);
           
        } else {
          return response()->json(['state' => 'failed' , 'message' => "Soryy You Can not follow this user"]);

        }
      }catch(QueryException $ex){
        return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);
      }
    }

    public function updateUserToken(Request $request) {
      try{
        $user = AppUser::find($request -> user_id);
        if($user){
          $user -> update([
            'token' => $request -> token 
          ]);
          return $this -> getUserData($request -> user_id);

        } else {
          return response()->json(['state' => 'failed' , 'message' => "Sorry , we can not find this user"]);

        }

      } catch(QueryException $ex){
        return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);
      }

    }
    
}
