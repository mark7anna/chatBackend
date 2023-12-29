<?php

namespace App\Http\Controllers;

use App\Models\SpecialID;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SpecialIDController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ids = SpecialID::all();
        return view('ID.index' , compact('ids'));

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
                'uid' => 'required|unique:special_i_d_s',
                'img' => 'required',
                'price' => 'required'
            ]);
            $img = time() . '.' . $request->img->extension();
            $request->img->move(('images/UID'), $img);

            SpecialID::create([
              'uid' => $request -> uid ,
              'img' => $img ,
              'price' => $request -> price ,
              'isAvailable' => $request->input('isAvailable') == 'on' ? 1 : 0
            ]);
            return redirect()->route('specialUID')->with('success', __('main.created'));

        } else {
            return $this -> update($request);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $uid = SpecialID::find($id);
        echo(json_encode($uid));
        exit ;

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SpecialID $specialID)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $uid = SpecialID::find($request -> id);
        if($uid){
            $validated = $request->validate([
                'uid' => ['required' , Rule::unique('special_i_d_s')->ignore($request -> id)],
                'price' => 'required'
            ]);
            if($request -> img){
                $img = time() . '.' . $request->img->extension();
                $request->img->move(('images/UID'), $img);
            } else {
                $img = $uid -> img ;
            }
            $uid -> update([
                'uid' => $request -> uid ,
                'img' => $img ,
                'price' => $request -> price ,
                'isAvailable' => $request->input('isAvailable') == 'on' ? 1 : 0
            ]);
            return redirect()->route('specialUID')->with('success', __('main.updated'));

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $uid = SpecialID::find($id);
        if($uid){
            $uid -> delete();
            return redirect()->route('specialUID')->with('success', __('main.deleted'));

        }
    }
}
