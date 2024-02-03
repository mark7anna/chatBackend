<?php

namespace App\Http\Controllers;

use App\Models\Design;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Vip;
use App\Models\Category;
use App\Models\GiftCategory;

class DesignController extends Controller
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
        $designs = DB::table('designs')
         ->leftJoin('categories' , 'designs.category_id' , '=' , 'categories.id')
         ->leftJoin('gift_categories' , 'designs.gift_category_id' , '=' , 'gift_categories.id')
         ->leftJoin('vips' , 'designs.vip_id' , '=' , 'vips.id')
         ->select('designs.*' , 'categories.name as category_name' ,
         'gift_categories.name as gift_category_name' , 'vips.name as vip_name' , 'vips.tag as vip_tag') -> get();

         $vips = Vip::all();
         $cats = Category::all();
         $giftCats = GiftCategory::all();

         return view('store.index' , compact('designs' , 'vips' ,'cats' , 'giftCats'));
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
         
        if($request -> id == 0){
            $validated = $request->validate([
                'name' => 'required',
                'tag' => 'required',
                'order' => 'required',
                'price' => 'required',
                'days' => 'required',
                'behaviour' => 'required',
                'icon' => 'required',
            ]);
            $icon = time() . 'static_icon' . '.' . $request->icon->getClientOriginalExtension();
            $request->icon->move(('images/Designs'), $icon);
            if($request->motion_icon){
                $motion_icon = time() . 'motion_icon' . '.' . $request->motion_icon->getClientOriginalExtension();
                $request->motion_icon->move(('images/Designs/Motion'), $motion_icon);
            } else {
                $motion_icon  = "";
            }
            if($request->dark_icon){
                $dark_icon = time() . 'dark_icon' . '.' . $request->dark_icon->getClientOriginalExtension();
                $request->dark_icon->move(('images/Designs/Dark'), $dark_icon);
            } else {
                $dark_icon  = "";
            }
            Design::create([
                'is_store' => $request->input('is_store') == 'on' ? 1 : 0,
                'name' => $request -> name,
                'tag' => $request -> tag,
                'order' => $request -> order,
                'category_id'=> $request -> category_id ?? 0,
                'gift_category_id'=> $request -> gift_category_id ?? 0,
                'price' => $request -> price,
                'days' => $request -> days,
                'behaviour' => $request -> behaviour,
                'icon' => $icon,
                'motion_icon' => $motion_icon,
                'dark_icon' => $dark_icon,
                'subject' => $request -> subject ?? 0,
                'vip_id' => $request -> vip_id ?? 0,

            ]);
            return redirect()->route('designs')->with('success', __('main.created'));

        } else {
            return $this -> update($request);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $design = Design::find($id);
        echo(json_encode($design));
        exit ;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Design $design)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        
        $design = Design::find($request -> id);
        if($design){

            $validated = $request->validate([
                'name' => 'required',
                'tag' => 'required',
                'order' => 'required',
                'price' => 'required',
                'days' => 'required',
                'behaviour' => 'required',
            ]);

            
            if($request->motion_icon){
            $icon = time() . 'static_icon' . '.' . $request->icon->getClientOriginalExtension();
            $request->icon->move(('images/Designs'), $icon);
            } else {
                $icon =  $design -> icon ;
            }
            if($request->motion_icon){
                $motion_icon = time() . 'motion_icon' . '.' . $request->motion_icon->getClientOriginalExtension();
                $request->motion_icon->move(('images/Designs/Motion'), $motion_icon);
            } else {
                $motion_icon  = $design -> motion_icon ;
            }
            if($request->dark_icon){
                $dark_icon = time() . 'dark_icon' . '.' . $request->dark_icon->getClientOriginalExtension();
                $request->dark_icon->move(('images/Designs/Dark'), $dark_icon);
            } else {
                $dark_icon  = $design -> dark_icon ;
            }

            $design -> update([
                'is_store' => $request->input('is_store') == 'on' ? 1 : 0,
                'name' => $request -> name,
                'tag' => $request -> tag,
                'order' => $request -> order,
                'category_id'=> $request -> category_id ?? 0,
                'gift_category_id'=> $request -> gift_category_id ?? 0,
                'price' => $request -> price,
                'days' => $request -> days,
                'behaviour' => $request -> behaviour,
                'icon' => $icon,
                'motion_icon' => $motion_icon,
                'dark_icon' => $dark_icon,
                'subject' => $request -> subject ?? 0,
                'vip_id' => $request -> vip_id ?? 0,

            ]);
            return redirect()->route('designs')->with('success', __('main.updated'));

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $design = Design::find($id);
        if($design){
            $design -> delete();
            return redirect()->route('designs')->with('success', __('main.deleted'));
        }
    }
}
