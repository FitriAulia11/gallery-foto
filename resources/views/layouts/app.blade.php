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
        .search-box {
            width: 100%;
            max-width: 400px;
        }
        .container {
            max-width: 1200px;
        }
        main {
            padding-bottom: 50px;
        }
    </style>
</head>
<body>

@if (!request()->routeIs('login') && !request()->routeIs('register'))
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
    <div class="container">
        <!-- Logo / Dashboard (di kiri) -->
        <a class="navbar-brand fw-bold text-primary me-auto" href="{{ route('dashboard') }}">Gallery</a>

        @auth
        <!-- Nama Akun User di Sebelah Kanan -->
        <ul class="navbar-nav ms-auto"> <!-- Tambahkan ms-auto di sini -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle fw-bold" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                    👤 {{ Auth::user()->name }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end"> <!-- Tambahkan dropdown-menu-end -->
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.show', Auth::user()->id) }}">
                            <i class="bi bi-person-circle"></i> Profil
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('dashboard') }}">
                            <i class="bi bi-grid"></i> Dashboard
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
        @endauth
    </div>
</nav>
        @
        <!-- Toggle Menu -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Sign Up</a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<!-- Tambahkan padding supaya kontennya tidak tertutup navbar -->
<div style="margin-top: 80px;"></div>
@endif

<!-- Main Content -->
<main class="py-4">
    <div class="container">
        @yield('content')
    </div>
</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')

</body>
</html>
