<?php

namespace App\Http\Controllers;

use App\Models\Themes;
use Illuminate\Http\Request;

class ThemesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $themes = Themes::all();
        return view('Themes.index' , compact('themes'));
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
                'name' => 'required',
                'img' => 'required'
            ]);
            $img = time() . '.' . $request->img->extension();
            $request->img->move(('images/Themes'), $img);
            Themes::create([
                'name' => $request -> name,
                'img' => $img,
                'isMain' => $request->input('isMain') == 'on' ? 1 : 0

            ]);
            return redirect()->route('themes')->with('success', __('main.created'));


        } else {
            return $this -> update($request);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $theme = Themes::find($id);
         echo(json_encode($theme));
         exit;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Themes $themes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $theme = Themes::find($request -> id);
        if($theme){
            $validated = $request->validate([
                'name' => 'required',
            ]);
            if($request -> img){
                $img = time() . '.' . $request->img->extension();
                $request->img->move(('images/Themes'), $img);
            } else {
                $img = $theme -> img ;
            }
            $theme -> update([
                'name' => $request -> name,
                'img' => $img,
                'isMain' => $request->input('isMain') == 'on' ? 1 : 0

            ]);
            return redirect()->route('themes')->with('success', __('main.updated'));

        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $theme = Themes::find($id);
        if($theme){
            $theme -> delete();
            return redirect()->route('themes')->with('success', __('main.deleted'));

        }
    }
}
