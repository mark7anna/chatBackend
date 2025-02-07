<?php

namespace App\Http\Controllers;

use App\Models\AppUser;
use App\Models\Badge;
use App\Models\ChargingOpration;
use App\Models\Level;
use App\Models\Notification;
use App\Models\UserMedal;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index($enable)
    {
        if($enable == 1){
            $users = DB::table('app_users')
            -> join('wallets' , 'app_users.id' , '=' ,'wallets.user_id')
            -> join('levels' , 'app_users.share_level_id' , '=' , 'levels.id')
            -> select('levels.icon as level_img' , 'wallets.gold' , 'wallets.diamond' , 'app_users.*')
            -> get();

            return view('AppUsers.index' , compact('users'));
        } else {
            $users = DB::table('app_users')
            -> join('wallets' , 'app_users.id' , '=' ,'wallets.user_id')
            -> join('levels' , 'app_users.share_level_id' , '=' , 'levels.id')
            -> select('levels.icon as level_img' , 'wallets.gold' , 'wallets.diamond' , 'app_users.*')
            -> where('app_users.enable' , '=' , 0)
            -> get();

            return view('AppUsers.blocked' , compact('users'));
        }
    }

    public function enable_account($user_id){
      $user = AppUser::find($user_id);
      if($user){
        $user -> update([
            'enable' => 1
        ]);

      }
      return redirect()->route('appUsers' , 1)->with('success', __('main.updated'));

    }
    public function disable_account($user_id){
        $user = AppUser::find($user_id);
        if($user){
          $user -> update([
              'enable' => 0
          ]);
  
        }
        return redirect()->route('appUsers' , 1)->with('success', __('main.updated'));
    }

    public function chargeAppUserBalance(){
        return view('AppUsers.chargeUser' );
    }

    public function updateDiamondWallet(Request $request){
      $walet = Wallet::where('user_id' , '=' , $request -> userId) -> get();
      if(count($walet) > 0){
        if($request -> chargeType == 1){

            $walet[0] -> diamond += $request -> diamond ;
        } else if($request -> chargeType == 0){
            $walet[0] -> diamond -= $request -> diamond ;
        }
        $walet[0] -> update ();

          return redirect()->route('appUsers' , 1)->with('success', __('main.updated'));

      }
    }
    public function updateGoldWallet(Request $request){
        $walet = Wallet::where('user_id' , '=' , $request -> userIdd) -> get();
        if(count($walet) > 0){
          if($request -> chargeType == 1){

              $walet[0] -> gold += $request -> gold ;
          } else if($request -> chargeType == 0){
              $walet[0] -> gold -= $request -> gold ;
          }
          $walet[0] -> update ();


          $this -> createChargeOperation($request -> userIdd , $request -> chargeType == 1 ? $request -> gold :  -1 * $request -> gold);

           $this -> checkToUp($request -> userIdd );
            return redirect()->route('appUsers' , 1)->with('success', __('main.updated'));

        }
      }

      public function createChargeOperation( $userId , $gold  ){
        
        ChargingOpration::create([
            'user_id' => $userId ,
            'gold' => $gold,
            'source' => "ADMIN",
            'state' => 1,
            'charging_date' => Carbon::now()
        ]);
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
  
        }
    }


    public function userNotifications(){
        $notifications = Notification::all();
        return view('AppUsers.notifications' , compact('notifications'));
    }
    public function sendNotification(Request $request){
        $pushController = new PushNotificationController();
        $validated = $request->validate([
            'title' => 'required',
            'message' => 'required',
            'type' => 'required'
        ]);
        if($request -> img){
            $img = time() . '.' . $request->img->getClientOriginalExtension();
            $request->img->move(('images/Notifications'), $img);
        } else {
            $img = "";
        }
        if($request -> user_id){ 
            $users = AppUser::Where('tag' , '=' , $request -> user_id) -> get();
            if(count($users) > 0){
                $id = $users[0] -> id ;
                $token = $users[0] -> token ;
            } else {
                $id = 0 ;
                $token = '/topics/all';
            }
        } else {
            $id = 0 ;
                $token = '/topics/all';
        }
        Notification::create([
            'title' => $request -> title,
            'message' => $request -> message,
            'img' => $img,
            'link' => $request -> link ?? "",
            'type' => $request -> type,
            'user_id' => 0
        ]);
        $pushController -> sendNotificationToUser($token , $request -> title  ,$request -> message );

        return redirect()->route('userNotifications' )->with('success', __('main.sent'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($tag)
    {
        $user = DB::table('app_users')
        -> join('wallets' , 'app_users.id' , '=' ,'wallets.user_id')
        -> join('levels' , 'app_users.share_level_id' , '=' , 'levels.id')
        -> select('levels.icon as level_img' , 'wallets.gold' , 'wallets.diamond' , 'app_users.*')
        -> where('app_users.tag' , '=' , $tag)
        -> get();
        echo(json_encode($user));
        exit;
    }

    public function showById($id)
    {
        $user = DB::table('app_users')
        -> join('wallets' , 'app_users.id' , '=' ,'wallets.user_id')
        -> join('levels as levels1' , 'app_users.share_level_id' , '=' , 'levels1.id')
        -> join('levels as levels2' , 'app_users.karizma_level_id' , '=' , 'levels2.id')
        -> join('levels as levels3' , 'app_users.charging_level_id' , '=' , 'levels3.id')
        -> select('levels1.icon as share_level_img' , 'levels1.order as share_level_name' , 'wallets.gold' , 'wallets.diamond' ,
        'levels2.icon as karizma_level_img' , 'levels2.order as karizma_level_name' ,
        'levels3.icon as charging_level_img' , 'levels3.order as charging_level_name' ,
        'app_users.*')
        -> where('app_users.id' , '=' , $id)
        -> get();

        echo(json_encode($user));
        exit;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AppUser $appUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $user = AppUser::find($request -> USERID);

        if($user){
            if($request -> img){
                $img = time() . '.' . $request->img->getClientOriginalExtension();
                $request->img->move(('images/AppUsers'), $img);
            } else {
                $img = $user -> img;
            }
            $user -> update ([
               'name' => $request -> name ,
               'tag' => $request -> tag ,
               'email' => $request -> email ,
               'img' => $img

            ]);
            return redirect()->route('appUsers' , 1 )->with('success', __('main.updated'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $notification = Notification::find($id);
        if($notification){
            $notification -> delete();
            return redirect()->route('userNotifications' )->with('success', __('main.deleted'));
        }
    }
 
    public function  addMedalTouser(){
        $medals = Badge::all();
        return view ('AppUsers.addMedalToUser' , compact('medals'));

    }
    public function AddMedalToUserPost($user_id , $medal_id){
        $medal = Badge::find($medal_id);
        $user = AppUser::find($user_id);
        $medals = UserMedal::where('user_id' , '=' , $user_id)
        -> where('badge_id' , '=' , $medal_id) -> get() ;
        if(count($medals) == 0){
            if($medal && $user){
                UserMedal::create([
                    'user_id' => $user_id,
                    'badge_id' => $medal_id
                ]);
            }
            return redirect()->route('appUsers' , 1 )->with('success', __('main.updated'));

        } else {
            return redirect()->route('appUsers' , 1 )->with('error', 'This Medal Already added to this user');

        }
     


    }
        
    public function deleteMedalToUserPost($user_id , $medal_id){
        $medals = UserMedal::where('user_id' , '=' , $user_id)
        -> where('badge_id' , '=' , $medal_id) -> get() ;
        
        if(count($medals) > 0){
           $medals[0] -> delete();
           return redirect()->route('appUsers' , 1 )->with('success', __('main.deleted'));

        }
    }
    

    public function  getuserMedals($id){
        $medals = DB::table('user_medals')
        -> join('badges' , 'user_medals.badge_id' , '=' , 'badges.id')
        -> select('badges.*' , 'user_medals.user_id')
        -> where('user_medals.user_id' , '=' , $id) -> get();

        echo(json_encode($medals));
        exit ;
    } 

    
}
