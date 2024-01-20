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
use Illuminate\Support\Facades\DB;


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
        $wallets = Wallet::where('user_id' , '=' , $request -> user_id) -> get();
        if(count($wallets) > 0){
            $wallet = $wallets[0];
            $design = Design::find($request -> design_id);
            if($wallet -> gold >=  $design -> price){
                $designPurchase = DesignPurchase::where('user_id' , '=' , $request -> user_id)
                -> where('design_id' , '=' , $request -> design_id) -> get();
                if(count($designPurchase) > 0){
                    // extend the design period
                    $purchse = $designPurchase[0];
                    //get the new available_until
                    if(Carbon::parse($purchse -> available_until) -> startOfDay() < Carbon::now() -> startOfDay()){
                        //expired ! renew to be today + design days
                        $renew_date = Carbon::now() -> addDays($design -> days);
                        
                    } else {
                        //still available ! extend to be the old available_until  + design days
                        $renew_date = Carbon::parse($purchse -> available_until) -> addDays($design -> days);
                    }
                    $new_count = $designPurchase[0] -> count + 1 ;
                    $designPurchase[0] -> update([
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
                         'count' => 1,
                          'isDefault' => 0,
                          'design_cat' => $design -> category_id
    
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
        } else {
            return response()->json(['state' => 'failed' , 'message' => 'Sorry! you have wallet , contact support !']);

        }
      
    } catch(QueryException $ex){
        return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

    }

   }

   public function useDesign(Request $request){
    try{
       $designs_to_un_used = DesignPurchase::where('user_id' , '=' , $request -> user_id)
       -> where('design_cat' , '=' , $request -> design_cat) 
       ->where('isDefault' , '=' , 1)-> get();
       $design_to_use = DesignPurchase::where('user_id' , '=' , $request -> user_id)
       -> where('design_id' , '=' , $request -> design_id) -> get();
       if(count($design_to_use) > 0){
        $design_to_use[0] -> update([
            'isDefault' => 1 
        ]);
        foreach(  $designs_to_un_used as $unused){
            $unused -> update([
                'isDefault' => 0 
            ]);
            

        }
        return $this -> getUserDesigns($request -> user_id);
       } else {
        return response()->json(['state' => 'failed' , 'message' => 'Sorry! we can not find this design !']);

       }
    } catch(QueryException $ex){
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
}
