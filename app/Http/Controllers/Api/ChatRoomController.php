<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChatRoom;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatRoomController extends Controller
{
    public function index(){
        try{
            $rooms = DB::table('chat_rooms')
            -> join('countries' , 'chat_rooms.country_id' , '=' , 'countries.id')
            -> join('app_users' , 'chat_rooms.userId' , 'app_users.id')
            -> select('chat_rooms.*' , 'countries.icon as flag' , 'app_users.tag as admin_tag' , 
            'app_users.name as admin_name' , 'app_users.img as admin_img') -> get();
            return $rooms ;
        } catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }
        
    }


    public function search($txt){
        try{
            $rooms = DB::table('chat_rooms')
            -> join('countries' , 'chat_rooms.country_id' , '=' , 'countries.id')
            -> join('app_users' , 'chat_rooms.userId' , 'app_users.id')
            -> select('chat_rooms.*' , 'countries.icon as flag' , 'app_users.tag as admin_tag' , 
            'app_users.name as admin_name' , 'app_users.img as admin_img') 
            -> where('chat_rooms.tag' , 'like' , '%' .$txt . '%' )
            ->orWhere('chat_rooms.name', 'like', '%' . $txt . '%')->get();
            return $rooms ;
        } catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }
        
    }
}
