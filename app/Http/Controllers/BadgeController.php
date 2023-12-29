<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class BadgeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $badges = Badge::all();
        return view('Badges.index' , compact('badges'));
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
                'name' => 'required|unique:badges',
                'icon' => 'required',
            ]);
            $icon = time() . '.' . $request->icon->extension();
            $request->icon->move(('images/Badges'), $icon);

            Badge::create([
                'name' => $request -> name,
                'icon' => $icon,
                'description' => $request -> description ?? ""

            ]);
            return redirect()->route('badges')->with('success', __('main.created'));

        } else {
            return $this -> update($request);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $badge = Badge::find($id);
        echo(json_encode($badge));
        exit;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Badge $badge)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $badge = Badge::find($request -> id);
        if($badge){
            $validated = $request->validate([
                'name' => ['required' , Rule::unique('badges')->ignore($request -> id)],
            ]);
            if($request->icon){
                $icon = time() . '.' . $request->icon->extension();
                $request->icon->move(('images/Badges'), $icon);
            } else {
                $icon  =  $badge -> icon ;
            }

            $badge -> update([
                'name' => $request -> name,
                'icon' => $icon,
                'description' => $request -> description ?? ""
            ]);
            return redirect()->route('badges')->with('success', __('main.updated'));

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $badge = Badge::find($id);
        if($badge){
            $badge -> delete();
            return redirect()->route('badges')->with('success', __('main.deleted'));

        }
    }
}
