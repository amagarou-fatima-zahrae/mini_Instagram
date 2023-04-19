@component('mail::message')
# Welcome to Instagram the user : {{$user->name}}

This is a platform for everyone orounf the world to know each other ,share information and experience.

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks for joining us<br>

{{-- {{ config('app.name') }} --}}
@endcomponent
