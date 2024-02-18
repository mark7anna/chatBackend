<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AgencyMember;
use App\Models\AppUser;
use App\Models\HostAgency;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class HostAgencyController extends Controller
{
    public function getAgencyByTag($tag){
        try{
            $agencies = HostAgency::where('tag' , '=' , $tag) -> get();
            if(count($agencies) > 0){
              $agency = $agencies[0];
              return response()->json(['state' => 'success' , 'agency' => $agency]);

            } else {
                return response()->json(['state' => 'failed' , 'message' => 'Agency not found']);

            }
        }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }
       
    }
    public function JoinAgencyRequest(Request $request){
        try{
            $agency = HostAgency::find($request -> agency_id);
            $user = AppUser::find($request -> user_id);
            if($agency && $user){
                if($agency -> active == 1 && $agency -> allow_new_joiners == 1){
                    AgencyMember::create([
                        'agency_id' => $request -> agency_id,
                        'user_id' => $request -> user_id,
                        'state' => $agency -> automatic_accept_joiners, 
                        'joining_date' => Carbon::now(),
                        'approval_date' => Carbon::now()
                    ]);
                    return response()->json(['state' => 'success' , 'message' => 'successfully Joined!' ]);

                } else {
                    return response()->json(['state' => 'failed' , 'message' =>  'Agency is not accepting users right now']);

                }
           
            } else {
                return response()->json(['state' => 'failed' , 'message' => 'Agency or user not found']);

            }

        }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);
        }

    }
}
