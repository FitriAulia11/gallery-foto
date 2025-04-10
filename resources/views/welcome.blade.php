<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Foto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .gallery-img {
            transition: transform 0.3s ease-in-out;
            height: 200px;
            object-fit: cover;
        }

        .gallery-img:hover {
            transform: scale(1.05);
        }

        .hero-section {
            height: 70vh;
            background: linear-gradient(to right, rgba(52, 152, 219, 0.6), rgba(255, 105, 180, 0.6)),
                        url('https://source.unsplash.com/1600x900/?photography,art') no-repeat center center;
            background-size: cover;
            background-blend-mode: overlay;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .hero-section h1 {
            font-size: 3rem;
            font-weight: bold;
        }

        .hero-section p {
            font-size: 1.2rem;
        }

        body {
            padding-top: 70px;
        }
    </style>
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="#">Galeri</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="#images">Galeri</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">Tentang</a></li>
            </ul>
            <div>
                <a href="{{ route('login') }}" class="btn btn-primary me-2">Login</a>
                <a href="{{ route('register') }}" class="btn btn-outline-secondary">Register</a>
            </div>
        </div>
    </div>
</nav>

<!-- Hero -->
<section class="hero-section">
    <div class="container">
        <h1>Selamat Datang di Galeri</h1>
        <p class="mb-4">Jelajahi koleksi foto terbaik dan abadikan momen berharga Anda.</p>
        <a href="{{ route('login') }}" class="btn btn-light text-primary fw-semibold px-4 py-2 shadow">Mulai Jelajahi</a>
    </div>
</section>

<!-- Gallery -->
<section id="images" class="py-5 bg-white">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">Galeri Foto</h2>
        <div class="row g-4">
            @isset($photos)
                @forelse ($photos as $photo)
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card h-100 shadow-sm border-0">
                            <img src="{{ asset('storage/' . $photo->image_path) }}" alt="{{ $photo->caption }}" class="card-img-top gallery-img">
                            <div class="card-body">
                                <h6 class="card-title fw-semibold">{{ $photo->caption ?? 'Tanpa Judul' }}</h6>
                                <p class="card-text text-muted">{{ Str::limit($photo->description, 60) }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="text-muted">Tidak ada foto yang tersedia.</p>
                    </div>
                @endforelse
            @endisset
        </div>
    </div>
</section>

<!-- About -->
<section id="about" class="py-5 bg-light">
    <div class="container text-center">
        <h2 class="fw-bold mb-3">Tentang Galeri</h2>
        <p class="text-muted mx-auto" style="max-width: 600px;">
            Galeri ini menyediakan koleksi foto berkualitas tinggi dari berbagai kategori untuk kebutuhan dokumentasi, inspirasi, dan kenangan.
        </p>
    </div>
</section>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-4">
    <p class="mb-0">&copy; 2025 Galeri Foto. All rights reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
