<?php

namespace App\Http\Controllers\APi;

use App\Http\Controllers\Controller;
use App\Models\AppUser;
use App\Models\ChargingOpration;
use App\Models\Level;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ChargingLevelController extends Controller
{
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
}
