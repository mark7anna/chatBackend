<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::all();
        return view('Tag.index' , compact('tags'));
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
                'name' => 'required|unique:tags',
                'type' => 'required',
            ]);

            Tag::create([
                'name' => $request -> name,
                'type' => $request -> type,

            ]);
            return redirect()->route('tags')->with('success', __('main.created'));
        } else {
            return $this -> update($request);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $tag = Tag::find($id);
        echo(json_encode($tag));
        exit ;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $tag = Tag::find($request -> id);
        if($tag){
            $validated = $request->validate([
                'name' => ['required' , Rule::unique('tags')->ignore($request -> id)],
                'type' => 'required',
            ]);

            $tag -> update([
                'name' => $request -> name,
                'type' => $request -> type,

            ]);
            return redirect()->route('tags')->with('success', __('main.updated'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tag = Tag::find($id);
        if($tag){
            $tag -> delete();
            return redirect()->route('tags')->with('success', __('main.deleted'));
        }
    }
}
