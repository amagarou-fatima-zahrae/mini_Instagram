<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use App\Models\Profile;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth'); 
    }

    public function create()
    {
        $allUsers =  User::whereNotIn('id',[auth()->user()->id])->get();
        return view('messages.create',compact('allUsers'));
    }
    
    public function store( Request $req){
         
        $data=$req->validate([
           'receiver' => ['required',],
           'Messagecontent'  => ['required','min:5'] ,
       ]);
       $profile_id = User::where('username',$data['receiver'])->first()->profile->id;
        auth()->user()->messages()->create([
            'user_id' => auth()->user()->id,
           'profile_id' => $profile_id,
           'content' =>$data['Messagecontent'],
           
        ]);
        return redirect('/profile/' . auth()->user()->id);
       
   }
   public function storeDirect( Profile $profile){
         
    $data=Request()->validate([
       'content'  => ['required','min:5'] ,
   ]);
    auth()->user()->messages()->create([
        'user_id' => auth()->user()->id,
       'profile_id' => $profile->id,
       'content' =>$data['content'],
       
    ]);
    return redirect('/messages/show');
   
}

   public function show()
   { 
    $msgs_senders=Message::Where('profile_id',auth()->user()->profile->id)->paginate(1);
    $msgsRecCount= Message::Where('profile_id',auth()->user()->profile->id)->get()->count();
    $msgs_receivers=Message::Where('user_id',auth()->user()->id)->paginate(1);
    $msgsSentCount = Message::Where('user_id',auth()->user()->id)->get()->count();
     return view('messages.show',compact('msgs_senders','msgs_receivers','msgsSentCount','msgsRecCount'));
    }

    public function destroy( $msg)
    {
    
     Message::find($msg)->delete();
    
     return redirect('/messages/show');
    }
   
 }
 /*
   'msgs_senders' => $msgs_senders,
            'msgs_recievers' => $msgs_recievers,

   

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

    
    */

