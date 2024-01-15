<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index (){

        $admins = DB::table('users')
        -> leftJoin('roles' , 'users.role' , '=' , 'roles.id')
        -> select('users.*' , 'roles.role as role_name') -> get() ;


        $roles = Role::all();

        return view('Admins.index' , compact('admins' ,'roles'));
    }

    public function store(Request $request){
       if($request -> id == 0) {
        $validated = $request->validate([
            'name' => 'required|unique:users',
            'email' => 'required|unique:users',
            'password' => "required",
            "role" => "required"
        ]);
        if($request -> img){
            $img = time() . '.' . $request->img->extension();
            $request->img->move(('images/Admins'), $img);
        } else {
            $img = "";
        }
        User::create([
            'name' => $request -> name,
            'email' => $request -> email,
            'password' => Hash::make($request -> password),
            'img' => $img,
            "role" => $request -> role
        ]);

        return redirect()->route('admins')->with('success', __('main.created'));

       } else {
        return $this -> update($request);
       }
    }
    public function update(Request $request){
        $user = User::find($request -> id);
        if($user){
            $validated = $request->validate([
                'name' => ['required' , Rule::unique('users')->ignore($request -> id)],
                'email' => ['required' , Rule::unique('users')->ignore($request -> id)],
                'role' => 'required'
            ]);
            if($request -> img){
                $img = time() . '.' . $request->img->extension();
                $request->img->move(('images/Admins'), $img);
            } else {
                $img = $user -> img ?? "";
            }

            $user -> update([
                'name' => $request -> name,
                'email' => $request -> email,
                'img' => $img,
                "role" => $request -> role
            ]);
            return redirect()->route('admins')->with('success', __('main.updated'));
        }
    }
    public function show($id){
        $user = User::find($id);
        echo(json_encode($user));
        exit ;
    }
    public function destroy($id){
        $user = User::find($id);
        if($user){
            $user -> delete();
            return redirect()->route('admins')->with('success', __('main.deleted'));

        }
    }

}
