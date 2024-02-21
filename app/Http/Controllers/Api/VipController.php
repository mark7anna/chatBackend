<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AppUser;
use Illuminate\Http\Request;
use App\Models\Design ;
use App\Models\DesignPurchase;
use App\Models\Vip ;
use App\Models\VipPurchase;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Database\QueryException;

class VipController extends Controller
{
    public function index(){
        try{
            $designs = Design::where('vip_id' , '>' , 0) -> get();
            return response()->json(['state' => 'success' , 'designs' => $designs ]);

        }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }
    
    }
    public function getVip(){
        try{
            $vips = Vip::all();
            return response()->json(['state' => 'success' , 'vips' => $vips ]);

        }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }
    }

    public function purchaseVip(Request $request){
        try{
            $user = AppUser::Find($request -> user_id);
            $vip = Vip::find($request -> vip);

            if($user &&  $vip ){
                $userVips = VipPurchase::where('user_id' , '=' , $request -> user_id)
                -> where('vip_id' , '=' , $request -> vip) 
                -> whereDate('available_untill' , '>' , Carbon::today())
                -> get();
                if(count($userVips) > 0)
              return response()->json(['state' => 'failed' , 'message' => "You already have this vip in your store!"]);

            

                $wallets = Wallet::where('user_id' , '=' , $request -> user_id) -> get();
                if(count($wallets) > 0){
                    $wallet = $wallets[0];
                    if($wallet -> gold >= $vip -> price){
                        // craete vip purchase ////////////////////////////////////////////
                       $id =  VipPurchase::create([
                            'user_id' => $request -> user_id,
                            'vip_id' => $request -> vip,
                            'purchase_date' => Carbon::now(),
                            'available_untill' => Carbon::now() -> addDays(30),
                            'price' => $vip -> price,
                            'isDefault' => 0
                        ]) -> id;

                        if($id > 0){
                             //update user wallet 
                             $wallet -> update([
                                'gold' => $wallet -> gold -  $vip -> price,
                             ]);

                             ///add the vip designs to the user store 
                             $vipDesigns = Design::where('vip_id' , '=' , $request -> vip) -> get();
                             foreach($vipDesigns as $design){
                                DesignPurchase::create([
                                    'design_id' => $design -> id,
                                    'design_cat' => $design ->  category_id,
                                    'user_id' => $request -> user_id,
                                    'isAvailable' => 1,
                                    'purchase_date' =>  Carbon::now(),
                                    'available_until' => Carbon::now() -> addDays(30),
                                    'price' => $design -> price,
                                    'count' => 1,
                                    'isDefault' => 0
    
                                 ]);
                             }
                    
                        }
                    
                        return response()->json(['state' => 'success' , 'message' => 'Congratulations ! Your purchase Done successfully !']);

               

                    } else {
                        return response()->json(['state' => 'failed' , 'message' => "user has no balance"]);
                    }
                } else {
                    return response()->json(['state' => 'failed' , 'message' => "user has no wallet"]);

                }
            } else {
                return response()->json(['state' => 'failed' , 'message' => "user or vip not found"]);

            }
        }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }

    }

    public function getUserVips($user_id){

    }
}
