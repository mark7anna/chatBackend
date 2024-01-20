<?php

namespace App\Http\Controllers;

use App\Models\Emossions;
use Illuminate\Http\Request;

class EmossionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index ()
    {
        $emossions = Emossions::all();
        return view ('Emotions.index' , compact('emossions'));

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
        if($request -> id == 0 ){
            $validated = $request->validate([
                "img" => "required",
                "icon" => "required"
            ]);

                $img = time() . '.' . $request->img->getClientOriginalExtension();
                $request->img->move(('images/Emossions'), $img);
                $icon = time() . 'icon' .'.' . $request->icon->getClientOriginalExtension();
                $request->icon->move(('images/Emossions'), $icon);



            Emossions::create([
              'img' => $img,
              'icon' => $icon,
            ]);
            return redirect()->route('emotions')->with('success', __('main.created'));

        } else {
            return $this -> update($request);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $emossion = Emossions::find($id);
        echo(json_encode($emossion));
        exit;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Emossions $emossions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $emossion = Emossions::find($request -> id);
        if($emossion){
             if($request -> img){
                $img = time() . '.' . $request->img->getClientOriginalExtension();
                $request->img->move(('images/Emossions'), $img);
             } else {
                $img = $emossion -> img ;
             }
             if($request -> icon){
                $icon = time() . 'icon' .'.' . $request->icon->getClientOriginalExtension();
                $request->icon->move(('images/Emossions'), $icon);
             } else {
                $icon = $emossion -> icon ;
             }
             $emossion -> update ([
                'img' => $img,
                'icon' => $icon,
             ]);
             return redirect()->route('emotions')->with('success', __('main.updated'));

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $emossion = Emossions::find($id);
        if($emossion){
            $emossion -> delete();
            return redirect()->route('emotions')->with('success', __('main.deleted'));
        }
    }
}
