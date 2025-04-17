<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: rgb(0, 0, 0);
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
        }

        .sidebar a {
            color: #ffffff;
            padding: 10px 20px;
            display: block;
            text-decoration: none;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color:rgb(25, 116, 207);
            border-radius: 8px;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .card-body i {
            font-size: 2.5rem;
        }

        .card h2 {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-white text-center mb-4">Admin Panel</h4>
        <a href="{{ route('admin.dashboard') }}" ><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
        <a href="{{ route('gallery.index') }}"><i class="bi bi-image-fill me-2"></i> Galeri Foto</a>
        <a href="{{ route('admin.likes') }}"><i class="bi bi-hand-thumbs-up-fill me-2"></i>Like</a>
        <a href="{{ route('admin.comments') }}"><i class="bi bi-chat-dots-fill me-2"></i>Komentar</a>
        <a href="{{ route('admin.photos') }}"><i class="bi bi-image-fill me-2"></i>Foto</a>
        <a href="{{ route('admin.pengguna.index') }}"><i class="bi bi-people-fill me-2"></i>Pengguna</a>
        <a href="{{ route('logout') }}"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
