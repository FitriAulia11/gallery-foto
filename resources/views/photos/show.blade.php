@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row g-4 bg-white shadow-lg rounded p-4">
        
        <div class="col-md-7 d-flex justify-content-center align-items-center bg-light rounded">
        <img src="{{ asset('storage/' . $photo->image_path) }}" class="rounded img-fluid w-75 shadow">
        </div>

        <div class="col-md-5">
            <!-- Tombol Like di bagian atas -->
            <div class="d-flex justify-content-between align-items-center">
                <form action="{{ route('photos.like', $photo->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="border-0 bg-transparent p-0 d-flex align-items-center">
                        @if ($photo->likes->where('user_id', auth()->id())->count() > 0)
                            <i class="fas fa-heart text-danger fs-4"></i>
                        @else
                            <i class="far fa-heart text-dark fs-4"></i>
                        @endif
                        <span class="ms-2 text-dark fs-5">{{ $photo->likes->count() }}</span>
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
            <div class="overflow-auto border-top pt-3" style="max-height: 200px;">
                @foreach ($photo->comments as $comment)
                    <div class="bg-light p-2 rounded mb-2">
                        <p class="mb-0">{{ $comment->content }}</p>
                    </div>
                @endforeach
            </div>

            <!-- Form Komentar -->
            <form action="{{ route('comments.store', $photo->id) }}" method="POST" class="mt-3">
                @csrf
                <input type="text" name="content" class="form-control mb-2" placeholder="Tambahkan komentar...">
                <button type="submit" class="btn btn-danger w-100">Kirim</button>
            </form>
        </div>
    </div>
</div>

<script src="https://kit.fontawesome.com/your-kit-code.js" crossorigin="anonymous"></script>
@endsection
