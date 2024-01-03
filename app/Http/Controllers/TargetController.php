<?php

namespace App\Http\Controllers;

use App\Models\Target;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TargetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $targets = Target::all();
        return view('Target.index' , compact('targets'));


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
                'order' => 'required|unique:targets',
                'gold' => 'required',
                'dollar_amount' => 'required',
                'agent_amount' => 'required',

            ]);
            $icon = time() . '.' . $request->icon->extension();
            $request->icon->move(('images/Target'), $icon);

            Target::create([
                'order' => $request -> order,
                'gold' => $request -> gold,
                'dollar_amount' => $request -> dollar_amount,
                'agent_amount' => $request -> agent_amount,
                'icon' => $icon

            ]);
            return redirect()->route('targets')->with('success', __('main.created'));
        } else {
            return $this -> update($request);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $target = Target::find($id);
        echo(json_encode($target));
        exit ;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Target $target)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $target = Target::find($request -> id);
        if($target){
            $validated = $request->validate([
                'order' => ['required' , Rule::unique('targets')->ignore($request -> id)],
                'gold' => 'required',
                'dollar_amount' => 'required',
                'agent_amount' => 'required',

            ]);
            if($request -> icon){
                $icon = time() . '.' . $request->icon->extension();
                $request->icon->move(('images/Target'), $icon);
            } else {
                $icon = $target -> icon ;
            }
            $target -> update([
                'order' => $request -> order,
                'gold' => $request -> gold,
                'dollar_amount' => $request -> dollar_amount,
                'agent_amount' => $request -> agent_amount,
                'icon' => $icon
            ]);
            return redirect()->route('targets')->with('success', __('main.updated'));

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $target = Target::find($id);
        if($target){
            $target -> delete();
            return redirect()->route('targets')->with('success', __('main.deleted'));

        }
    }
}
