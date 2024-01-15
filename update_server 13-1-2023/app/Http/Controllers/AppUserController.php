<?php

namespace App\Http\Controllers;

use App\Models\AppUser;
use App\Models\Notification;
use App\Models\Wallet;
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

            return redirect()->route('appUsers' , 1)->with('success', __('main.updated'));

        }
      }


    public function userNotifications(){
        $notifications = Notification::all();
        return view('AppUsers.notifications' , compact('notifications'));
    }
    public function sendNotification(Request $request){
        $validated = $request->validate([
            'title' => 'required',
            'message' => 'required',
            'type' => 'required'
        ]);
        if($request -> img){
            $img = time() . '.' . $request->img->extension();
            $request->img->move(('images/Notifications'), $img);
        } else {
            $img = "";
        }
        Notification::create([
            'title' => $request -> title,
            'message' => $request -> message,
            'img' => $img,
            'link' => $request -> link ?? "",
            'type' => $request -> type,
            'user_id' => $request -> user_id ?? ""
        ]);

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
                $img = time() . '.' . $request->img->extension();
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
}
