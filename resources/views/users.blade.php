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
        <td>
            @if($user->photo)
            <img src="{{asset('storage/'.$user->photo )}}" width="100px">
            @else
            <img src="{{asset('noimage.jpg')}}" width="100px">
            @endif
        </td>
        <td><button>Edit</button>
            <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                @method('DELETE')
                {{ csrf_field() }}<br />
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

@endsection