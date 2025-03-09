@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Upload Photo</h2>
    <form action="{{ route('photos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" name="title" placeholder="Title" required>
        <textarea name="description" placeholder="Description"></textarea>
        <input type="file" name="image" required>
        <button type="submit">Upload</button>
    </form>
</div>
@endsection
