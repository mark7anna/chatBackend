<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use App\Models\FestivalBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FestivalBannerController extends Controller
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
        $banners = DB::table('festival_banners')
        -> leftJoin('chat_rooms' , 'festival_banners.room_id' , '=' , 'chat_rooms.id')
        -> select('chat_rooms.name as room_name' , 'festival_banners.*')
        -> get();

        return view('FestivalBanner.index' , compact('banners'));
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
                'title' => 'required',
                'type' => 'required',
                'room_id' => 'required',
                'start_date' => 'required',
                'start_date' => 'required',
                'enable' => 'required',
                'accepted' => 'required',
                'img' => 'required'
            ]);
            $img = time() .  '.' . $request->img->getClientOriginalExtension();
            $request->img->move(('images/FestivalBanner'), $img);

            if($request -> room_id){
                $room = ChatRoom::where('tag' , '=' , $request -> room_id) -> get();
                if(count($room) > 0){
                    $room_id  = $room[0] -> id ;
                } else {
                    $room_id =  0;
                }
            } else {
                $room_id =  0;
            }

            FestivalBanner::create([
                'title' => $request -> title,
                'type' => $request -> type,
                'description' => $request -> description ?? "",
                'img' => $img ,
                'room_id' => $room_id,
                'start_date'=> Carbon::parse($request->start_date),
                'duration_in_hour' => $request -> duration_in_hour,
                'enable'=> $request -> enable,
                'accepted'=> $request -> accepted,
            ]);
            return redirect()->route('festival_banners')->with('success', __('main.created'));

        } else {
            return $this -> update($request);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $banner = FestivalBanner::find($id);
        echo(json_encode($banner));
        exit;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $banner = FestivalBanner::find($request -> id);
        if($banner){
            $validated = $request->validate([
                'title' => 'required',
                'type' => 'required',
                'room_id' => 'required',
                'start_date' => 'required',
                'start_date' => 'required',
                'enable' => 'required',
                'accepted' => 'required',
            ]);
            if($request -> img){
                         $img = time() .  '.' . $request->img->getClientOriginalExtension();
            $request->img->move(('images/FestivalBanner'), $img);
            } else {
                $img = $banner -> img ;
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
                'title' => $request -> title,
                'type' => $request -> type,
                'description' => $request -> description ?? "",
                'img' => $img ,
                'room_id' => $room_id,
                'start_date'=> Carbon::parse($request->start_date),
                'duration_in_hour' => $request -> duration_in_hour,
                'enable'=> $request -> enable,
                'accepted'=> $request -> accepted,
            ]);
            return redirect()->route('festival_banners')->with('success', __('main.updated'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $banner = FestivalBanner::find($id);
        if($banner){
            $banner -> delete();
            return redirect()->route('festival_banners')->with('success', __('main.deleted'));

        }
    }
}
