<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\Level;


class LevelsController extends Controller
{
    public function getLevels(){
        try{
           $levels = Level::all();
           return response()->json(['state' => 'success' , 'levels' => $levels ]);

        }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }
    }
}
