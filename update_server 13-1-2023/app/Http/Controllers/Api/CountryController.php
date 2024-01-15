<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index(){
        try{
            $countries = Country::where('enable' , '=' , 1) -> get();
            return $countries ;

        }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }

       
    }
}
