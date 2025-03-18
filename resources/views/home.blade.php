@extends('layouts.app')

@section('content')
<div class="container text-center py-5">

<div class="py-5">
        <h1 class="fw-bold text-dark mb-3">📸 Galeri Foto</h1>
        <p class="lead text-muted">
            Unggah dan jelajahi foto-foto luar biasa dari komunitas kami. 
            Bagikan momen terbaikmu dengan dunia! 🌎✨
        </p>
    </div>

    <div class="row justify-content-center g-3">
        <div class="col-md-4">
            <div class="gallery-item">
                <img src="{{ asset('img/gambar2(1).jpeg') }}" 
                     alt="Galeri 1" 
                     class="img-fluid rounded shadow gallery-img">
            </div>
        </div>
        <div class="col-md-4">
            <div class="gallery-item">
                <img src="{{ asset('img/gambar2(2).jpeg') }}" 
                     alt="Galeri 2" 
                     class="img-fluid rounded shadow gallery-img">
            </div>
        </div>
        <div class="col-md-4">
            <div class="gallery-item">
                <img src="{{ asset('img/gambar2(3).jpeg') }}" 
                     alt="Galeri 3" 
                     class="img-fluid rounded shadow gallery-img">
            </div>
        </div>
    </div>

    <!-- Cek Role -->
    <div class="mt-5">
        @guest
            <a href="{{ route('login') }}" class="btn btn-lg btn-primary px-5 py-3 shadow rounded-pill fw-bold">
                <i class="bi bi-box-arrow-in-right"></i> Masuk Sekarang
            </a>
        @else
            <div class="d-flex justify-content-center gap-4">
                @if(Auth::user()->role == 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-lg btn-success px-5 py-3 shadow rounded-pill fw-bold">
                        <i class="bi bi-speedometer2"></i> Dashboard Admin
                    </a>
                @else
                    <a href="{{ route('user.dashboard') }}" class="btn btn-lg btn-info px-5 py-3 shadow rounded-pill fw-bold text-white">
                        <i class="bi bi-person-circle"></i> Masuk sebagai User
                    </a>
                @endif
            </div>
        @endguest
    </div>
</div>

<style>
    .gallery-item {
        overflow: hidden;
        border-radius: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .gallery-img {
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        width: 100%;
        height: auto;
    }

    .gallery-img:hover {
        transform: scale(1.1);
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2);
    }
</style>
@endsection
