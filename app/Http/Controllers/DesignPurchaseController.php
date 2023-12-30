<?php

namespace App\Http\Controllers;

use App\Models\DesignPurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DesignPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = DB::table('design_purchases') 
        ->join('designs' , 'designs.id' , 'design_purchases.design_id')
        ->join('app_users' , 'app_users.id' , 'design_purchases.user_id')
        -> select('designs.icon as design_iocn' , 'designs.name as design_name' , 
        'app_users.name as user_name' , 'app_users.img as user_img' , 
        'design_purchases.*') -> get();

        return view ('DesignPurchases.index' , compact('purchases'));

        
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
    public function show(DesignPurchase $designPurchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DesignPurchase $designPurchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DesignPurchase $designPurchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DesignPurchase $designPurchase)
    {
        //
    }
}
