<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Galeri Foto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            background: #007bff;
            color: white;
            padding: 15px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px;
            display: block;
        }
        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
        }
        .content {
            margin-left: 260px;
            padding: 20px;
        }
        .card {
            border: none;
            border-radius: 10px;
        }
        .card i {
            font-size: 2rem;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h3 class="text-center">📸 Galeri Foto</h3>
    <p class="text-center">Admin Panel</p>
    <ul class="nav flex-column">
        <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a></li>
        <li class="nav-item"><a href="#" class="nav-link">Foto</a></li>
        <li class="nav-item"><a href="#" class="nav-link">Album</a></li>
        <li class="nav-item"><a href="#" class="nav-link">Komentar</a></li>
        <li class="nav-item"><a href="#" class="nav-link">Like</a></li>
        <li class="nav-item"><a href="#" class="nav-link">Pengguna</a></li>
    </ul>
</div>

<div class="content">
    @yield('content')
</div>

</body>
</html>
