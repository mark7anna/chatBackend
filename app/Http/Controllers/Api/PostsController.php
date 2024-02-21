<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AppUser;
use App\Models\Comment;
use App\Models\Post;
use App\Models\PostLike;
use App\Models\PostReport;
use App\Models\PostTage;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
    public function index(){

        try{
            $posts = DB::table('posts')
            ->leftJoin('post_tages' , 'posts.id' , '=' , 'post_tages.post_id')
            ->leftJoin('tags' ,function ($join) {
                $join->on('post_tages.tag_id', '=', 'tags.id');
            }) 
            ->join('app_users' , 'posts.user_id' , '=' , 'app_users.id') 
            ->join('levels as share_level' ,function ($join) {
                $join->on('app_users.share_level_id', '=', 'share_level.id');
            }) 
            ->join('levels as karizma_level' ,function ($join) {
                $join->on('app_users.karizma_level_id', '=', 'karizma_level.id');
            }) 
            ->join('levels as charging_level' ,function ($join) {
                $join->on('app_users.charging_level_id', '=', 'charging_level.id');
            }) 
            -> select('posts.*' , 'app_users.name as user_name' , 'app_users.tag as user_tag' , 
            'app_users.gender as gender' , 'app_users.img as user_img' , 'share_level.icon as share_level_img' ,
            'karizma_level.icon as karizma_level_img' , 'charging_level.icon as charging_level_img' , 'tags.name as tag'  ) 
            -> where('posts.accepted' , '=' , 1)
            -> get();
    
            $likes = DB::table('post_likes')
            -> join('app_users' , 'post_likes.user_id' , '=' , 'app_users.id')
            -> select('post_likes.*' , 'app_users.name as user_name' , 'app_users.tag as user_tag' 
            , 'app_users.gender as gender' , 'app_users.img as user_img') -> get(); 

            $comments = DB::table('comments')
            -> join('app_users' , 'comments.user_id' , '=' , 'app_users.id')
            -> select('comments.*' , 'app_users.name as user_name' , 'app_users.tag as user_tag' 
            , 'app_users.gender as gender' , 'app_users.img as user_img') -> get();

            $reports = PostReport::all();
            return response()->json(['state' => 'success' , 'posts' => $posts , 'likes' => $likes , 'reports' => $reports , 'comments' => $comments]);
        }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }
    }

    public function likePost($post_id , $user_id){
       $post = Post::find($post_id);
       $action_user = AppUser::find($user_id);
       $postLikes = PostLike::where('post_id' , '=' , $post_id)
       -> where('user_id' , '=' , $user_id) -> get();
        
         if($post){
                if(count($postLikes) == 0){
                    $likes = $post -> likes_count + 1 ;
                    try{
                        $post -> update([
                        'likes_count' => $likes
                        ]);
                        PostLike::create([
                        'post_id' => $post_id ,
                        'user_id' => $user_id ,
                        'total_count' => 0
                        ]);
                        $this -> createUserNotification('MOMENTS' ,$post -> user_id , $user_id , 'Your Post has new Like', $action_user -> name . ' liked your Post' , 
                        'لديك إعجاب جديد علي أحد منشوراتك' , $action_user -> name . ' ' . ' قام بالإعجاب لأحد منشوراتك'  , $post_id );
                        return $this -> index();
                    }catch(QueryException $ex){
                        return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);
                    }
               

                } else {
                    return response()->json(['state' => 'failed' , 'message' => 'Can not Like this Post , You Liked Before']);
                }
         } else {
               return response()->json(['state' => 'failed' , 'message' => 'Can not Find this Post']);
         }
    }
    public function unlikePost($post_id , $user_id){
        $post = Post::find($post_id);
        $postLikes = PostLike::where('post_id' , '=' , $post_id)
        -> where('user_id' , '=' , $user_id) -> get();

        if($post){
            if(count($postLikes) > 0){
                $likes = $post -> likes_count - 1 ;
                try{
                   $post -> update([
                        'likes_count' => $likes
                     ]);
                     $postLikes[0] -> delete();
                     return $this -> index();
                    } catch(QueryException $ex){
                    return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

                }
             
            } else {
                return response()->json(['state' => 'failed' , 'message' => 'Can not unLike this Post , You did not Like Before']);

            }

        } else {
            return response()->json(['state' => 'failed' , 'message' => 'Can not Find this Post']);
        }
    }

    public function reportPost($post_id , $user_id , $type){
        try{
            $post = Post::find($post_id);
            if($post){
                PostReport::create([
                    'post_id' => $post_id,
                    'user_id' => $user_id,
                    'type' => $type
                ]);
                return $this -> index();
            } else {
                return response()->json(['state' => 'failed' , 'message' => 'Can not Find this Post']);
            }
        }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);
        }
        
    }

  public function addComment(Request $request){
      try{

        Comment::create([
            'post_id' => $request -> post_id,
            'user_id'=> $request -> user_id,
            'content'=> $request -> content,
            'order'=> $request -> order ?? 0,
        ]);
        
        $comments = DB::table('comments')
        -> join('app_users' , 'comments.user_id' , '=' , 'app_users.id')
        -> select('comments.*' , 'app_users.name as user_name' , 'app_users.tag as user_tag' 
        , 'app_users.gender as gender' , 'app_users.img as user_img') -> get();
        $post = Post::find($request -> post_id);
        if($post){
            $likes = $post -> comments_count + 1 ;
            $post -> update([
                'comments_count' => $likes
                ]);
        }

        return response()->json(['state' => 'success' , 'comments' => $comments ]);
      }catch(QueryException $ex){
        return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

      }

  }
    
  function AddPost(Request $request){

    try{
    if($request -> img){
        $img = time() . '.' . $request->img->extension();
        $request->img->move(('images/Posts'), $img);
    } else {
        $img = "";
    }

   $id = Post::create([
        'content' => $request -> content ?? "",
        'user_id' => $request -> user_id,
        'img' => $img,
        'auth' => $request -> auth,
        'accepted' => 0,
        'likes_count' => 0,
        'comments_count' => 0
    ]) -> id;

    PostTage::create([
        'post_id' => $id,
        'tag_id' => $request -> tag_id
    ]);
    return response()->json(['state' => 'success' , 'message' => "Post Added Successfully" ]);

    } catch(QueryException $ex){

    }

  }

  function getTags(){
    try{
        $tags = Tag::where('type' , '=' , 2) -> get();
        return response()->json(['state' => 'success' , 'tags' => $tags ]);

    }catch(QueryException $ex){
        return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

    }
  }

  public function getUserPosts($user_id){
    try{
        $posts = DB::table('posts')
        ->leftJoin('post_tages' , 'posts.id' , '=' , 'post_tages.post_id')
        ->leftJoin('tags' ,function ($join) {
            $join->on('post_tages.tag_id', '=', 'tags.id');
        }) 
        ->join('app_users' , 'posts.user_id' , '=' , 'app_users.id') 
        ->join('levels as share_level' ,function ($join) {
            $join->on('app_users.share_level_id', '=', 'share_level.id');
        }) 
        ->join('levels as karizma_level' ,function ($join) {
            $join->on('app_users.karizma_level_id', '=', 'karizma_level.id');
        }) 
        ->join('levels as charging_level' ,function ($join) {
            $join->on('app_users.charging_level_id', '=', 'charging_level.id');
        }) 
        -> select('posts.*' , 'app_users.name as user_name' , 'app_users.tag as user_tag' , 
        'app_users.gender as gender' , 'app_users.img as user_img' , 'share_level.icon as share_level_img' ,
        'karizma_level.icon as karizma_level_img' , 'charging_level.icon as charging_level_img' , 'tags.name as tag'  ) 
        -> where('posts.accepted' , '=' , 1)
        -> where('posts.user_id' , '=' , $user_id)
        -> get();

        $likes = DB::table('post_likes')
        -> join('app_users' , 'post_likes.user_id' , '=' , 'app_users.id')
        -> select('post_likes.*' , 'app_users.name as user_name' , 'app_users.tag as user_tag' 
        , 'app_users.gender as gender' , 'app_users.img as user_img') -> get(); 

        $comments = DB::table('comments')
        -> join('app_users' , 'comments.user_id' , '=' , 'app_users.id')
        -> select('comments.*' , 'app_users.name as user_name' , 'app_users.tag as user_tag' 
        , 'app_users.gender as gender' , 'app_users.img as user_img') -> get();

        $reports = PostReport::all();
        return response()->json(['state' => 'success' , 'posts' => $posts , 'likes' => $likes , 'reports' => $reports , 'comments' => $comments]);
    }catch(QueryException $ex){
        return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

    }

  }

}
