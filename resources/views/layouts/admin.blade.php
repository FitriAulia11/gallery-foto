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
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .sidebar {
        width: 250px;
        height: 100vh;
        background: linear-gradient(135deg, #9fd3c7, #58a4b0);
        position: fixed;
        top: 0;
        left: 0;
        padding: 20px 15px;
        box-shadow: 2px 0 6px rgba(0, 0, 0, 0.1);
    }

    .sidebar h4 {
        color: #ffffff;
        text-align: center;
        margin-bottom: 30px;
        font-weight: 600;
        letter-spacing: 1px;
    }

    .sidebar a {
        color: #ffffff;
        padding: 12px 20px;
        display: flex;
        align-items: center;
        text-decoration: none;
        border-radius: 10px;
        transition: all 0.2s ease;
        margin-bottom: 10px;
        font-size: 15px;
    }

    .sidebar a i {
        font-size: 18px;
        margin-right: 12px;
        opacity: 0.9;
    }

    .sidebar a:hover,
    .sidebar a.active {
        background-color: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(2px);
        transform: translateX(5px);
    }

    .main-content {
        margin-left: 250px;
        padding: 20px;
    }
</style>
</head>
<body>
    <!-- Sidebar -->
<!-- Sidebar -->
<div class="sidebar">
<h4><i class="bi bi-person-circle me-2"></i>Admin Panel</h4>
    <a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="{{ route('gallery.index') }}"><i class="bi bi-image-fill"></i> Galeri Foto</a>
    <a href="{{ route('admin.likes') }}"><i class="bi bi-hand-thumbs-up-fill"></i> Like</a>
    <a href="{{ route('admin.comments') }}"><i class="bi bi-chat-dots-fill"></i> Komentar</a>
    <a href="{{ route('admin.photos') }}"><i class="bi bi-camera-fill"></i> Foto</a>
    <a href="{{ route('admin.pengguna.index') }}"><i class="bi bi-people-fill"></i> Pengguna</a>
    <a href="{{ route('logout') }}"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

    <!-- Main Content -->
    <div class="main-content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
