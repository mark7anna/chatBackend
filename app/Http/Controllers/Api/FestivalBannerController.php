<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FestivalBanner;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class FestivalBannerController extends Controller
{
    public function index(){
        try{
            $banners = FestivalBanner::where('enable' , '=' , 1)
            -> where('accepted' , '=' , 1)
            -> where('start_date' , '>=' , Carbon::now() -> addDays(-1))
            -> get();
            return $banners ;
        }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }

    }

}
