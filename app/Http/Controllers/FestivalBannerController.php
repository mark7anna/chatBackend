<?php

namespace App\Http\Controllers;

use App\Models\FestivalBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FestivalBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = DB::table('festival_banners')
        -> join('chat_rooms' , 'festival_banners.room_id' , '=' , 'chat_rooms.id')
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
        
    }

    /**
     * Display the specified resource.
     */
    public function show(FestivalBanner $festivalBanner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FestivalBanner $festivalBanner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FestivalBanner $festivalBanner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FestivalBanner $festivalBanner)
    {
        //
    }
}
