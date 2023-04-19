@extends('layouts.app')

@section('content')
    
  <div class="container my-3 mx-5">
    <div class="row mx-5">
        {{-- <x-auth-validation-errors class="mb-4" :errors="$errors" /> --}}
        @if ($errors->any())
           @foreach ($errors->all() as $error)
             <div style="color:red;font-weight:bold"> {{ $error }} </div>
           @endforeach
        @endif

        <form method="POST" action="/message"  class="mx-5" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <h1>write message</h1>
          </div>
            <!-- caption -->
            <div class="py-3">
                <x-label for="receiver" :value="__('message receiver')" class="py-3 "/>
                <select class="form-select" name="receiver" aria-label="Default select example" id="receiver" required >
                  <option selected>choose your receiver</option>
                  @foreach ($allUsers as $user)
                  <option value="{{$user->username}} ">{{$user->username}}</option>
                  @endforeach
                </select>
            </div>
            <div>
              <x-label for="content"  class="pb-2" :value="__('message')" />
              <textarea id="content" class="form-control" type="text" cols="10" rows="1" name="Messagecontent" :value="old('Messagecontent')" class="@error('Messagecontenty') is-invalid @enderror" placeholder="write your message"></textarea>
            </div>
            

            <div class="flex items-center justify-end mt-4">
              <button type="submit" class="btn btn-primary "><i class="fa-regular fa-paper-plane"></i></button>
                {{-- <x-button class="ml-4">
                    {{ __('Post') }}
                </x-button> --}}
            </div>
        </form>
    </div>
  </div>
    
@endsection