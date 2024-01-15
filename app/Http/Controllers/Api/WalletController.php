<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wallet;
use Illuminate\Database\QueryException;
use App\Models\ChargingOpration;
use Carbon\Carbon;
use App\Models\Settings;
use App\Models\DiamondGoldExchnage;
use App\Models\AppUser;
use App\Models\Level;
use Illuminate\Support\Facades\DB;

class WalletController extends UserNotificationController
{
    public function ChargeWallet(Request $request){
        try{
           $wallets = Wallet::where('user_id' , '=' , $request ->user_id ) -> get();
           if(count($wallets) > 0){
            $wallet = $wallets[0];
            $new_balance = $wallet -> gold + $request -> gold ;
            $wallet -> update([
               'gold' => $new_balance ,
            ]);
            ChargingOpration::create([
                'user_id' => $request -> user_id,
                'gold' => $request -> gold,
                'source' => $request -> source,
                'state' => 1,
                'charging_date' => Carbon::now() 
            ]);
            //create notification
            $this -> createUserNotification('CHARGING' , $request -> user_id , 'SYSTEM' , 
            'Charging Wallet !' , 'Your wallet has been Charged With ' . $request -> gold . 'from ' . $request -> source ,
           'عملية شحن' , ' تم شحن رصيدك من الذهب بقيمة' . $request -> gold .'عن طريق'  . $request -> source );
            return response()->json(['state' => 'success' , 'wallet' => $wallet]);
           }
        }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }
    }

    public function getWallet($user_id){
        try{
            $wallets = Wallet::where('user_id' , '=' , $user_id ) -> get();
            if(count($wallets) > 0){
                $wallet = $wallets[0];
                $walletHistory = ChargingOpration::where('user_id' , '=' , $user_id) -> get();
                $diamondExchange = DiamondGoldExchnage::where('user_id' , '=' , $user_id ) -> get();
                return response()->json(['state' => 'success' , 'wallet' => $wallet , 
                'walletHistory' => $walletHistory , 'diamondExchange' => $diamondExchange]);

            } else {
                return response()->json(['state' => 'failed' , 'message' => 'sorry we can not find wallet']);

            }
        }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }
    }
     
    public function exchangeDiamond(Request $request){
        try{
            $wallets = Wallet::where('user_id' , '=' , $request ->user_id ) -> get();
            $settings = Settings::all() -> first();
            if(count($wallets) > 0){
                $wallet = $wallets[0];
                if($wallet -> diamond >= $request -> diamond){
                    $convert_ratio =  $settings ? $settings -> diamond_to_gold_ratio : 1 ;
                    $added_gold = $request -> diamond *  $convert_ratio ;
                    $new_gold = $wallet -> gold + $added_gold ;
                    $new_diamond = $wallet -> diamond - $request -> diamond ;
                    $wallet -> update([
                        'gold' => $added_gold ,
                        'diamond' => $new_diamond
                    ]);
                    DiamondGoldExchnage::create([
                        'user_id' => $request -> user_id,
                        'diamond' => $request -> diamond,
                        'diamond_gold_ration' => $convert_ratio ,
                        'gold' => $added_gold,
                        'exchange_date' => Carbon::now()
                    ]);
 
                    return $this -> getWallet($request ->user_id );
    
                } else {
                    return response()->json(['state' => 'failed' , 'message' => 'sorry you do not have this diamond balance to exchange !']);

                }
            } else {
                return response()->json(['state' => 'failed' , 'message' => 'sorry we can not find wallet']);

            }
        }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }
    }


    public function checkChargingLevelUpgrade($user_id){
      $chargingOpration = ChargingOpration::where('user_id' , '=' , $user_id) -> get();
      $user = AppUser::find($user_id);
      $currentChargingLevel = Level::find($user -> charging_level_id) ;
      $allChargingLevels =  DB::table('levels') -> where('type' , '=' , 2) ->orderBy('id', 'asc');
     // $nextChargingLevel = $allChargingLevels -> where('id', '>', $user -> charging_level_id)->firstOrFail();
      $total_gold = 0 ;
      foreach($chargingOpration as $operation){
        $total_gold += $operation -> gold ;
      }
      $nextChargingLevel = $allChargingLevels -> where('points' , '>=' , $total_gold) ->firstOrFail();
    }
}
