<?php

use App\Mail\NewUserWelcomeMail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowsController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfilesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::post('/follow/{user}',[FollowsController::class,'store'])->whereNumber('user');

Route::post('/like/{post}',[FollowsController::class,'storeLike'])->whereNumber('post');

Route::post('/comments/{post}',[CommentController::class,'store'])->whereNumber('post')->name('comments.store');

// Route::get('/email',function(){
//     return new NewUserWelcomeMail();
// });
 
//posts:
Route::get('/',[PostsController::class,'index']);
Route::get('/post/{post} ',[PostsController::class,'show'])->whereNumber('post')->name('post.show');
Route::get('/post/create ',[PostsController::class,'create'])->name('post.create');
Route::post('/post ',[PostsController::class,'store'])->name('post.store');
Route::get('/post/{post}/edit ',[PostsController::class,'edit'])->name('post.edit');
Route::patch('/post/{post} ',[PostsController::class,'update'])->name('post.update');
Route::delete('/post/{post}',[PostsController::class,'destroy'])->name('post.destroy');

//messages
Route::get('/message/create',[MessageController::class,'create']);
Route::post('/message',[MessageController::class,'store']);
Route::post('/message/{profile}',[MessageController::class,'storeDirect'])->whereNumber('post');
Route::get('/messages/show',[MessageController::class,'show'])->whereNumber('message');
Route::delete('/message/{message}',[MessageController::class,'destroy'])->whereNumber('message');
//comments
Route::post('/comments/{post}',[CommentController::class,'store'])->whereNumber('post');
Route::post('/commentsReply/{comment}',[CommentController::class,'storeReply'])->whereNumber('comment');
//profile
Route::get('/profile/{user} ',[ProfilesController::class,'index'])->name('profile.index');
Route::get('/profile/{user}/edit ',[ProfilesController::class,'edit'])->name('profile.edit');
Route::patch('/profile/{user} ',[ProfilesController::class,'update'])->name('profile.update');
//profile search
Route::post('/profileSearch ',[ProfilesController::class,'search'])->name('profile.search');

// Route::get('/dashboard',[ProfilesController::class,'index'])->middleware(['auth'])->name('dashboard');
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

//---------------------------------------------------------------------------------------------

require __DIR__.'/auth.php';
