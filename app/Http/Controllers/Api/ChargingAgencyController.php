<?php

namespace App\Http\Controllers\APi;

use App\Http\Controllers\api\UserNotificationController;
use App\Http\Controllers\api\ChargingLevelController;

use App\Http\Controllers\Controller;
use App\Models\AgencyChargingOperation;
use App\Models\AgencyWallet;
use App\Models\AppUser;
use App\Models\ChargingAgency;
use App\Models\ChargingOpration;
use App\Models\Level;
use App\Models\UserNotification;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChargingAgencyController extends Controller
{

    public function getAgency($user_id)  {
      try{
        $agencys = ChargingAgency::where('user_id' , '=' , $user_id) -> get();
        if(count($agencys) > 0){
          $agency = $agencys[0];
          $agencyWallets = AgencyWallet::where('agency_id' , '=' , $agency -> id) -> get();
        
          return response()->json(['state' => 'success' , 'agency' => $agency , 'wallet' => $agencyWallets[0]]);

        } else{
          return response()->json(['state' => 'failed' , 'message' => 'Sorry we can not find this agency']);
        }
         
      }catch(QueryException $ex){
        return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

      }
    }


    public function AddBalanceToUser(Request $request){
       try{
         $agencyWallets = AgencyWallet::where('agency_id' , '=' , $request -> agency_id) -> get();
         $userWallets = Wallet::where('user_id' , '=' , $request -> user_id) -> get();
         if(count($agencyWallets) > 0 && count($userWallets) > 0){
            $agencyWallet = $agencyWallets[0];
            $userWallet =  $userWallets[0];
            if($agencyWallet -> balance >= $request -> charging_value){
              $agencyWallet -> update([
                'balance' => $agencyWallet -> balance - $request -> charging_value 
              ]);

              AgencyChargingOperation::create([
                'agency_id' => $request -> agency_id,
                'user_id' => $request -> user_id,
                'type' => "OUT" , //IN , OUT'
                'gold' => $request -> charging_value,
                'source' => "AGENCY_WALLET",
                'state' =>  1,
                'charging_date' => Carbon::now()
            ]);

            $userWallet -> update([
                'gold' => $userWallet -> gold + $request -> charging_value 
              ]);

              ChargingOpration::create([
                'user_id' => $request -> user_id,
                'gold' => $request -> charging_value,
                'source' => 'CHARGING_AGENCY',
                'state' => $request -> agency_id,
                'charging_date' => Carbon::now() 
            ]);

            $this -> createUserNotification('CHARGING' , $request -> user_id , $request -> agency_id, 
            'Charging Wallet !' , 'Your wallet has been Charged With ' . $request -> gold . 'from ' . $request -> source ,
           'عملية شحن' , ' تم شحن رصيدك من الذهب بقيمة' . $request -> gold .'عن طريق'  . $request -> source , 0);
         
            $this -> checkToUp($request -> user_id);
           return response()->json(['state' => 'success' , 'message' => 'Balance added successfully']);
            
            } else {
                return response()->json(['state' => 'failed' , 'message' => 'No enough balance']);
            }

         } else {
            return response()->json(['state' => 'failed' , 'message' => 'Wallet not found']);
         }

       } catch(QueryException $ex){
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

      }
  }

  public function createUserNotification($type , $notified_user , $action_user , $title , $content 
  , $title_ar , $content_ar , $post_id){

      try{
         UserNotification::create([
          'type' => $type,
          'notified_user' => $notified_user,
          'action_user' => $action_user,
          'title' => $title,
          'content' => $content,
          'title_ar' => $title_ar,
          'content_ar' => $content_ar,
          'post_id' => $post_id
         ]);
          return response()->json(['state' => 'success' , 'message' => 'Notification has been sent successfully']);

      }catch(QueryException $ex){
          return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

      }
    
  }

  public function getAgencyOperations($id){
    try{
      $operations = DB::table('agency_charging_operations') 
      -> leftJoin('app_users' , 'agency_charging_operations.user_id' , '=' , 'app_users.id')
      -> select('agency_charging_operations.*' , 'app_users.name as user_name')
      -> where('agency_charging_operations.agency_id' , '=' , $id)
      -> get();
      return response()->json(['state' => 'success' , 'operations' => $operations]);

       
    }catch(QueryException $ex){
      return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

    }

  }
}
