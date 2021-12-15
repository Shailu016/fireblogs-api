<?php

namespace App\Http\Controllers;

use App\Models\Likes;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikesController extends Controller
{
    public function store(Post $post)
    {
        $like = Likes::where('user_id', Auth::id())->where('post_id', $post->id)->first();
      
     
        if (!$like) {
            $like=  likes::create([
              'user_id' => Auth::id(),
              'like'=>1,
              'post_id'=> $post->id
            ]);
            return  $like ;
        } else {
            $like->delete();
        }
        
        return response()->json([
            'user_id' => Auth::id(),
            'like'=>0,
            'post_id'=> $post->id
          ]);
    }
    
    public function count(Post $post, Likes $likes)
    {
        $like = Likes::where('post_id', $post->id)->count();
        return response()->json([
            'like'=>$like
        ]);
    }

    public function userlike(Post $post, Likes $likes)
    {
        $post= $post->likes->where('user_id', Auth::id())->where('post_id', $post->id)->first();
        if (! $post) {
            return response()->json([
                'is_like'=>0
            ]);
        }
        return response()->json([
            'is_like'=>1
        ]);
    }
}
