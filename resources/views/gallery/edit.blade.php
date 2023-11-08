@extends('auth.layouts')

@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Gallery</div>
            <div class="card-body">
                <div class="row">
                    <form action="{{ route('gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="mb-3 row">
                            <label for="title" class="col-md-4 col-form-label text-md-end text-start">Title</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="title" name="title" value="{{$gallery->title}}">
                                @error('title')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="description" class="col-md-4 col-form-label text-md-end text-start">Description</label>
                            <div class="col-md-6">
                                <textarea class="form-control" id="description" rows="5" name="description">{{$gallery->description}}</textarea>
                                @error('description')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <img class="example-image img-fluid mb-2" src="{{asset('storage/posts_image/'.$gallery->picture )}}" alt="{{$gallery->title}}" />
                            <label for="input-file" class="col-md-4 col-form-label text-md-end text-start">File input</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="input-file" name="picture">
                                        <label class="custom-file-label" for="input-file">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection