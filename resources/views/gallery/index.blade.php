@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f8f9fa;
    }

    .sidebar {
        width: 250px;
        height: 100vh;
        background-color: #000;
        position: fixed;
        top: 0;
        left: 0;
        padding-top: 20px;
    }

    .sidebar a {
        color: #fff;
        padding: 10px 20px;
        display: block;
        text-decoration: none;
    }

    .sidebar a:hover,
    .sidebar a.active {
        background-color:rgb(9, 104, 199);
        border-radius: 8px;
    }

    .main-content {
        margin-left: 250px;
        padding: 30px 20px;
    }

    .card-img-top {
        height: 200px;
        object-fit: cover;
        cursor: pointer;
    }

    .btn-like {
        padding: 4px 12px;
    }

    .btn-comment {
        margin-left: 5px;
    }

    .btn-action {
        margin-left: 5px;
        margin-top: 5px;
    }
</style>

<!-- Sidebar -->
<div class="sidebar">
    <h4 class="text-white text-center mb-4">Admin Panel</h4>
    <a href="{{ route('admin.dashboard') }}" class="active"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
    <a href="{{ route('gallery.index') }}"><i class="bi bi-image-fill me-2"></i> Galeri Foto</a>
    <a href="#"><i class="bi bi-image-fill me-2"></i>Foto</a>
    <a href="#"><i class="bi bi-hand-thumbs-up-fill me-2"></i>Like</a>
    <a href="#"><i class="bi bi-chat-dots-fill me-2"></i>Komentar</a>
    <a href="{{ route('users.index') }}"><i class="bi bi-people-fill me-2"></i>Pengguna</a>
    <a href="{{ route('logout') }}"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
</div>

<!-- Main Content -->
<div class="main-content container">
    <!-- Header -->
    <div class="text-center mb-5 py-3" style="background: linear-gradient(to right, #6a11cb, #2575fc); border-radius: 10px;">
    <h2 class="fw-bold text-white display-4 mb-3">📸 Galeri Foto</h2>
    <p class="text-white-50 fs-4">Semua foto yang diunggah oleh pengguna. Jelajahi dan temukan gambar menarik!</p>
</div>


    <!-- Tombol Tambah -->
    <div class="text-center mb-4">
        <a href="{{ route('photos.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
            <i class="bi bi-plus-circle me-2"></i> Tambah Foto
        </a>
    </div>

    <!-- Galeri Foto -->
    @if($photos->isEmpty())
        <div class="alert alert-warning text-center rounded-3">
            Belum ada foto yang diunggah.
        </div>
    @else
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        @foreach($photos as $photo)
        <div class="col">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <img 
                    src="{{ asset('storage/' . $photo->image_path) }}" 
                    alt="Foto"
                    class="card-img-top rounded-top-4"
                />
                <div class="card-body text-center">
                    <h6 class="fw-semibold mb-0" title="Diunggah: {{ $photo->created_at->format('d M Y, H:i') }}">
                        {{ $photo->caption ?? 'Tanpa Judul' }}
                    </h6>
                </div>

                <div class="card-footer bg-white border-top text-center">
                    <!-- Like -->
                    <form action="{{ route('photos.like', $photo->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm btn-like">
                            <i class="bi {{ $photo->likes->contains('user_id', auth()->id()) ? 'bi-heart-fill text-danger' : 'bi-heart' }}"></i>
                            <span>{{ $photo->likes->count() }}</span>
                        </button>
                    </form>

                    <!-- Komentar -->
                    <a href="{{ route('photos.show', $photo->id) }}" class="btn btn-outline-secondary btn-sm btn-comment">
                        <i class="bi bi-chat-dots"></i> {{ $photo->comments->count() }}
                    </a>

                    <!-- Aksi Admin -->
                    @if(Auth::user()->role == 'admin')
                    <a href="{{ route('photos.edit', $photo->id) }}" class="btn btn-warning btn-sm btn-action">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('photos.destroy', $photo->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus foto ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm btn-action">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
