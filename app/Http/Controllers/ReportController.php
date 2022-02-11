<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Post;
use App\Models\User;
use App\Models\Comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Report $report)
    {
       
        $report = Report::with('comments.users', 'posts')->get();
        
        return response($report);

       
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
    public function store(Comments $comments)
    {
        $report = Report::where('user_id', Auth::id())->where('comment_id', $comments->id )->first();

        if(!$report){

            $report = Report::create([
             'user_id' => Auth::id(),
             'comment_id' =>  $comments->id,
             'post_id' =>  $comments->post_id
    
           ]);
    
           return $report;
    
        }else{
            $report->delete();
            return "report delete";
        }
        
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function block(Report $report)
    {
        $comments = Comments::where('id', $report->comment_id)->first();
        $user = User::where('id', $comments->user_id)->firstOrFail();
       
        // dd($user->toArray());


       if($user->status == 1){
        
        
           
            $user->update([ 
                'status' => 0
            ]);
            return "user is blocked";
        }else{
            $user->update([
                'status'=> 1
            ]);
            return "user is unblocked";
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function all_block_user(Report $report)
    {

        
       $user = User::where('status', 0)->get();
       return  $user;
      
       if(!count($user)  ){

           return "no post is published";
    }
    return response()->json($user);
      
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        //
    }
}
