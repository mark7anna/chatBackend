<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class LevelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index($type)
    {
        $levels = Level::Where('type' , '=' , $type) -> get();
        return view('Levels.index' , compact('levels' , 'type'));
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

        if($request -> id == 0){
            $validated = $request->validate([
                'order' => 'required',
                'points' => 'required',
                'icon' => 'required',
                'type' => 'required'
            ]);
            $icon = time() . '.' . $request->icon->getClientOriginalExtension();
            $request->icon->move(('images/Levels'), $icon);

            Level::create([
                'order' => $request -> order,
                'points' => $request -> points,
                'icon' => $icon,
                'frame_id' => $request -> frame_id ,
                'enter_id' => $request -> enter_id,
                'type' => $request -> type

            ]);
            return redirect()->route('levels' , $request -> type)->with('success', __('main.created'));

        } else {
            return $this -> update($request);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $level = Level::find($id);
        echo(json_encode($level));
        exit;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Level $level)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
       // return $request ;
        $level = Level::find($request -> id);
        if($level){
            $validated = $request->validate([
                'order' => 'required',
                'points' => 'required',
                'type' => 'required'
            ]);

            if($request->icon){
                $icon = time() . '.' . $request->icon->getClientOriginalExtension();
                $request->icon->move(('images/Levels'), $icon);
            } else {
                $icon  =  $level -> icon ;
            }

            $level -> update([
                'order' => $request -> order,
                'points' => $request -> points,
                'icon' => $icon,
                'frame_id' => $request -> frame_id ,
                'enter_id' => $request -> enter_id,
                'type' => $request -> type
            ]);
            return redirect()->route('levels' , $request -> type)->with('success', __('main.updated'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $level = Level::find($id);
        if($level){
            $level -> delete();
            return redirect()->route('levels' , $level -> type)->with('success', __('main.deleted'));

        }
    }
}
