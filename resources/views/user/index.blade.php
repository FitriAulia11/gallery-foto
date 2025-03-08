@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gallery User</h1>
    <a href="{{ route('photos.create') }}" class="btn btn-primary">Tambah Foto</a>
    <div class="row">
        @foreach($photos as $photo)
            <div class="col-md-4">
                <div class="card">
                    <img src="{{ asset('storage/' . $photo->path) }}" class="card-img-top">
                    <div class="card-body">
                        <h5>{{ $photo->title }}</h5>
                        <p>{{ $photo->description }}</p>
                        <a href="{{ route('photos.like', $photo->id) }}" class="btn btn-success">Like</a>
                        <form action="{{ route('comments.store', $photo->id) }}" method="POST">
                            @csrf
                            <input type="text" name="content" class="form-control" placeholder="Tambah komentar">
                            <button type="submit" class="btn btn-primary mt-2">Kirim</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
