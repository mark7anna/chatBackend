<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    //
    public function index(){
        try{
            $banners = Banner::all();
            return $banners ;

        }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }
       
    }
}
