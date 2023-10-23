@extends('auth.layouts')

@section('content')

@foreach ($userss as $user)
<p>This is user {{ $user->name }} with email {{ $user->email }}</p>
@endforeach

@endsection