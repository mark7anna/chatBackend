<?php

namespace App\Http\Controllers;

use App\Models\GiftTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GiftTransactionController extends Controller
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
        $transactions = DB::table('gift_transactions')
        -> join('designs' , 'gift_transactions.gift_id' , '=' , 'designs.id')
        -> join('chat_rooms' , 'gift_transactions.room_id' , '=' , 'chat_rooms.id')
        -> join('app_users as sender' , 'gift_transactions.sender_id' , 'sender.id')
        -> join('app_users as receiver' , 'gift_transactions.receiver_id' , 'receiver.id')
        -> select('gift_transactions.*' , 'designs.name as gift_name' , 'designs.tag as gift_tag' ,
        'designs.icon as gift_img' , 'chat_rooms.name as room_name' , 'chat_rooms.tag as room_tag' ,
        'sender.name as sender_name' , 'sender.tag as sender_tag' , 'sender.img as sender_img',
        'receiver.name as receiver_name' , 'receiver.tag as receiver_tag' , 'receiver.img as receiver_img') -> get();

        return view('giftTransactions.index' , compact('transactions'));
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
    public function show(GiftTransaction $giftTransaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GiftTransaction $giftTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GiftTransaction $giftTransaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GiftTransaction $giftTransaction)
    {
        //
    }
}
