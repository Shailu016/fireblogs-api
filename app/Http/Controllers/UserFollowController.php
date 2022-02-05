<?php

namespace App\Http\Controllers;

use App\Models\UserFollow;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserFollowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Post $post)
    {
    //    $userFollow = UserFollow::where('user_id', Auth::id())->where('author', $post->user_id)->first();
    //    if(!$userFollow){
           
    //     $userFollow = UserFollow::create([
    //         'user_id' => Auth::id(),
    //         'author' =>$post->user_id
    //     ]);
    //     return $userFollow;
       
    //    }else{
        
    //     $userFollow->delete();
    //     return "user unfollows";

        
    //    }


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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserFollow  $userFollow
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $userFollow = UserFollow::where('user_id', Auth::id())->first();
       $post = Post::where('user_id', $userFollow->author)->get();
       
       return $post;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserFollow  $userFollow
     * @return \Illuminate\Http\Response
     */
    public function edit(UserFollow $userFollow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserFollow  $userFollow
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserFollow $userFollow)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserFollow  $userFollow
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserFollow $userFollow)
    {
        //
    }
}
