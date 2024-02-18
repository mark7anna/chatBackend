<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = Settings::all() ;
        if(count($settings) == 0)
        $setting = null ;
       else 
        $setting = $settings[0] ;

        return view ('Settings.index' , compact('setting'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request -> id > 0){
           $setting = Settings::find($request -> id);
           if($setting){
            $setting -> update([
               'diamond_to_gold_ratio' => $request -> diamond_to_gold_ratio ,
               'gift_sender_diamond_back' => $request -> gift_sender_diamond_back ,
               'gift_room_owner_diamond_back' => $request -> gift_room_owner_diamond_back ,

            ]);
            return redirect()->route('settings')->with('success', __('main.updated'));

           }
        } else {
            Settings::create([
                'diamond_to_gold_ratio' => $request -> diamond_to_gold_ratio ,
                'gift_sender_diamond_back' => $request -> gift_sender_diamond_back ,
                'gift_room_owner_diamond_back' => $request -> gift_room_owner_diamond_back ,
 
             ]);
             return redirect()->route('settings')->with('success', __('main.created'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Settings $settings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Settings $settings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Settings $settings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Settings $settings)
    {
        //
    }
}
