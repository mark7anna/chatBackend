<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Design;
use App\Models\Wallet;
use App\Models\DesignPurchase;
use Carbon\Carbon;
use Illuminate\Database\QueryException;


class StoreController extends Controller
{
    public function getAllStoreCategory(){
        try{
            
            $cats = Category::all();
            return  response()->json(['state' => 'success' , 'cats' => $cats]);
        }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }
    }
    public function getAllDesigns(){
        try{
           $designs = Design::all();
           return  response()->json(['state' => 'success' , 'designs' => $designs]);

        }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }
    }
   public function purchaseDesign(Request $request){
    try{
        $wallet = Wallet::where('user_id' , '=' , $request -> user_id) -> get();
        $design = Design::find($request -> design_id);
        if($wallet -> gold >=  $design -> price){
            $designPurchase = DesignPurchase::where('user_id' , '=' , $request -> user_id)
            -> where('design_id' , '=' , $request -> design_id) -> get();
            if(count($designPurchase) > 0){
                // extend the design period
                $purchse = $designPurchase[0];
                //get the new available_until
                if(Carbon($purchse -> available_until) -> startOfDay() < Carbon::now() -> startOfDay()){
                    //expired ! renew to be today + design days
                    $renew_date = Carbon::now() -> addDays($design -> days);
                    
                } else {
                    //still available ! extend to be the old available_until  + design days
                    $renew_date = Carbon($purchse -> available_until) -> addDays($design -> days);
                }
                $new_count = $designPurchase -> count + 1 ;
                $designPurchase -> update([
                    'isAvailable' => 1, 
                    'count' => $new_count,
                    'available_until' => $renew_date
                ]);
                $new_balance = $wallet -> gold - $design -> price ;
                $wallet -> update([
                    'gold' => $new_balance
                ]);
                return response()->json(['state' => 'success' , 'message' => 'Congratulations ! Your purchase Done successfully !']);


            } else {
                // new purchase operation
                $id = DesignPurchase::create([
                    'design_id' => $request -> design_id,
                    'user_id' => $request -> user_id,
                    'isAvailable' => 1, 
                    'purchase_date' => Carbon::now(),
                    'available_until' => Carbon::now() -> addDays($design -> days),
                    'price' => $design -> price,
                     'count' => 1

                ]) -> id ;
                if($id){
                    $new_balance = $wallet -> gold - $design -> price ;
                    $wallet -> update([
                        'gold' => $new_balance
                    ]);
                    return response()->json(['state' => 'success' , 'message' => 'Congratulations ! Your purchase Done successfully !']);


                } else {
                    return response()->json(['state' => 'failed' , 'message' => 'Sorry! we could not compelete Your Purchase !']);

                }


            }
          
        } else {
            return response()->json(['state' => 'failed' , 'message' => 'Sorry! you have not enough balance !']);

        }
    } catch(QueryException $ex){
        return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

    }

   }
}
