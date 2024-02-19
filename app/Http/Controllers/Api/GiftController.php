<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AgencyMember;
use App\Models\AgencyMemberPoints;
use App\Models\AppUser;
use App\Models\ChatRoom;
use App\Models\Design;
use App\Models\GiftTransaction;
use App\Models\Level;
use App\Models\Settings;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class GiftController extends Controller
{
    public function sendGiftToUser(Request $request){
        try{
            $sender = AppUser::find($request -> sender_id);
            $receiver = AppUser::find($request -> recevier_id);
            $owner = AppUser::find($request -> owner_id);
            $room = ChatRoom::find($request ->room_id );
            $gift = Design::find($request -> gift_id);
            $senderWallet = Wallet::Where('user_id' , '=' , $request -> sender_id ) -> get() -> first();
            $receiverWallet = Wallet::Where('user_id' , '=' , $request -> recevier_id ) -> get() -> first();
            $ownerWallet = Wallet::Where('user_id' , '=' , $request -> owner_id ) -> get() -> first();
            $setting = Settings::all() -> first();
            if($sender && $receiver && $owner && $room && $gift &&  $senderWallet  &&$receiverWallet &&  $ownerWallet && $setting){
                          
                if($senderWallet -> gold >= ($gift -> price * $request -> count)){
                  $id =  GiftTransaction::create([
                        'gift_id' => $request -> gift_id,
                        'sender_id' => $request -> sender_id ,
                        'receiver_id' => $request -> recevier_id,
                        'room_id' => $request -> room_id,
                        'count' => $request -> count,
                        'price' => $gift -> price,
                        'total' => ($gift -> price * $request -> count),
                        'sendDate' => Carbon::now()

                    ]) -> id;
                    //gift sent Successfully
                    if($id > 0){
                        ///////////////////////////////////////update wallets//////////////////////////////////////// 
                        $senderDiamond = ($gift -> price * $request -> count) * ($setting -> gift_sender_diamond_back / 100) ;
                        $senderWallet -> update([
                          'gold' => $senderWallet -> gold - ($gift -> price * $request -> count),
                          'diamond' => $senderWallet -> diamond + $senderDiamond
                        ]);

                        $recevierDiamond = ($gift -> price * $request -> count) ;
                        $receiverWallet -> update([
                            'diamond' => $receiverWallet -> diamond + $recevierDiamond 
                        ]);

                        $ownerDiamond = ($gift -> price * $request -> count)  *  ($setting -> gift_room_owner_diamond_back / 100);
                        $ownerWallet -> update([
                            'diamond' => $ownerWallet -> diamond + $ownerDiamond 
                        ]);

                        ////////////////////////////////////////////////////////////////////////////////////
                        
                        /////////////////////////////Handle Host Agency Record/////////////////////////////
                       
                        $this -> updateHostAgencyRecords($request ->recevier_id , $gift , $request -> count);
                         
                        //////////////////////////////////////////////////////////////////////////////////

                        /////////////////////////////Check For Upgrade Levels/////////////////////////////

                        $this -> checkToUpShareLevel($request -> sender_id);
                        $this -> checkToUpKarizmaLevel($request -> recevier_id);

                        //////////////////////////////////////////////////////////////////////////////////


                        return response()->json(['state' => 'success' , 'message' => 'Gift Sent Successfully']);

                    } else {
                        return response()->json(['state' => 'failed' , 'message' => 'something wentwrong ']);

                    }

                } else {
                    return response()->json(['state' => 'failed' , 'message' => 'No Sufficent Balance']);

                }


 

            } else {
                return response()->json(['state' => 'failed' , 'message' => 'Invalid Request']);

            }

        } catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }

    }

    public function updateHostAgencyRecords($receiver_id , $gift , $count){
        try{
          $members = AgencyMember::where('user_id' , '=' , $receiver_id) -> get();
          if(count($members) > 0){
              //this user is a host agency member let's fill his time sheet
        
                  AgencyMemberPoints::create([
                      'user_id' => $receiver_id,
                      'agency_id' => $members[0] -> agency_id,
                      'gift_id' => $gift -> id,
                      'points' =>  $gift -> price * $count,
                      'send_date' => Carbon::now(),
                  ]);
              
          } else {
              // this is a normal user let him alone :)
          }
        }catch(QueryException $ex){
         //return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }
   }
   public function checkToUpShareLevel($sender_id){
    try{
        $user = AppUser::find($sender_id);
        if($user){
            $transactions = GiftTransaction::where('sender_id' , '=' , $sender_id) -> get();
            $current_level = Level::find($user -> share_level_id);
            $totalShareValue = 0 ;
            $up_level = 0 ;
            foreach( $transactions as  $transaction){
                $totalShareValue  +=  $transaction -> total ;
            }
            if($current_level -> points > $totalShareValue){
                //do no thing
                return 'not upgrade';
            } else {
                $up_level = Level::Where('type' , '=' , 0) 
                -> where('points' , '>=' ,$totalShareValue )  ->orderBy('points', 'ASC') -> get()[0] -> id;
             $user -> update([
                'share_level_id' => $up_level 
             ]);
            }
        }
    } catch(QueryException $ex){

    }
}

public function checkToUpKarizmaLevel($receiver_id){
    try{
        $user = AppUser::find($receiver_id);
        if($user){
            $transactions = GiftTransaction::where('receiver_id' , '=' , $receiver_id) -> get();
            $current_level = Level::find($user -> karizma_level_id);
            $totalKarizmaValue = 0 ;
            $up_level = 0 ;
            foreach( $transactions as  $transaction){
                $totalKarizmaValue  +=  $transaction -> total ;
            }
            if($current_level -> points > $totalKarizmaValue){
                //do no thing
                return 'not upgrade';
            } else {
                $up_level = Level::Where('type' , '=' , 1) 
                -> where('points' , '>=' ,$totalKarizmaValue )  ->orderBy('points', 'ASC') -> get()[0] -> id;
             $user -> update([
                'karizma_level_id' => $up_level 
             ]);
            }
        }
    } catch(QueryException $ex){

    }
}
}
