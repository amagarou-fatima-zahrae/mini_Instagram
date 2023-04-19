@extends('layouts.app')
@section('extra-js')
 <script>
    function replyForm(id){
    let form = document.getElementById('response-'+id);
    form.classList.toggle('d-none');
    }
    
 </script>
@endsection 
@section('content')
    <div class="container p-5">
      <div class="row">
        <div class="col-3">
            <img src="{{$user->profile->profileImg()}}" alt="" class="rounded-circle w-100">
        </div>
        <div class="col-9">
            <div class="d-flex justify-content-between">
                <div class="d-flex align-items-center pb-3">
                    <h1 class="text-dark text-capitalize fw-bold merriweather">{{$user->username}}</h1>
                    @auth
                    @cannot ('update',$user->profile)
                    <form method="POST" action="/follow/{{$user->id}}" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex items-center justify-end mt-2">
                            <button  class="btn btn-success rounded-pill ms-5" class="text-dark"  >{{$follows}} </button>
                       </div>
                      </form>
                   @endcannot 
                   @can ('update',$user->profile)
                    <nav class="navbar navbar-expand-lg navbar-white bg-white pt-3 ms-2">
                        <div class="container-fluid">
                          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                          </button>
                          <div class="collapse navbar-collapse" >

                            <form method="POST" action="/profileSearch"   enctype="multipart/form-data" class="d-flex">
                                @csrf
                              <input class="form-control me-2" type="search" placeholder="Search users" autocomplete="off" aria-label="Search" name="profile_username" >
                              <button class="btn btn-outline-success redressed "  type="submit">Search</button>
                            </form>
                          </div>
                        </div>
                      </nav>
                       @endcan
                      @endauth
                </div>
                 @auth
                 @cannot('update',$user->profile)
                 <div  class="d-flex justify-content-end align-items-center fw-bold">
                  <button  class="btn  btn-success mb-2 " onclick="replyForm({{$user->profile->id}})"><i class="fa-solid fa-paper-plane"></i></button> 
                  </div>
                  <form method="POST" class="d-none" action="/message/{{$user->profile->id}}" enctype="multipart/form-data" id="response-{{$user->profile->id}}" style="margin-bottom:-30px ; width:400px" >
                    @csrf
                    <div class="pb-3">
                       <div class="form-group">
                        <x-label for="content"  class="pb-2"  />
                        <textarea id="content" class="form-control" type="text" cols="8" rows="1" name="content" :value="old('content')" class="@error('content') is-invalid @enderror" placeholder="put your message" autofocus required autocomplete="content"></textarea>
                      @error(('content')) 
                          <span class="invalid-feedback" role="alert">
                              <strong>{{$errors->first('content')}} </strong>
                          </span>
                      @enderror
                      <div  class="d-flex justify-content-end align-items-center fw-bold">
                      <button type="submit" class="btn btn-success mt-2"><i class="fa-solid fa-comment"></i></button>
                       </div>
                      </div>
                  </div>
                  </form>
                 @endcannot
                 @can('update',$user->profile)
                 <button class="btn btn-success rounded-pill"><a  href="/post/create" class="text-dark"><i class="fa-solid fa-plus"> post</i></a> </button>
                 <button class="btn btn-success rounded"><a class="btn btn-success rounded-pill" href="/message/create" class="text-dark"><i class="fa-solid fa-paper-plane fa-2x"></i></a> </button>
                @endcan
                 @endauth
                
            </div>
           @can('update',$user->profile)
           <button class="btn btn-success"><a href="/profile/{{$user->id}}/edit" class="text-dark"> <i class="fa-solid fa-pen-to-square"> Profile</i></a> </button>
           @endcan
           <div class="fw-bold">{{$user->profile->title ?? ''}} </div>
            <div>{{$user->profile->description ?? '' }} </div>
            <div class="mb-4"><a href="{{$user->profile->url ?? ""}}" target="_blank">{{$user->profile->url ?? ""}} </a></div>
            <ul class='list-unstyled d-flex' gap-2>
              <li class="pe-5" style="margin-top:-7px;">
                <button type="button" class="btn btn-success position-relative" style="pointer-events: none;">
                  <strong class="text-success text-white">Posts</strong>
                  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{$postCount}}
                    <span class="visually-hidden"></span>
                  </span>
                </button>
              </li>
                 <li class="pe-5">
                    <nav class="navbar  navbar-white bg-white" style="margin-top:-20px;">
                        <div class="container">
                          <a class="navbar-brand" >
                            <button type="button" class="btn btn-success position-relative" style="pointer-events: none;">
                              <strong>Followers</strong>
                              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $followersCount}} 
                                <span class="visually-hidden"></span>
                              </span>
                            </button></a>
                          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="fa-solid fa-bars" style="color:#198754;"></i>
                          </button>
                          <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                @forelse ($followers as $follower)
                                <li class="nav-item ms-4">
                                  <a class="nav-link fw-bold" style="color:teal" href="/profile/{{$follower->id}}"> {{$follower->username}} </a>
                                </li>
                                @empty
                                   no follower
                                @endforelse
                            </ul>
                          </div>
                        </div>
                      </nav>
                </li>
                
                <li class="pe-5">
                  <nav class="navbar  navbar-white bg-white" style="margin-top:-20px;">
                    <div class="container">
                      <a class="navbar-brand" >
                        <button type="button" class="btn btn-success position-relative" style="pointer-events: none;">
                          <strong>Following</strong>
                          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $followingCount}} 
                            <span class="visually-hidden"></span>
                          </span>
                        </button></a>
                      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent2" aria-controls="navbarSupportedContent2" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fa-solid fa-bars" style="color:#198754;"></i>
                      </button>
                      <div class="collapse navbar-collapse" id="navbarSupportedContent2">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            @forelse ($followings as $following)
                            <li class="nav-item ms-4">
                              <a class="nav-link fw-bold" style="color:teal" href="/profile/{{$following->id}}"> {{$following->username}} </a>
                            </li>
                            @empty
                               no following
                            @endforelse
                        </ul>
                      </div>  
                    </div>
                  </nav>
                </li>
              
                @auth
                 @can ('update',$user->profile)
                 <li class="pe-5">
                  <a href="/messages/show">
                    <button type="button" class="btn btn-success position-relative" style="margin-top:-10px;">
                      <strong class="text-success text-white"><i class="fa-solid fa-envelope fa-2x px-3"></i></strong>
                      <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{$messagesCount}}
                        <span class="visually-hidden"></span>
                      </span>
                    </button>
                  </a>
                 </li>
              
                @endcan
                @endauth
              </ul>
                
        </div>
        </div>
        <div class="row pt-5">
           @forelse ($user->posts as $post)
           <div class="col-3 pb-4">
            <a href="/post/{{$post->id}}"><img src="/storage/{{$post->image}}"  class="card-img-top" alt=""></a>
          </div>
           @empty
               <div class="text-dark">aucun post</div>
           @endforelse 
        </div>
    </div>
    
@endsection










{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    You're logged in!
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}