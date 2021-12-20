<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Likes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Post $post)
    {
        $posts = $post->all();

        return response()->json($posts);
    }
   
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Post $post)
    {
        request()->validate(
            [
              'name'=>'required',
              'excerpt'=>'required',
              'body'=>'required',
              'image'=>'mimes:jpg,png,jpeg,webp|max:50480'
        
            ]
        );
        if (isset($request->image)) {
            $imagePath = time() . $request->name . '.'. $request->image->extension();
            $request->image->move(public_path('images'), $imagePath);
        }
            
        $posts = new Post();
        $posts->name = request('name');
        $posts->excerpt = request('excerpt');
        $posts->body = request('body');
        $posts->tags = request('tags');
        $posts->image_path = $imagePath ?? null;
        $posts->user_id = Auth::id();
        $posts->save();
        return response()->json($posts);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //$like= Likes::where('user_id', Auth::id())->where('post_id', $post->post_id)->first();
        return response()->json($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        request()->validate(
            [
              'name'=>'required',
              'excerpt'=>'required',
              'body'=>'required',
              'image'=>'mimes:jpg,png,jpeg,webp|max:5048'
            ]
        );

        $post->name = request('name');
        $post->excerpt = request('excerpt');
        $post->body = request('body');
        $post->tags = request('tags');
    
        
        if (request()->hasFile('image')) {
            $imagePath = time() . $request->name. '.'. $request->image->extension();
            $request->image->move(public_path('images'), $imagePath);
            $oldImagePath = public_path('images') . "\\" . $post->image_path;
            
            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }

            $post->image_path = $imagePath;
        }
        $post->save();
        return response()->json($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function delete(Post $post)
    {
        $post->delete();
        return "Post deleted successfully";
    }
}
