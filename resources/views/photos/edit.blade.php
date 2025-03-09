@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="fw-bold text-primary text-center">Edit Foto</h2>

    <div class="card p-4 mt-3">
        <form action="{{ route('photos.update', $photo->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Ganti Foto (Opsional)</label>
                <input type="file" name="photo" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <input type="text" name="description" class="form-control" value="{{ $photo->description }}">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection
