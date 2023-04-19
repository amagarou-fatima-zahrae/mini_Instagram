<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
   
   public function __construct()
   {
      $this->middleware('auth'); 
   }
    public function store(Post $post){
         
        Request()->validate([
           'content' => 'required|min:5',
       ]);
       $comment =new Comment();
       $comment->content =Request('content'); 
       $comment->user_id=auth()->user()->id;
        $post->comments()->save($comment);
        
        return redirect("post/{$post->id}");
       
   }
   public function storeReply(Comment $comment){
         
      Request()->validate([
         'Replycontent' => 'required|min:5',
     ]);
     $commentReply =new Comment();
     $commentReply->content =Request('Replycontent'); 
     $commentReply->user_id=auth()->user()->id;
      $comment->comments()->save($commentReply);
      
      return redirect()->back();
     
 }
}
