@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="bi bi-cloud-upload"></i> Upload Foto</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('photos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-3">
                    <label for="title" class="form-label fw-bold">Judul Foto</label>
                    <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" placeholder="Masukkan judul foto" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label fw-bold">Deskripsi</label>
                    <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="Tambahkan deskripsi foto"></textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label fw-bold">Pilih Foto</label>
                    <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror" required>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="bi bi-upload"></i> Upload
                </button>
                <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </form>
        </div>
    </div>
</div>
@endsection
