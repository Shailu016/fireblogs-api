<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Comments $comments)
    {
        $comments = Comments::with('users')->get();
        return response()->json($comments);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Comments $comments, Post $post)
    {
        request()->validate([
            'body' => 'required'
            
        ]);
       
        
//dd( Auth::user()->name);
if(Auth::user()->status == 0){
    return "You are blocked";
}else{
    $comments = Comments::create([
        //'user_id' => 1,
     'user_id' => Auth::id(),
     'user_name' => Auth::user()->name,
     'image_path' => Auth::user()->image_path,
     "post_id" => $post->id,
    'body' => request('body')
   ]);
   $comments['users'] = Auth::user();
    
   return response()->json($comments);

}
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comments $comments, Post $post)
    {
        $comments = Comments::where("post_id", $post->id)->first();
      
        return response()->json($comments);
    }

    public function delete(Comments $comments)
    { 
        $comments->delete();
        return response()->json($comments);
    }

   
}
