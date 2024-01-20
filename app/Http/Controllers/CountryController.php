<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CountryController extends Controller
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
        $countries = Country::all();
        return view('Country.index' , compact('countries'));
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
                'name' => 'required|unique:countries',
                'code' => 'required|unique:countries',
                'order' => 'required|unique:countries',
                'dial_code' => 'required|unique:countries',
                'icon' => 'required'
            ]);
            $icon = time() . '.' . $request->icon->getClientOriginalExtension();
            $request->icon->move(('images/Countries'), $icon);
            Country::create([
                'name' => $request -> name,
                'code' => $request -> code,
                'order' => $request -> order,
                'icon' => $icon,
                'dial_code' => $request -> dial_code ,
                'enable' => $request->input('enable') == 'on' ? 1 : 0

            ]);
            return redirect()->route('countries')->with('success', __('main.created'));
        } else {
            return $this -> update($request);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $country = Country::find($id);
        echo(json_encode($country));
        exit;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Country $country)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $country = Country::find($request -> id);
        if($country){
            $validated = $request->validate([
                'name' => ['required' , Rule::unique('countries')->ignore($request -> id)],
                'code' => ['required' , Rule::unique('countries')->ignore($request -> id)],
                'order' => ['required' , Rule::unique('countries')->ignore($request -> id)],
                'dial_code' => ['required' , Rule::unique('countries')->ignore($request -> id)],
            ]);
            if($request->icon){
                $icon = time() . '.' . $request->icon->getClientOriginalExtension();
                $request->icon->move(('images/Countries'), $icon);
            } else {
                $icon  =  $country -> icon ;
            }

            $country -> update([
                'name' => $request -> name,
                'code' => $request -> code,
                'order' => $request -> order,
                'icon' => $icon,
                'dial_code' => $request -> dial_code ,
                'enable' => $request->input('enable') == 'on' ? 1 : 0
            ]);
            return redirect()->route('countries')->with('success', __('main.updated'));





        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $country = Country::find($id);
        if($country){
            $country -> delete();
            return redirect()->route('countries')->with('success', __('main.deleted'));

        }
    }
}
