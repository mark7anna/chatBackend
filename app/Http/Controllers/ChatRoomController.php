<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatRoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index($state)
    {
        $rooms = DB::table('chat_rooms')
        ->join('app_users' , 'chat_rooms.userId' , '=' , 'app_users.id')
        -> select('chat_rooms.*' , 'app_users.name as room_owner')
        -> where('chat_rooms.state' , '=' , $state)
        -> get();
        return view('ChatRoom.index' , compact('rooms' , 'state'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ChatRoom $chatRoom)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChatRoom $chatRoom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ChatRoom $chatRoom)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChatRoom $chatRoom)
    {
        //
    }
}
