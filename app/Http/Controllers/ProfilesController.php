<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProfilesController extends Controller
{


    public function index($user)
    {
        $user = User::findOrFail($user);
        $followings_id = $user->following->pluck('user_id');;
        $followings =User::whereIn('id',$followings_id)->get();

        $followers_id = $user->profile->followers->pluck('id');;
        $followers =User::whereIn('id',$followers_id)->get();

         $follows = (auth()->user()) ? auth()->user()->following->contains($user->profile) : false;
         if($follows){
          $follow_status = "following";
         }
         else {
          $follow_status = "follow me";
         }
        $postCount = $user->posts->count();
        $followersCount=$user->profile->followers->count() ;
        $followingCount=$user->following->count(); 

       $auth = (auth()->user()) ? auth()->user() : null;
       
        $messagesCount=Message::where('profile_id',(auth()->user()) ? $auth->profile->id:-3)->get()->count();;
        return view('profiles.index', [
            'user' => $user,
            'follows' => $follow_status,
            'postCount' =>  $postCount,
            'followersCount' => $followersCount,
            'followingCount' => $followingCount,
            'followings' => $followings,
            'followers' => $followers,
           
            'messagesCount' => $messagesCount,
        ]);
    }
    public function edit(User $user)
    {
        $this->authorize('update',$user->profile);
        return view('profiles.edit',[
            'user' => $user
        ]);
    }

    public function update(User $user)
    {
      $this->authorize('update',$user->profile);

      $data = Request()->validate([
        'title' => ['required'],
        'description' =>  ['required'] ,
        'url' =>['url'] ,
        'image' => ['image'],
      ]);
      
      if(Request('image')){
        $pathImg = Request('image')->store('profiles','public');
        $image = Image::make(public_path("storage/{$pathImg}"))->fit(1000,1000);
        $image->save();
      }
      $user->profile()->update(array_merge(
        $data,
        [ 'image' => $pathImg ?? $user->profile->image] ,
      ));
      return redirect("profile/{$user->id}");
    }

    public function search(Request $req)
    {
    
      $data = Request()->validate([
        'profile_username' => ['required'],
      ]);
      $user = User::where('username',$req->profile_username)->firstOrFail();
      // dd($user->id);
      return redirect("profile/{$user->id}");
    }
}

