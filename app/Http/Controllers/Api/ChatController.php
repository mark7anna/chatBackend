<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use App\Models\Chat ;
use App\Models\Message ;
use Carbon\Carbon;

class ChatController extends Controller
{
    public function getUserChats($user_id){
        try{
            $chats = DB::table('chats') 
            -> join('app_users as sender' , 'chats.sender_id' , '=' , 'sender.id' )
            -> join('app_users as receiver' , 'chats.reciver_id' , '=' , 'receiver.id' )
            -> leftJoin('messages' , 'messages.chat_id' , '=' , 'chats.id')
            -> select('chats.*' , 'sender.name as sender_name' , 'sender.img as sender_img' ,
            'receiver.name as receiver_name' , 'receiver.img as receiver_img' ,
             'messages.id as message_id' , 'messages.sender_id as message_sender' , 
             'messages.reciver_id as message_reciver' , 'messages.message_date' ,
             'messages.message' , 'messages.img' , 'messages.type' , 'messages.isSeen')
              -> where('chats.sender_id', '=' , $user_id)
              -> orWhere('chats.reciver_id' , '=' , $user_id) -> get();
           
              return response()->json(['state' => 'success' , 'chats' => $chats]);



        }  catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);
        }
       
    }
    public function sendMessage(Request $request){
        try{
            $chats1 = Chat::Where('sender_id' , '=' , $request -> user_id)
            -> Where('reciver_id' , '=' , $request -> reciver_id) -> get();
            $chats2 = Chat::Where('reciver_id' , '=' , $request -> user_id)
            -> orWhere('sender_id' , '=' , $request -> reciver_id) -> get();
            $chats = array_merge ($chats1->toArray() , $chats2->toArray()) ;
         
            if(count($chats) > 0){
             $id = $chats[0]['id'] ;
             $chat = Chat::find($id);
                $chat-> update([
                'last_action_date' => Carbon::now(),
                'last_message' => $request -> message ?? "",
                'last_sender' => $request -> user_id,
                ]); 
             //  $this -> createMessage($chats[0] -> id , $request);
                return $this -> getUserChats($request -> user_id);
            } else {
                
                $id = Chat::create([
                    'sender_id' => $request -> user_id,
                    'reciver_id' => $request ->reciver_id,
                    'last_action_date' => Carbon::now(),
                    'last_message' => $request -> message ?? "",
                    'last_sender' => $request -> user_id,
                ]) -> id;

              //  $this -> createMessage($id , $request);
                return $this -> getUserChats($request -> user_id);
            }
        } catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }
    }
    public function createMessage($chat_id , Request $request){
        if($request -> img){
            $img = time() . '.' . $request->img->extension();
            $request->img->move(('images/Chats'), $img);
        } else {
            $img = "";
        }
        Message::create([
            'chat_id' => $chat_id,
            'sender_id' => $request -> user_id,
            'reciver_id' => $request -> reciver_id,
            'message_date' =>  Carbon::now(),
            'message' => $request -> message ?? "",
            'img' => $img,
            'type' => $request -> type,
            'isSeen' => 0 
        ]);
    }
}
