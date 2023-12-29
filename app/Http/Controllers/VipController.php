<?php

namespace App\Http\Controllers;

use App\Models\Vip;
use Illuminate\Http\Request;

class VipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vips = Vip::all();
        return view('Vip.index' , compact('vips'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $vip = Vip::find($id);
        echo(json_encode($vip));
        exit;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vip $vip)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $vip = Vip::find($request -> id);
        if($vip){
            $validated = $request->validate([
                'name' => 'required',
                'tag' => 'required',
                'price' => 'required'
            ]);

            if($request->icon){
                $icon = time() . '.' . $request->icon->extension();
                $request->icon->move(('images/VIP'), $icon);
            } else {
                $icon  =  $vip -> icon ;
            }
            if($request->motion_icon){
                $motion_icon = time() . 'motion' . '.' . $request->motion_icon->extension();
                $request->motion_icon->move(('images/VIPMotion'), $motion_icon);
            } else {
                $motion_icon  =  $vip -> motion_icon ;
            }

            $vip -> update([
                'name' => $request -> name,
                'tag' => $request -> tag,
                'icon' => $icon,
                'motion_icon' => $motion_icon,
                'price' => $request -> price ,

            ]);
            return redirect()->route('vip')->with('success', __('main.updated'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vip $vip)
    {
        //
    }
}
