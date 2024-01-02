<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class CategoryController extends Controller
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
        $cats = Category::all();
        return view('store.Category.index' , compact('cats'));
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
                'name' => 'required|unique:categories',
                'order' => 'required|unique:categories',
            ]);

            category::create([
                'name' => $request -> name,
                'order' => $request -> order,
                'enable' => $request->input('enable') == 'on' ? 1 : 0

            ]);
            return redirect()->route('categories')->with('success', __('main.created'));
        } else {
            return $this -> update($request);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = Category::find($id);
        echo(json_encode($category));
        exit ;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $category = Category::find($request -> id);
        if($category){
            $validated = $request->validate([
                'name' => ['required' , Rule::unique('categories')->ignore($request -> id)],
                'order' => ['required' , Rule::unique('categories')->ignore($request -> id)],
            ]);


            $category -> update([
                'name' => $request -> name,
                'order' => $request -> order,
                'enable' => $request->input('enable') == 'on' ? 1 : 0
            ]);
            return redirect()->route('categories')->with('success', __('main.updated'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if($category){
            $category -> delete();
            return redirect()->route('categories')->with('success', __('main.deleted'));
        }
    }
}
