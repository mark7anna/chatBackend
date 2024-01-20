<?php

namespace App\Http\Controllers;

use App\Models\HostAgency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;


class HostAgencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agencies = DB::table('host_agencies')
        -> join('app_users' , 'host_agencies.user_id' , '=' , 'app_users.tag')
        -> select('host_agencies.*' , 'app_users.name as user_name' , 'app_users.tag as user_tag')
        -> get();

        return view ('Agency.index' , compact('agencies'));
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
                'name' => 'required|unique:host_agencies',
                'tag' => 'required|unique:host_agencies',
                'user_id' => 'required|unique:host_agencies',
            ]);

            HostAgency::create([
                    'name' => $request -> name,
                    'tag' => $request -> tag,
                    'user_id' => $request -> user_id,
                    'monthly_gold_target' => $request -> monthly_gold_target ?? 0,
                    'details'=> $request -> details ?? "",
                    'active' => $request->input('active') == 'on' ? 1 : 0,
                    'allow_new_joiners' =>$request->input('allow_new_joiners') == 'on' ? 1 : 0,
                    'automatic_accept_joiners' => $request->input('automatic_accept_joiners') == 'on' ? 1 : 0,
                    'automatic_accept_exit' => $request->input('automatic_accept_exit') == 'on' ? 1 : 0,
            ]);
            return redirect()->route('agencies')->with('success', __('main.created'));


        } else {
            return $this -> update($request);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $agency = HostAgency::find($id);
        echo(json_encode($agency));
        exit;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HostAgency $hostAgency)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $agency = HostAgency::find($request -> id);
        if($agency){
            $validated = $request->validate([
                'name' => ['required' , Rule::unique('host_agencies')->ignore($request -> id)],
                'tag' => ['required' , Rule::unique('host_agencies')->ignore($request -> id)],
                'user_id' => ['required' , Rule::unique('host_agencies')->ignore($request -> id)],
                'active' => 'required',
                'allow_new_joiners' => 'required',
                'automatic_accept_joiners' => 'required',
                'automatic_accept_exit' => 'required'
            ]);
            if($request -> icon){
                $icon = time() . '.' . $request->icon->getClientOriginalExtension();
                $request->icon->move(('images/Agency'), $icon);
            } else {
                $icon = $agency -> icon ;
            }

            $agency -> update([
                'name' => $request -> name,
                'tag' => $request -> tag,
                'user_id' => $request -> user_id,
                'monthly_gold_target' => $request -> monthly_gold_target,
                'details'=> $request -> details,
                'active' => $request -> active,
                'allow_new_joiners' => $request -> allow_new_joiners,
                'automatic_accept_joiners' => $request -> automatic_accept_joiners,
                'automatic_accept_exit' => $request -> automatic_accept_exit,
        ]);
        return redirect()->route('agencies')->with('success', __('main.updated'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $agency = HostAgency::find($id);
        if($agency){
            $agency -> delete();
            return redirect()->route('agencies')->with('success', __('main.deleted'));

        }
    }
}
