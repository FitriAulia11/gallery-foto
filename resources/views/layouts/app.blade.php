<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Galeri Foto')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar-brand {
            font-weight: bold;
            transition: 0.3s ease-in-out;
        }
        .navbar-brand:hover {
            color: #0d6efd;
        }
        .container {
            max-width: 1200px;
        }
        .card-img-top {
            height: 300px;
            object-fit: cover;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }
        .card {
            border-radius: 12px;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: scale(1.02);
        }
    </style>
</head>
<body>

<!-- Navbar hanya muncul jika halaman bukan upload foto -->
@if (!request()->routeIs('photos.create'))
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
    <div class="container">
        {{-- Logo / Brand --}}
        <a class="navbar-brand fw-bold text-primary" href="{{ route('dashboard') }}">Gallery</a>

      

<ul class="navbar-nav ms-3">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle fw-bold" href="#" id="kategoriDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Kategori
        </a>
        <ul class="dropdown-menu" aria-labelledby="kategoriDropdown">
            @foreach($categories as $category)
                <li><a class="dropdown-item" href="{{ route('photos.index', ['category' => $category->id]) }}">{{ $category->name }}</a></li>
            @endforeach
        </ul>
    </li>
</ul>



        {{-- Spacer biar dropdown user ke kanan --}}
        <div class="ms-auto">
            @auth
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fw-bold" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                        👤 {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profile.show', Auth::user()->id) }}"><i class="bi bi-person-circle"></i> Profil</a></li>
                        <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="bi bi-grid"></i> Dashboard</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right"></i> Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
            @endauth
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<div style="margin-top: 80px;"></div>
@endif

<main class="py-4">
    <div class="container">
        @yield('content')
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
