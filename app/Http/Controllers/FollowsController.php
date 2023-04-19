<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class FollowsController extends Controller
{
   public function __construct()
   {
      $this->middleware('auth'); 
   }
    public function store(User $user)
    {
       auth()->user()->following()->toggle($user->profile);
       
       return redirect("profile/{$user->id}");
    }

    public function storeLike(Post $post)
    {
       auth()->user()->liking()->toggle($post);
       
       return redirect()->back();
    }
}
