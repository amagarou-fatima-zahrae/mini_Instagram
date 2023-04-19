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
    
  <div class="container my-3 mx-5">
    <div class="row ">
        <div class="card  mx-5 border-0 rounded-0 ">
          <div class="row  ">
            <div class="col-md-6">
              <img src="{{auth()->user()->profile->profileImg()}} " class="img-fluid " >
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-5">
              <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                  <button type="button" class="btn btn-primary position-relative" style="pointer-events: none;">
                    Messages received
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                      <i class="fa-regular fa-message"> {{$msgsRecCount}} </i>
                      <span class="visually-hidden">unread messages</span>
                    </span>
                  </button>
                </div>
                  @forelse ($msgs_senders as $msgs_sender)
                 <div class="d-flex justify-content-start">
                  <div class="pe-3">
                    <img src="{{$msgs_sender->user->profile->profileImg()}}" class="img-fluid rounded-circle" style="max-width: 50px" >
                  </div>
                  
                    <div class="d-flex justify-content-between align-items-center fw-bold">
                      <a href="/profile/{{$msgs_sender->user->id}}">
                        <span class="text-dark">{{$msgs_sender->user->username}}</span>
                      </a>
                    </div> 
                 </div>
                  
                 <p class="card-text mb-2" >{{$msgs_sender->content}} </p>
                 <p class=" mb-2 text-black-50"> sent the : {{$msgs_sender->created_at->format('d/m/Y H:m')}} </p>
                 <div  class="d-flex justify-content-end align-items-center fw-bold">
                 <button  class="btn btn-primary mb-2" onclick="replyForm({{$msgs_sender->user->profile->id}})"><i class="fa-solid fa-reply"></i></button> 
                 </div>
                 <form method="POST" class="d-none" action="/message/{{$msgs_sender->user->profile->id}}" enctype="multipart/form-data" id="response-{{$msgs_sender->user->profile->id}}" class="mb-3" >
                   @csrf
                   <div class="pb-3">
                      <div class="form-group d-flex justify-content-between align-items-center gap-3">
                       <x-label for="content"  class="pb-2"  />
                       <textarea id="content" class="form-control" type="text" cols="10" rows="1" name="content" :value="old('content')" class="@error('content') is-invalid @enderror" placeholder="put your message" autofocus required autocomplete="content"></textarea>
                     @error(('content')) 
                         <span class="invalid-feedback" role="alert">
                             <strong>{{$errors->first('content')}} </strong>
                         </span>
                     @enderror
                     <button type="submit" class="btn btn-primary "><i class="fa-solid fa-comment"></i></button>
                      </div>
                 </div>
                 </form>
                 <hr class="my-2">
                  @empty
                  <p class="text-danger">no one send you a message</p>
                  @endforelse
                  
                   <div class="row">
                    <div class="col-12 text-center">
                        {{$msgs_senders->links()}}
                    </div>
                </div> 
                  <hr class="my-4">
                  
                  <div class="d-flex align-items-center mb-3">
                    <button type="button" class="btn btn-primary position-relative" style="pointer-events: none;">
                      Messages sent
                      <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <i class="fa-regular fa-message"> {{$msgsSentCount}} </i>
                        <span class="visually-hidden">unread messages</span>
                      </span>
                    </button>
                  </div>
                    @forelse ($msgs_receivers as $msgs_receiver)
                   <div class="d-flex justify-content-start">
                    <div class="pe-3">
                      <img src="{{$msgs_receiver->Profile->user->profile->profileImg()}}" class="img-fluid rounded-circle" style="max-width: 50px" >
                    </div>
                    
                      <div class="d-flex justify-content-between align-items-center fw-bold">
                        <a href="/profile/{{$msgs_receiver->Profile->user->id}}">
                          <span class="text-dark">{{$msgs_receiver->Profile->user->username}}</span>
                        </a>
                      </div> 
                   </div>
                    
                   <p class="card-text mb-2" >{{$msgs_receiver->content}} </p>
                   <p class=" mb-2 text-black-50"> sent the : {{$msgs_receiver->created_at->format('d/m/Y H:m')}} </p>
                   <div  class="d-flex justify-content-end align-items-center fw-bold">
                    <form method="POST" action="/message/{{$msgs_receiver->id}}" enctype="multipart/form-data">
                      @csrf
                      @method('DELETE')
                      <div class="d-flex items-center justify-end mt-2">
                       <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button>
                     </div>
                    </form>
                  </div>
                   <hr class="my-2">
                    @empty
                    <p class="text-danger">no one send you a message</p>
                    @endforelse
      
                    <div class="row">
                      <div class="col-12 text-center">
                          {{$msgs_receivers->links()}}
                      </div>
                  </div>
          </div>
        </div>
      </div>
  </div>
  </div>
  
  
@endsection

