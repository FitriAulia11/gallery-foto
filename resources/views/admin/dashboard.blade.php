@extends('layouts.admin') {{-- Menggunakan layout admin dengan sidebar --}}

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Dashboard Admin</h2>

    <!-- Kotak Statistik -->
    <div class="row">
        <!-- Jumlah Foto -->
        <div class="col-md-4">
        <div class="card text-dark mb-3 shadow" style="background-color: #ffc9de;">
                <div class="card-body text-center">
                    <i class="bi bi-image" style="font-size: 2.5rem;"></i>
                    <h5 class="card-title mt-2">Jumlah Foto</h5>
                    <p class="card-text fs-4">{{ $totalPhotos }}</p>
                </div>
            </div>
        </div>

                <!-- Jumlah Komentar -->
                <div class="col-md-4">
                <div class="card text-dark mb-3 shadow" style="background-color: #d3f9d8;">
                <div class="card-body text-center">
                    <i class="bi bi-chat-dots" style="font-size: 2.5rem;"></i>
                    <h5 class="card-title mt-2">Jumlah Komentar</h5>
                    <p class="card-text fs-4">{{ $totalComments }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
    <!-- Card Jumlah Like -->
    <div class="card text-dark mb-3 shadow" style="background-color: #ffccf7;">
        <div class="card-body text-center">
            <i class="bi bi-heart" style="font-size: 2.5rem;"></i>
            <h5 class="card-title mt-2">Jumlah Like</h5>
            <p class="card-text fs-4">{{ $totalLikes }}</p>
        </div>
    </div>
</div>
        <!-- Jumlah Pengguna -->
        <div class="col-md-4">
        <div class="card text-dark mb-3 shadow" style="background-color: #e5ccff;">
                <div class="card-body text-center">
                    <i class="bi bi-people" style="font-size: 2.5rem;"></i>
                    <h5 class="card-title mt-2">Jumlah Pengguna</h5>
                    <p class="card-text fs-4">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>
        </div>


    <!-- Nama Pengguna -->
    <div class="text-center mt-4">
        <p class="text-muted">Login sebagai: <strong>{{ Auth::user()->name }}</strong></p>
    </div>
</div>
@endsection
