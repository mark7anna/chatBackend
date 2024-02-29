<?php

namespace App\Http\Controllers;

use App\Models\AppUser;
use App\Models\Banner;
use App\Models\ChatRoom;
use Illuminate\Http\Request;

class BannerController extends Controller
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
        $banners = Banner::all();
        return view('Banner.index' , compact('banners'));
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
                'type' => 'required',
                'name' => 'required',
                'order' => 'required',
                'img' => 'required',
                'action' => 'required',
            ]);
            $img = time() . '.' . $request->img->getClientOriginalExtension();
            $request->img->move(('images/Banners'), $img);

            $user_id = 0 ;
            $room_id  = 0 ;
            if($request -> user_id){
                $user = AppUser::where('tag' , '=' , $request -> user_id) ->get();
                if(count($user) > 0 ){
                    $user_id = $user[0] -> id ; 
                } else {
                    $user_id = 0 ;
                }
            } else {
                $user_id = 0 ;
            }
            if($request -> room_id){
                $room = ChatRoom::where('tag' , '=' , $request -> room_id) -> get();
                if(count($room) > 0){
                    $room_id  = $room[0] -> id ;
                } else {
                    $room_id  = 0 ;
                }
            } else {
                $room_id  = 0 ;
            }

            Banner::create([
                'type' => $request -> type,
                'name' => $request -> name,
                'img' => $img,
                'order' => $request -> order ,
                'action' => $request -> action,
                'url' => $request -> url ?? "",
                'user_id' => $user_id,
                'room_id' => $room_id,

            ]);
            return redirect()->route('banners')->with('success', __('main.created'));


        }  else {
            return $this -> update($request);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
       $banner = Banner::find($id);
       echo(json_encode($banner));
       exit ;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $banner = Banner::find($request -> id);
        if($banner){
            $validated = $request->validate([
                'type' => 'required',
                'name' => 'required',
                'order' => 'required',
                'action' => 'required',
            ]);
            if($request->img){
                $img = time() . '.' . $request->img->getClientOriginalExtension();
                $request->img->move(('images/Banners'), $img);
            } else {
                $img  =  $banner -> img ;
            }
            $user_id = 0 ;
            $room_id  = 0 ;
            if($request -> user_id){
                $user = AppUser::where('tag' , '=' , $request -> user_id) ->get();
                if(count($user) > 0 ){
                    $user_id = $user[0] -> id ; 
                } else {
                    $user_id =  $banner -> user_id;
                }
            } else {
                $user_id =  $banner -> user_id;
            }
            if($request -> room_id){
                $room = ChatRoom::where('tag' , '=' , $request -> room_id) -> get();
                if(count($room) > 0){
                    $room_id  = $room[0] -> id ;
                } else {
                    $room_id =  $banner -> room_id;
                }
            } else {
                $room_id =  $banner -> room_id;
            }

            $banner -> update([
                'type' => $request -> type,
                'name' => $request -> name,
                'img' => $img,
                'order' => $request -> order ,
                'action' => $request -> action,
                'url' => $request -> url ?? "",
                'user_id' => $user_id,
                'room_id' =>  $room_id,

            ]);
            return redirect()->route('banners')->with('success', __('main.updated'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $banner = Banner::find($id);
        if($banner ){
            $banner  -> delete();
            return redirect()->route('banners')->with('success', __('main.deleted'));

        }
    }
}
