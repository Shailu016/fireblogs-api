<?php

namespace App\Http\Controllers;

use App\Models\Likes;
use App\Models\Post;
use Illuminate\Http\Request;

class LikesController extends Controller
{
    public function store(Post $post)
    {
        $like= Likes::where('user_id', auth()->user()->id)->where('post_id', $post->id)->first();
         
     
        if (!$like) {
            $like=  likes::create([
              'user_id' => auth()->user()->id,
              'like'=>1,
              'post_id'=> request('post_id')
            ]);
            return  $like ;
        } else {
            $like->delete();
        }
        
        return "like removed";
    }
}
