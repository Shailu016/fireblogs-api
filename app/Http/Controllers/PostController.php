<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Profile;
use App\Models\Likes;
use App\Models\Category;
use App\Models\User;
use App\Models\Views;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Events\PostPublished;
use App\Notifications\PostCreated;
use Carbon\Carbon; 


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
     event(new PostPublished( $post));
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
                
                $user = User::where('id', Auth::id())->first();
           
            }
           
            $posts = new Post();
            $posts->name = request('name');
            $posts->excerpt = request('excerpt');
            $posts->body = request('body');
            $posts->tags = json_encode(request('tags'));
            
            $posts->image_path = $imagePath ?? null;
           
            $posts->user_id = Auth::id();
            $posts->category_id = request('category_id');
          
            $posts->save();
            
            $user = User::where('id', Auth::id())->where('subscribe', 1)->first();
            if($user){

                $user->notify(new PostCreated('New Post Created'));
            }
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
    public function show(Post $post, Views $views)
    
    {
        // $user = User::where('id', $post->user_id)->get();
       
        // return response()->json(["post"=>$post, 
        // "user"=>$user ]);
       

        $views = Views:: Create([
            'post_id' => $post->id,
            'views' => 1
        ]);

        return response()->json($post);
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

    public function usersPost()
    {
        $post = Post::where('user_id', Auth::id())->get();
        return $post ;
    }

   public function category(Category $category)
   {
         $post = Post::where('category_id', $category->id)->get();
         return $post;
   }

   public function statusUpdateDraft(Post $post)
   {
      
        $post=  $post->update(['status' => "Draft"]);
         return response()->json([
            'message' => 'Post status updated successfully',
            'post' => "Draft"
        
        ]);
       
    }

    public function statusUpdateArchive(Post $post)
    {
        if($post->status == "published"){
            $post=  $post->update(['status' => "Archive"]);
            return response()->json([
                'message' => 'Post status updated successfully',
                'post' => "Archived"
            
            ]);
        }
        else{
            $post = $post->update(['status' => "published"]);
            return response()->json([
                'message' => 'Post status not updated',
                'post' => "Published"
            
            ]);
        }
        
       
    }

    public function post_by_tags(Request $request)
    {
        $post = Post::where('tags', 'like', '%' . $request->tags . '%')->get();
        return $post;
    }

    public function post_views(Post $post)
    {
       $todaysviews =  Views::whereDate('created_at',  Carbon::today()->toDateString())->where('post_id', $post->id)->count();
       $date = Carbon::now()->subDays(7);

       $weeklyViews = Views::whereDate('created_at', '>=', $date)->where('post_id', $post->id)->count();
       $date = Carbon::now()->subDays(30);
       $mothlyViews = Views::whereDate('created_at', '>=', $date)->where('post_id', $post->id)->count();

       $totalViews = Views::where('post_id', $post->id)->count();

       
       
       return response()->json([
           'todays_Views' => $todaysviews,
           'weekly_Views' => $weeklyViews,
           'mothly_Views' => $mothlyViews,
           'total_Views' => $totalViews
       ]);

    
    }

   

   
}
