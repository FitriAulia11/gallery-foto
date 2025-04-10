@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4 fw-bold">Dashboard Admin</h2>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary shadow">
                <div class="card-body text-center">
                    <i class="bi bi-image-fill"></i>
                    <h4 class="mt-2">Total Foto</h4>
                    <h2>{{ $totalPhotos }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-success shadow">
                <div class="card-body text-center">
                    <i class="bi bi-folder-fill"></i>
                    <h4 class="mt-2">Total Album</h4>
                    <h2>{{ $totalAlbums }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-warning shadow">
                <div class="card-body text-center">
                    <i class="bi bi-chat-dots-fill"></i>
                    <h4 class="mt-2">Total Komentar</h4>
                    <h2>{{ $totalComments }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-danger shadow">
                <div class="card-body text-center">
                    <i class="bi bi-hand-thumbs-up-fill"></i>
                    <h4 class="mt-2">Total Like</h4>
                    <h2>{{ $totalLikes }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-dark shadow">
                <div class="card-body text-center">
                    <i class="bi bi-people-fill"></i>
                    <h4 class="mt-2">Total Pengguna</h4>
                    <h2>{{ $totalUsers }}</h2>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
