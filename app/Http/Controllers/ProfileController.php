<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use App\Models\Post;
use App\Models\UserFollow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     
     */
    public function store(Request $request)
    {
            $user = User::where('id', Auth::id())->first();
            // if(isset($request->image)) {

            //     $imagePath = time() . $request->name . '.'. $request->image->extension();
            //     $request->image->move(public_path('images'), $imagePath);
                 
            //     $post->image_path = $imagePath;
            //     $post->save();
            //          return $user->image;
            $user->name = request('name');
            $user->youtube = request('youtube');
            $user->facebook = request('facebook');
            $user->instagram = request('instagram');
            $user->bio = request('bio');
           
            

                     
                if (request()->hasFile('image')) {
                    $imagePath = time() . $request->name . '.' . $request->image->extension();
                    $request->image->move(public_path('images'), $imagePath);
                    $oldImagePath = public_path('images') . "\\" . $user->image_path;

                    if (File::exists($oldImagePath)) {
                        File::delete($oldImagePath);
                    }

                    $user->image_path = $imagePath;
                }
                $user->save();
                
               return  response()->json([
                   "name" => $user->name,
                   "image_path" => $user->image_path,
                   "youtube" => $user->youtube,
                   "facebook" => $user->facebook,
                   "instagram" => $user->instagram,
                   "bio" => $user->bio,
               ]);
            

            // $profile->image_path = $imagePath ?? null;
            // $profile->user_id = Auth::id();
        
            
}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function all_users(Profile $profile)
    {
        $users= User::withcount('posts')->get();
    
      
    //   $user = Userfollow::pluck('following_id');

    //   $user = UserFollow::whereIn('following_id', $user)->get();
    //   dd($user);
    //   $user = User::whereIn('id',$user)->get();
    //   dd($user);
      
     return response($users);
       
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
