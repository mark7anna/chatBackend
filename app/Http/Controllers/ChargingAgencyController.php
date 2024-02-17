<?php

namespace App\Http\Controllers;

use App\Models\AgencyChargingOperation;
use App\Models\AgencyWallet;
use App\Models\AppUser;
use App\Models\ChargingAgency;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ChargingAgencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agencies = DB::table('charging_agencies')
        -> join('app_users' , 'charging_agencies.user_id' , '=' , 'app_users.id')
        -> select('charging_agencies.*' , 'app_users.name as user_name' , 'app_users.tag as user_tag')
        -> get();

        return view ('ChargingAgency.index' , compact('agencies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tag = (int)(date('Ymd') . rand(1, 100));
        echo(json_encode($tag))  ;
        exit ;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request -> id == 0){
            $validated = $request->validate([
                'name' => 'required|unique:charging_agencies',
                'user_id' => 'required|unique:charging_agencies',
            ]);

            $users = AppUser::where('tag' , '=' , $request -> user_id) -> get();
            if(count($users)  > 0){
               $id = ChargingAgency::create([
                    'name' => $request -> name,
                    'user_id' => $users[0]-> id,
                    'notes'=> $request -> notes ?? "",
                    'active' => $request->input('active') == 'on' ? 1 : 0,
            
            ]) -> id;
            $users[0] -> update([
                'isChargingAgent' => 1 
            ]);
            
             AgencyWallet::create([
                'agency_id' => $id,
                'balance' => 0,
             ]);


            return redirect()->route('chargingAgencies')->with('success', __('main.created'));
            } else {
                return redirect()->route('chargingAgencies')->with('error', 'User not found');

            }




        } else {
            return $this -> update($request);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $agency = DB::table('charging_agencies')
        -> join('app_users' , 'charging_agencies.user_id' , '=' , 'app_users.id')
        -> select('charging_agencies.*' , 'app_users.name as user_name' , 'app_users.tag as user_tag')
        ->where('charging_agencies.id' , '=' , $id)
        -> get()[0];
        
        echo(json_encode($agency));
        exit;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChargingAgency $chargingAgency)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $agency = ChargingAgency::find($request -> id);
        if($agency){
            $validated = $request->validate([
                'name' => ['required' , Rule::unique('charging_agencies')->ignore($request -> id)],
                'user_id' => ['required' , Rule::unique('charging_agencies')->ignore($request -> id)],
            ]);
      

            $agency -> update([
                'name' => $request -> name,
                'user_id' => $agency -> user_id,
                'notes'=> $request -> notes ?? "",
                'active' => $request->input('active') == 'on' ? 1 : 0,
        ]);
        return redirect()->route('chargingAgencies')->with('success', __('main.updated'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $agency = ChargingAgency::find($id);
        if($agency){
            $user = AppUser::find($agency -> user_id);
            $user -> update([
                'isChargingAgent' => 0 
            ]);
            $agency -> delete();
            return redirect()->route('chargingAgencies')->with('success', __('main.deleted'));

        }
    }
    public function getchargingBalance($id){
        $agency = DB::table('charging_agencies')
        -> join('agency_wallets' , 'charging_agencies.id' , '=' , 'agency_wallets.agency_id')

        -> join('app_users' , 'charging_agencies.user_id' , '=' , 'app_users.id')
        -> select('charging_agencies.*' , 'app_users.name as user_name' , 
        'app_users.tag as user_tag' , 'agency_wallets.balance as current_balance')
        ->where('charging_agencies.id' , '=' , $id)
        -> get()[0];

        echo(json_encode($agency));
        exit;
    }
    public function addchargingBalance(Request $request){
        $wallet = AgencyWallet::where('agency_id' , '=' , $request -> id) -> get();
        if(count ($wallet) > 0){
            $wallet[0] -> update([
              'balance' => $wallet[0] -> balance + $request -> charging_value
            ]);
            AgencyChargingOperation::create([
                'agency_id' => $request -> id,
                'user_id' => 0,
                'type' => "IN" , //IN , OUT'
                'gold' => $request -> charging_value,
                'source' => "ADMIN",
                'state' =>  1,
                'charging_date' => Carbon::now()
            ]);
            return redirect()->route('chargingAgencies')->with('success', __('main.created'));

        }
    }
}
