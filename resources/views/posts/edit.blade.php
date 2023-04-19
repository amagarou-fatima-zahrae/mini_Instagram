@extends('layouts.app')

@section('content')
    
  <div class="container my-3 mx-5">
    <div class="row mx-5">
        {{-- <x-auth-validation-errors class="mb-4" :errors="$errors" /> --}}
        {{-- @if ($errors->any())
           @foreach ($errors->all() as $error)
             <div style="color:red;font-weight:bold"> {{ $error }} </div>
           @endforeach
        @endif --}}

        <form method="POST" action="/post/{{$post->id}}"  class="mx-5" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="row">
              <h1>Update Post</h1>
          </div>
            <!-- caption -->
            <div class="py-3">
                <x-label for="caption" :value="__('Post Caption')" />

                <x-input id="caption" class="block mt-1 w-full {{ $errors->has('caption') ? ' is-invalid' : '' }}" type="text" name="caption" value="{{old('caption') ?? $post->caption }}" required autofocus />
                    @if ($errors->has('caption'))
                    <span class="invalid feedback"role="alert">
                        <strong>{{ $errors->first('caption') }}.</strong>
                    </span>
                   @endif
            </div>
            <div>
                <x-label for="img" :value="__('Post Image')" />

                <x-input id="img" class="from-control-file block mt-1 w-full {{ $errors->has('image') ? 'is-invalid' : '' }}" type="file" name="image" value="{{old('image') ?? $post->image}}" required/>
                    @if ($errors->has('image'))
                    <span class="invalid feedback"role="alert">
                        <strong>{{ $errors->first('image') }}.</strong>
                    </span>
                   @endif
            </div>
            

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-4">
                    {{ __('Update Post') }}
                </x-button>
            </div>
        </form>
    </div>
  </div>
    
@endsection