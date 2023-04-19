@extends('layouts.app')

@section('extra-js')
 <script>
    function replyForm(id){
    let form = document.getElementById('response-'+id);
    form.classList.toggle('d-none');
    }
    function replies(id){
    let repliesDiv = document.getElementById('replies-'+id);
    repliesDiv.classList.toggle('d-none');
    }
    
 </script>
@endsection

@section('content')
  <div class="container my-3 mx-5">
    <div class="row ">
        <div class="card  mx-5 border-0 rounded-0 ">
          <div class="row  ">
            <div class="col-md-6">
              <img src="/storage/{{$post->image}} " class="img-fluid " >
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-5">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div class="pe-3">
                    <img src="{{$post->user->profile->profileImg()}}" class="img-fluid rounded-circle" style="max-width: 50px" >
                  </div>
                  
                    <div class="d-flex justify-content-between align-items-center fw-bold">
                      <a href="/profile/{{$post->user->id}}">
                        <span class="text-dark">{{$post->user->username}}</span>
                      </a>
                      @auth
                      <form method="POST" action="/like/{{$post->id}}" enctype="multipart/form-data" class="ms-5">
                          @csrf
                          <div class="mt-2 ms-5 d-flex justify-content-center align-items-center ">
                              <button  class="btn  rounded ms-5"><i class="fa-solid fa-heart fa-3x text-{{$likeOrNo==0 ? 'light': 'danger'}}" style="border-color: black"></i></button>
                              <div></div>
                              <div >
                                <nav class="navbar  navbar-white bg-white" style="margin-left:-10px">
                                  <div class="container">
                                    <a class="navbar-brand"></a>
                                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"  data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                      <i class="fa-solid fa-heart text-danger"><strong class="text-danger"> {{$likesCount!=0 ? $likesCount:''}}</strong></i>
                                    </button>
                                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                          @foreach($likers as $liker)
                                          <li class="nav-item">
                                            <a class="nav-link" href="/profile/{{$liker->id}}"> {{$liker->username===(auth()->user()->username ?? 'none') ? 'you':$liker->username}} </a>
                                          </li>
                                          @endforeach
                                      </ul>
                                    </div>
                                  </div>
                                </nav>
                              </div>
                         </div>
                        </form> 
                      @endauth
                    </div>
                  
                </div>
            <hr>
                <p class="card-text mb-2">{{$post->caption}} </p>
                <p class="text-black-50 "><i class="fa-solid fa-right-long"></i> published the : <strong>{{$post->updated_at}}</strong>  </p>
                @auth
                 @can ('update',$post->user->profile)
                 <div class="d-flex justify-content-between align-items-center">
                  <a href="/post/{{$post->id}}/edit" class="btn btn-success"><i class="fa-solid fa-pen-to-square"></i>

                  </a>

                 <form method="POST" action="/post/{{$post->id}}" enctype="multipart/form-data">
                  @csrf
                  @method('DELETE')
                  <div class="d-flex items-center justify-end mt-2">
                   <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button>
                 </div>
                </form>
                </div>
                 @endcan 
                @endauth
               
                <hr>
                <button type="button" class="btn btn-primary position-relative mb-2" style="pointer-events: none;">
                  comments
                  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    <i class="fa-regular fa-message"> {{$comments->count()}} </i>
                    <span class="visually-hidden">unread messages</span>
                  </span>
                </button>
                    @auth
                    <form method="POST" action="/comments/{{$post->id}}" enctype="multipart/form-data" >
                      @csrf
                      <div class="py-3">
                         <div class="form-group d-flex justify-content-between align-items-center gap-3">
                          {{-- <x-label for="content" :value="__('your comment')" class="pb-2"/> --}}
                        <textarea id="content" class="form-control" type="text" cols="10" rows="1" name="content" :value="old('content')" placeholder="put your comment" autofocus required autocomplete="content"></textarea>
                        @error(('content'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$errors->first('content')}} </strong>
                            </span>
                        @enderror
                        <button type="submit" class="btn btn-primary "><i class="fa-solid fa-comment"></i></button>
                         </div>
                        {{-- <div class="flex items-center justify-end mt-4">
                          <button type="submit" class="btn btn-primary">submit</button>
                       </div> --}}
                    </div>
                    </form>
                    @endauth
                    
                    @forelse ($comments as $comment)
                        <div class="card mb-3">
                          <div class="card-body">
                            {{$comment->content}}
                            <div class="d-flex justify-content-between align-items-center">
                              <small>Posted the {{$comment->created_at->format('d/m/Y H:m')}} </small>
                              <button class="badge bg-success rounded-pill btn-lg"><a class="link-light p-2" href="/profile/{{$comment->user->id}}">{{$comment->user->username===(auth()->user()->username ?? 'none') ? 'you':$comment->user->username}} </a></button>
                            </div>
                          </div>
                        </div>
                        <div class="d-flex justify-content-between">
                        <button  class="btn btn-primary mb-2" onclick="replies({{$comment->id}})"><i class="fa-solid fa-eye"> </i></button>
                          @auth
                          <button  class="btn btn-primary mb-2" onclick="replyForm({{$comment->id}})"><i class="fa-solid fa-reply"></i></button>
                          @endauth
                        </div>
                        {{-- onclick="replies({{$comment->id}})" --}}
                        <div  class="d-none" id="replies-{{$comment->id}}" >
                          @forelse ($comment->comments as $reply)
                          <div class="card mb-3 ms-5">
                            <div class="card-body">
                              {{$reply->content}}
                              <div class="d-flex justify-content-between align-items-center">
                                <small>Posted the {{$reply->created_at->format('d/m/Y H:m')}} </small>
                                <button class="badge bg-success rounded-pill btn-lg"><a class="link-light p-2" href="/profile/{{$reply->user->id}}">{{$reply->user->username===(auth()->user()->username ?? 'none') ? 'you':$comment->user->username}} </a></button>
                              </div>
                            </div>
                          </div>
                          @empty
                            <div class="ms-5"> no reply </div>
                          @endforelse
                        </div>
                        @auth
                        <form method="POST" class="d-none" action="/commentsReply/{{$comment->id}}" enctype="multipart/form-data" id="response-{{$comment->id}}" >
                          @csrf
                          <div class="pb-3">
                             <div class="form-group d-flex justify-content-between align-items-center gap-3">
                              <x-label for="content"  class="pb-2"  />
                              <textarea id="content" class="form-control" type="text" cols="10" rows="1" name="Replycontent" :value="old('Replycontent')" class="@error('Replycontent') is-invalid @enderror" placeholder="put your answer" autofocus required autocomplete="Replycontent"></textarea>
                            @error(('Replycontent'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{$errors->first('Replycontent')}} </strong>
                                </span>
                            @enderror
                            <button type="submit" class="btn btn-primary "><i class="fa-solid fa-comment"></i></button>
                             </div>
                        </div>
                        </form>
                        @endauth
                        <hr class="fw-bold">
                    @empty
                        <div> no comment</span>
                    @endforelse

                    <div class="row">
                        <div class="col-12 text-center">
                            {{$comments->links()}}
                        </div>
                    </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
  
  
@endsection

