<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return view('Roles.index' , compact('roles'));
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
                'role' => 'required|unique:roles',
            ]);
            Role::create([
               'role' => $request -> role ,
               'description' => $request -> description ?? ""
            ]);
            return redirect()->route('roles')->with('success', __('main.created'));



        } else {
            return $this -> update($request);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $role = Role::find($id);
        echo(json_encode($role));
        exit ;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $role = Role::find($request -> id);
        if($role){
            $validated = $request->validate([
                'role' => ['required' , Rule::unique('roles')->ignore($request -> id)],
            ]);
            $role -> update([
                'role' => $request -> role ,
                'description' => $request -> description ?? ""
             ]);
             return redirect()->route('roles')->with('success', __('main.updated'));

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        if($role){
           $role -> delete();
           return redirect()->route('roles')->with('success', __('main.deleted'));

        }
    }
}
