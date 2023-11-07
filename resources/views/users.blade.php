@extends('auth.layouts')

@section('content')

<table>
    <tr>
        <td>Name</td>
        <td>Email</td>
        <td>Photo</td>
        <td>Action</td>
    </tr>
    @foreach ($userss as $user)
    <tr>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <!-- <td><img src="{{asset('storage/'.$user->photo )}}"></td> -->
        <td><img src="{{asset('storage/'.$user->photo )}}" width="150px"></td>
        <td><button>Edit</button><button>Delete</button></td>
    </tr>
    @endforeach
</table>

@endsection