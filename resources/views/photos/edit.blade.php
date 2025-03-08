@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="fw-bold">Edit Foto</h2>
    <form action="{{ route('photos.update', $photo->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <input type="text" name="description" value="{{ $photo->description }}" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection
