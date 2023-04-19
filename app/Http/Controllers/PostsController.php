<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth')->except('show'); 
    }
    public function index()
    {
      
      $users = auth()->user()->following->pluck('user_id');
      $posts = Post::whereIn('user_id',$users)->with('user')->latest()->paginate(4); // or orderBy('created_at','DESC')
       $allUsers =  User::whereNotIn('id',[auth()->user()->id])->get(); 
      return view('posts.index',compact('posts','allUsers'));
    }
    public function create()
    {
        
        return view('posts.create');
    }

    public function store( Request $req){
          
         $data=$req->validate([
            'caption' => ['required'],
            'image'  => ['required','image'] ,
        ]);
        $pathImg = $req->image->store('uploads','public');
        $image = Image::make(public_path("storage/{$pathImg}"))->fit(1200,1200);
        $image->save();
         auth()->user()->posts()->create([
            'caption' =>$data['caption'],
            'image' =>$pathImg,
         ]);
         return redirect('/profile/' . auth()->user()->id);
        
    }

    public function show(Post $post)
    { 
      $likers_id = $post->likers->pluck('id');
      $likers =User::whereIn('id',$likers_id)->get();
      $likeOrNo = (auth()->user()) ? auth()->user()->liking->contains($post) : false;
      $likesCount=$post->likers->count();
      $comments = Comment::where('commentable_id',$post->id)->latest()->paginate(2);
      return view('posts.show',compact('post','comments','likeOrNo','likesCount','likers'));
     }

     public function edit(Post $post)
    {
       // $this->authorize('update',$post);
        return view('posts.edit',[
            'post' => $post
        ]);
    }
    public function update(Post $post)
    {
     // $this->authorize('update',$post);

      $data = Request()->validate([
         'caption' => ['required'],
         'image'  => ['image'] ,
      ]);
      
      if(Request('image')){
        $pathImg = Request('image')->store('uploads','public');
        $image = Image::make(public_path("storage/{$pathImg}"))->fit(1200,1200);
        $image->save();
      }
      $post->update(array_merge(
         $data,
         [ 'image' => $pathImg ?? $post->image] ,
       ));
      return redirect('/profile/' . auth()->user()->id);
    }

    public function destroy(Post $post)
    {
     // $this->authorize('update',$post);
     Post::destroy($post->id);
      return redirect('/profile/' . auth()->user()->id);
    }
   }