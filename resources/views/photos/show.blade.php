@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row g-4 bg-white shadow-lg rounded p-4">
        
        <!-- Gambar Foto -->
        <div class="col-md-7 d-flex justify-content-center align-items-center bg-light rounded">
            <img src="{{ asset('storage/' . $photo->image_path) }}" class="rounded img-fluid w-75 shadow">
        </div>

        <!-- Info & Komentar -->
        <div class="col-md-5">
            <!-- Tombol Like -->
            <div class="d-flex justify-content-between align-items-center mb-2">
                <form action="{{ route('photos.like', $photo->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="border-0 bg-transparent p-0 d-flex align-items-center">
                        @if ($photo->likes->where('user_id', auth()->id())->count() > 0)
                            <i class="fas fa-heart text-danger fs-4"></i>
                            <span class="ms-2 text-danger fs-5">Unlike</span>
                        @else
                            <i class="far fa-heart text-dark fs-4"></i>
                            <span class="ms-2 text-dark fs-5">Like</span>
                        @endif
                        <span class="ms-2 text-muted fs-5">({{ $photo->likes->count() }})</span>
                    </button>
                </form>
            </div>

            <!-- Nama Pengguna -->
            <div class="d-flex align-items-center mt-3">
                <span class="fw-semibold fs-5">{{ $photo->user->name ?? 'Pengguna' }}</span>
            </div>

            <!-- Jumlah Komentar -->
            <div class="d-flex align-items-center my-3">
                <i class="fas fa-comment text-secondary fs-5"></i>
                <span class="ms-2 fs-5">{{ $photo->comments->count() }} Komentar</span>
            </div>

            <!-- Daftar Komentar -->
            <div class="overflow-auto border-top pt-3 mb-3" style="max-height: 200px;">
                @foreach ($photo->comments as $comment)
                    <div class="position-relative border rounded p-2 mb-2 bg-light">
                        <div class="fw-semibold">{{ $comment->user->name }}</div>
                        <div>{{ $comment->body ?? $comment->content }}</div>
                        <div class="text-muted small mt-1">{{ $comment->created_at->diffForHumans() }}</div>

                        @if (auth()->id() === $comment->user_id)
                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST"
                                class="position-absolute top-0 end-0 mt-2 me-2"
                                onsubmit="return confirm('Yakin ingin hapus komentar ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-link text-danger p-0" title="Hapus">
                                    <i class="fas fa-trash-alt"></i> {{-- ICON HAPUS --}}
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Notifikasi Sukses -->
            @if (session('success'))
                <div class="alert alert-success mt-2">{{ session('success') }}</div>
            @endif

            <!-- Form Tambah Komentar -->
            <form action="{{ route('comments.store', $photo->id) }}" method="POST" class="mt-2">
                @csrf
                <input type="text" name="content" class="form-control mb-2" placeholder="Tambahkan komentar..." required>
                <button type="submit" class="btn btn-danger w-100">Kirim</button>
            </form>
        </div>
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection
