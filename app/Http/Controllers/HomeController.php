<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatRoom;
use App\Models\AppUser;
class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $roomsActive = ChatRoom::where('state' , '=' , 1) -> get();
        $roomsActiveCount = count( $roomsActive);
        $roomsInActive = ChatRoom::where('state' , '=' , 0) -> get();
        $roomsInActiveCount = count( $roomsActive);
        $onlineUsers = AppUser::where('isOnline' , '=' , 1) -> get();
         $onlineUsersCount = count($onlineUsers);
         $allUsers = AppUser::all();
         $allUsersCount = count($allUsers);

        return view('home' , compact('roomsActiveCount' , 'roomsInActiveCount' , 'onlineUsersCount' , 'allUsersCount'));
    }
}
