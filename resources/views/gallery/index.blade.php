@extends('auth.layouts')

@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Gallery</div>
            <div class="card-body">
                <div class="row">
                    <div style="padding-bottom: 10px;">
                        <a href="{{route('gallery.create')}}" class="btn btn-dark">New Gallery</a>
                    </div>
                    @if(count($galleries)>0)
                    @foreach ($galleries as $gallery)
                    <div class="col-sm-3">
                        <div class="text-center" style="padding-bottom: 5px; border: 2px;">
                            <img class="example-image img-fluid mb-2" src="{{asset('storage/posts_image/'.$gallery->picture )}}" alt="{{$gallery->title}}" />
                            <a href="{{route('gallery.edit', $gallery->id)}}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('gallery.destroy', $gallery->id) }}" method="POST">
                                @method('DELETE')
                                {{ csrf_field() }}<br />
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <h3>Tidak ada data.</h3>
                    @endif
                    <div class="d-flex">
                        {{ $galleries->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection