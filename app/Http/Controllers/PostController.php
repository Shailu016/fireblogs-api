<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Profile;
use App\Models\Likes;
use App\Models\User;
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
    public function index()
    {

     $post = Post::with('users')->get();
     return response()->json($post);
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
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'excerpt' => 'required',
                'body' => 'required',
                'image' => 'mimes:jpg,png,jpeg,webp|max:50480'

            ]
        );

        try {
            

            
            if(isset($request->image)) {

                $imagePath = time() . $request->name . '.'. $request->image->extension();
                $request->image->move(public_path('images'), $imagePath);

            $user =User::where('id', Auth::id())->first();
           
            
                
            }
           
            $posts = new Post();
            $posts->name = request('name');
            $posts->excerpt = request('excerpt');
            $posts->body = request('body');
            $posts->image_path = $imagePath ?? 'https://www.koimoi.com/wp-content/new-galleries/2020/10/dilip-joshi-turns-into-jethalal-of-taarak-mehta-ka-ooltah-chashmah-irl-this-picture-is-the-proof001.jpg';
            $posts->user_id = Auth::id();
            $posts->category_id = request('category_id');
            $posts->save();
            return response()->json($posts);
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $user = User::where('id', $post->user_id)->get();
       
        return response()->json(["post"=>$post, 
        "user"=>$user ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function user_all_post(Post $post, User $user)
    {
        $post = Post::where('user_id', $user->id)->get();
        return $post;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    { {
            $request->validate(
                [
                    'name' => 'required',
                    'excerpt' => 'required',
                    'body' => 'required',
                    'image' => 'mimes:jpg,png,jpeg,webp|max:50480'

                ]
            );
            try {

                $post->name = request('name');
                $post->excerpt = request('excerpt');
                $post->body = request('body');
                $post->category_id = request('category_id');


                if (request()->hasFile('image')) {
                    $imagePath = time() . $request->name . '.' . $request->image->extension();
                    $request->image->move(public_path('images'), $imagePath);
                    $oldImagePath = public_path('images') . "\\" . $post->image_path;

                    if (File::exists($oldImagePath)) {
                        File::delete($oldImagePath);
                    }

                    $post->image_path = $imagePath;
                }
                $post->save();
                return response()->json($post);
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }
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


    public function publishPost(Post $post)
    {
        if ($post->status == 0) {

            $post->update([
                "status" => 1
            ]);
            return response()->json($post);
        }
        return "Post is already published";
    }

    public function unpublishPost(Post $post)
    {
        if ($post->status == 1) {
            $post->update([
                "status" => 0
            ]);
            return response()->json($post);
        }
        return "Post is already unpublished";
    }

    public function publish()
    {

        $post = Post::with('users')->where('status', 1)->get();
       if(!count($post)  ){

           return "no post is published";
    }
    return response()->json($post);
      
    }

    public function usersPost()
    {
        $post = Post::where('user_id', Auth::id())->get();
        return $post ;
    }

   
       
}
