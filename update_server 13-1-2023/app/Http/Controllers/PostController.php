<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = DB::table('posts')
        -> join('app_users' , 'posts.user_id' , '=' , 'app_users.id')
        ->select('posts.*' , 'app_users.name as user_name') -> get() ;

        return view('Posts.index' , compact('posts'));
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
    public function show($id)
    {
        $post = DB::table('posts')
        -> join('app_users' , 'posts.user_id' , '=' , 'app_users.id')
        ->select('posts.*' , 'app_users.name as user_name')
        -> where('posts.id' , '=' , $id)
        -> get() ;
        echo(json_encode($post));
        exit;
    }

    public function acceptPost($id){
        $post = Post::find($id);
        if($post){
            $post -> update([
                'accepted' => 1
            ]);
            return redirect()->route('posts')->with('success', __('main.accepted_msg'));

        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if($post){
            $post -> delete();
            return redirect()->route('posts')->with('success', __('main.deleted'));

        }
    }
}
