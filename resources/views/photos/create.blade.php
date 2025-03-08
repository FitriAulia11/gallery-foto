@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="fw-bold">Tambah Foto</h2>
    <form action="{{ route('photos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Upload Foto</label>
            <input type="file" name="src" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <input type="text" name="description" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
