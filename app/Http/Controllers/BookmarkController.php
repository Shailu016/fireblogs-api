<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add(User $user, Post $post)
    {
        $bookmark = Bookmark::where('user_id', Auth::id())->where('post_id', $post->id)->first();
        
        if (!$bookmark) {
            $bookmark=  Bookmark::create([
            'user_id' => Auth::id(),
            'post_id'=> $post->id,
            
            ]);
           
            
            return response()->json([
                'is_bookmark'=>1
            ]);
        } else {
            $bookmark->delete();
            return response()->json([
                'is_bookmark'=>0
            ]);
        }
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
    public function get(Post $post, User $user)
    {
        $bookmark = Bookmark::where('user_id', Auth::id())->get();
        return  $post['bookmark'] = $bookmark;
    }
    

    /**
     *
     * Display the specified resource.
     *
     * @param  \App\Models\Bookmark  $bookmark
     * @return \Illuminate\Http\Response
     */
    public function check(Bookmark $book, User $user)
    {
        $bookmark = Bookmark::where('user_id', Auth::id())->where('post_id', request('post_id'))->first();
        if (!$bookmark) {
            return response()->json([
                'is_bookmark'=>0
            ]);
        } else {
            return response()->json([
                'is_bookmark'=>1
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bookmark  $bookmark
     * @return \Illuminate\Http\Response
     */
    public function edit(Bookmark $bookmark)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bookmark  $bookmark
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bookmark $bookmark)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bookmark  $bookmark
     * @return \Illuminate\Http\Response
     */
    public function remove(Bookmark $bookmark)
    {
        $bookmark->delete();
        return "boomark removed";
    }
}
