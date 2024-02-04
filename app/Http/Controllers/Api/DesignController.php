<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Design;
use Illuminate\Database\QueryException;

class DesignController extends Controller
{
    public function getAllCatsWithDesigns(){
        try{
            $categories = Category::where('enable' , '=' , 1) -> orderBy('order' ,'ASC') -> get();
            $designs = Design::where('is_store' , '=' , 1) -> get();;
            return response()->json(['state' => 'success' , 'categories' => $categories , 'designs' => $designs ]);

         } catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

         }
    
    }

    public function getAllMedals(){
        try{
            $medals = Badge::all();
            return response()->json(['state' => 'success' , 'medals' => $medals  ]);


        }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }
    }
}
