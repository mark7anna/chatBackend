<?php

namespace App\Http\Controllers;

use App\Models\GiftCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GiftCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cats = GiftCategory::all();
        return view('store.GiftCategory.index' , compact('cats'));
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
                'name' => 'required|unique:gift_categories',
                'order' => 'required|unique:gift_categories',
            ]);

            GiftCategory::create([
                'name' => $request -> name,
                'order' => $request -> order,
                'enable' => $request->input('enable') == 'on' ? 1 : 0

            ]);
            return redirect()->route('giftCategories')->with('success', __('main.created'));
        } else {
            return $this -> update($request);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = GiftCategory::find($id);
        echo(json_encode($category));
        exit ;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GiftCategory $giftCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $category = GiftCategory::find($request -> id);
        if($category){
            $validated = $request->validate([
                'name' => ['required' , Rule::unique('gift_categories')->ignore($request -> id)],
                'order' => ['required' , Rule::unique('gift_categories')->ignore($request -> id)],
            ]);


            $category -> update([
                'name' => $request -> name,
                'order' => $request -> order,
                'enable' => $request->input('enable') == 'on' ? 1 : 0
            ]);
            return redirect()->route('giftCategories')->with('success', __('main.updated'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = GiftCategory::find($id);
        if($category){
            $category -> delete();
            return redirect()->route('giftCategories')->with('success', __('main.deleted'));
        }
    }
}
