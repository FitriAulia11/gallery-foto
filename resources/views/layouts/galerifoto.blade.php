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
            margin: 0;
            padding: 0;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: rgb(0, 0, 0);
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
            overflow-y: auto;
        }

        .sidebar a {
            color: #ffffff;
            padding: 10px 20px;
            display: block;
            text-decoration: none;
            font-size: 18px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #495057;
            border-radius: 8px;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            min-height: 100vh;
        }

        .card-body i {
            font-size: 2.5rem;
        }

        .card h2 {
            font-weight: bold;
        }

        /* New style for images to display correctly */
        .card-img-top {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }

        .container img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        /* Adjusting the main content for better spacing */
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-white text-center mb-4">Admin Panel</h4>
        <a href="{{ route('admin.dashboard') }}" class="active"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
        <a href="{{ route('gallery.index') }}"><i class="bi bi-image-fill me-2"></i> Galeri Foto</a>
        <a href="#"><i class="bi bi-people-fill me-2"></i>Pengguna</a>
        <a href="{{ route('logout') }}"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
