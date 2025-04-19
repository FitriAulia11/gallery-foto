@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f8f9fa;
    }

    .main-content {
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

<!-- Main Content -->
<div class="main-content container">
    <!-- Header -->
    <div class="text-center mb-4 py-4 px-3 shadow-sm"
         style="background: linear-gradient(135deg, #fcd5ce, #cdb4db); border-radius: 16px;">
        <h3 class="fw-bold text-white mb-2" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.2);">
            🎀📸 Galeri Foto 🦋
        </h3>
        <p class="text-white small mb-0" style="max-width: 600px; margin: auto; text-shadow: 1px 1px 1px rgba(0,0,0,0.1);">
            Temukan momen manis dan indah dari pengguna lain. Yuk upload juga dan hiasi galeri dengan karyamu 🎨💖
        </p>
    </div>
</div>

    <!-- Tombol Tambah -->
    <div class="d-flex justify-content-center mb-5">
    <a href="{{ route('photos.create') }}" class="text-decoration-none">
        <div class="card shadow-sm border-0"
             style="width: 250px; background: linear-gradient(135deg, #ffd6e0, #d0e6ff); border-radius: 16px; transition: transform 0.3s ease;">
            <div class="card-body text-center py-3 px-3">
                <i class="bi bi-plus-circle-fill" style="font-size: 1.8rem; color: #6a11cb;"></i>
                <h6 class="mt-2 fw-semibold text-dark mb-1">Tambah Foto Baru</h6>
                <p class="text-muted mb-0 small">Upload momen terbaikmu!</p>
            </div>
        </div>
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
        style="height: 350px; object-fit: cover;"
    />

                <div class="card-body text-center">
                    <h6 class="fw-semibold mb-0" title="Diunggah: {{ $photo->created_at->format('d M Y, H:i') }}">
                        {{ $photo->caption ?? 'Gallery' }}
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
