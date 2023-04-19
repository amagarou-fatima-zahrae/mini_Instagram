@extends('layouts.app')

@section('content')
    
  <div class="container my-3 mx-5">
    <div class="row mb-3 ">
      @if ($posts->count()!=0)
          @foreach ($posts as $post)
    <div class="col-6 mb-4">
      <div class="card">
        <img src="/storage/{{$post->image}}" class="img-fluid"  class="card-img-top" alt="">
        <div class="card-body text-start">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="pe-3">
              <img src="{{$post->user->profile->profileImg()}}" class="img-fluid rounded-circle" style="max-width: 50px" >
            </div>
            <div>
              <div class="fw-bold">
                <a href="/profile/{{$post->user->id}}" class="link-success">
                  <span class="text-dark"></span>
                  <button type="button" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="bottom" title="go to profile">
                    {{$post->user->username}}
                  </button>
                </a>
              
              </div>
            </div>
          </div>
          <span class="text-black-50">published the: {{$post->updated_at->format('d/m/Y H:m')}}</span> 
            <h5 class="card-title">
              <p>{{$post->caption}} </p>
            </h5>
        </div>
      </div>
     </div>
     @endforeach
      @else
      <div class="alert alert-primary" role="alert">
        You are new , you have no friend ; look at those profiles !!!
      </div>
      @foreach ($allUsers as $user)
        
        <div class="col-lg-6 col-md-12 mb-4">
          <div class="card">
            <img src="{{$user->profile->profileImg()}}" class="img-fluid"  class="card-img-top" alt="">
            <div class="card-body text-start">
              <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="pe-3">
                  
                  <a href="/profile/{{$user->id}}" class="link-success ">
                      <i class="fa-regular fa-eye text-success fa-2x"></i>
                  </a>
                  
                </div>
                <div>
                  <div class="fw-bold"> 
                    <span class="text-dark">{{$user->username}}</span>
                  </div>
                </div>
              </div>
              <span class="text-black-50">{{$user->profile->title}}</span> 
                <h5 class="card-title">
                  <p>{{$user->profile->description}} </p>
                </h5>
            </div>
          </div>
         </div>
       @endforeach
      @endif
    
    </div>
   
    
    <div class="row">
        <div class="col-12 text-center">
            {{$posts->links()}}
        </div>
    </div>
  </div>
    
@endsection

