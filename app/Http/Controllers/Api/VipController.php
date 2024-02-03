<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Design ;
use App\Models\Vip ;
use Illuminate\Database\QueryException;

class VipController extends Controller
{
    public function index(){
        try{
            $designs = Design::where('vip_id' , '>' , 0) -> get();
            return response()->json(['state' => 'success' , 'designs' => $designs ]);

        }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }
    
    }
    public function getVip(){
        try{
            $vips = Vip::all();
            return response()->json(['state' => 'success' , 'vips' => $vips ]);

        }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }
    }
}
