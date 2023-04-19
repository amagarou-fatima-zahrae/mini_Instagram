@extends('layouts.app')

@section('content')
    <div class="container p-5">
        <div class="row mx-5">
            {{-- <x-auth-validation-errors class="mb-4" :errors="$errors" /> --}}
            @if ($errors->any())
               @foreach ($errors->all() as $error)
                 <div style="color:red;font-weight:bold"> {{ $error }} </div>
               @endforeach
            @endif
    
            <form method="POST" action="/profile/{{$user->id}}"  class="mx-5" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row">
                    <h1>Edit Profile</h1>
                </div>
                <!-- title -->
                <div class="py-3">
                    <x-label for="title" :value="__('title')" />
                    
                    <input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ old('title') ?? $user->profile->title}}"  autofocus autocomplete="title"/>
                    @if ($errors->has('title'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{$errors->first('title')}} </strong>
                        </span>
                    @endif
                </div>
                <div class="py-3">
                    <x-label for="description" :value="__('description')" />
                
                    <x-input id="description" class="block mt-1 w-full" type="text" name="description" :value="old('description')?? $user->profile->description"   autocomplete="description"/>
                    @if ($errors->has('description'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{$errors->first('description')}} </strong>
                        </span>
                    @endif
                </div>
                <div class="py-3">
                    <x-label for="url" :value="__('url')" />
                
                    <x-input id="url" class="block mt-1 w-full" type="text" name="url" :value="old('url')?? $user->profile->url"  autocomplete="url"/>
                    @if ($errors->has('url'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{$errors->first('url')}} </strong>
                        </span>
                    @endif
                </div>
                <div class="py-3">
                    <x-label for="img" :value="__('Profile Image')" />

                    <x-input id="img" class=" from-control-file block mt-1 w-full" type="file" name="image" :value="old('image')?? $user->profile->image"  autocomplete="image"/>
                    @if ($errors->has('image'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{$errors->first('image')}} </strong>
                        </span>
                    @endif
                </div>
                
                <div class="flex items-center justify-end mt-4">
                    <x-button class="ml-4">
                        {{ __('Update Profile') }}
                    </x-button>
                </div>
            </form>
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