<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Foto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .gallery-img {
            transition: transform 0.3s ease-in-out;
            height: 200px;
            object-fit: cover;
        }

        .gallery-img:hover {
            transform: scale(1.05);
        }

        .carousel-item {
            height: 70vh;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .carousel-caption {
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 10px;
            padding: 1.5rem;
            text-align: center;
        }

        body {
            padding-top: 70px;
            background-color: #f8f9fa;
        }

        .navbar {
            z-index: 1000;
        }

        .navbar .btn {
            margin-left: 10px;
        }

        section {
            padding: 60px 0;
        }

        .card-body p {
            font-size: 0.9rem;
        }

        footer {
            background-color: #343a40;
            color: white;
        }

        footer p {
            margin: 0;
        }
    </style>
</head>
<body class="bg-light">


<nav class="navbar navbar-expand-lg navbar-light bg-white shadow fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="#">Gallery</a>
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
                <a href="{{ route('register') }}" class="btn btn-outline-secondary">Sign Up</a>
            </div>
        </div>
    </div>
</nav>

<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
    <div class="carousel-inner">
    <div class="carousel-item active" style="background: linear-gradient(135deg, #f78fb3, #74b9ff); height: 70vh;">
            <div class="d-flex justify-content-center align-items-center h-100 text-center text-white">
                <div>
                    <i class="bi bi-camera-fill display-1 mb-3"></i>
                    <h1 class="fw-bold">Selamat Datang di Galeri</h1>
                    <p>Jelajahi koleksi foto terbaik dan abadikan momen berharga Anda.</p>
                    <a href="{{ route('login') }}" class="btn btn-light text-primary fw-semibold px-4 py-2 mt-3 shadow">Mulai Jelajahi</a>
                </div>
            </div>
        </div>

        <div class="carousel-item" style="background: linear-gradient(135deg, #81ecec, #fab1a0); height: 70vh;">
            <div class="d-flex justify-content-center align-items-center h-100 text-center text-white">
                <div>
                    <i class="bi bi-image-alt display-1 mb-3"></i>
                    <h1 class="fw-bold">Temukan Keindahan Alam</h1>
                    <p>Setiap foto punya cerita. Temukan inspirasimu di sini.</p>
                    <a href="{{ route('login') }}" class="btn btn-light text-primary fw-semibold px-4 py-2 mt-3 shadow">Lihat Sekarang</a>
                </div>
            </div>
        </div>

        <div class="carousel-item" style="background: linear-gradient(135deg, #a29bfe, #ffeaa7); height: 70vh;">
            <div class="d-flex justify-content-center align-items-center h-100 text-center text-white">
                <div>
                    <i class="bi bi-cloud-arrow-up-fill display-1 mb-3"></i>
                    <h1 class="fw-bold">Ekspresikan Dirimu</h1>
                    <p>Bagikan momenmu dengan dunia melalui galeri ini.</p>
                    <a href="{{ route('login') }}" class="btn btn-light text-primary fw-semibold px-4 py-2 mt-3 shadow">Upload Sekarang</a>
                </div>
            </div>
        </div>
    </div>
</div>

<section id="images" class="py-5 bg-white">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">Galeri Foto</h2>
        <div class="row g-4">
            @isset($photos)
                @forelse ($photos as $photo)
                    <div class="col-8 col-md-6 col-lg-3">
                        <div class="card h-100 shadow-sm border-0">
                            <img src="{{ asset('storage/' . $photo->image_path) }}" alt="{{ $photo->caption }}" class="card-img-top gallery-img"  style="height: 400px; object-fit: cover;">
                            <div class="card-body">
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

<section id="about" class="py-5 bg-light">
    <div class="container text-center">
        <h2 class="fw-bold mb-3">Tentang Galeri</h2>
        <p class="text-muted mx-auto" style="max-width: 600px;">
            Galeri ini menyediakan koleksi foto berkualitas tinggi dari berbagai kategori untuk kebutuhan dokumentasi, inspirasi, dan kenangan.
        </p>
    </div>
</section>

<footer class="bg-dark text-white text-center py-4">
    <p class="mb-0">&copy; 2025 Galeri Foto. All rights reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
