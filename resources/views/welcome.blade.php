<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery Foto & Video</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        html {
            scroll-behavior: smooth; /* Efek scroll halus */
        }
    </style>
</head>
<body class="bg-green-100">

    <!-- Navbar -->
    <nav class="flex justify-between items-center p-5 bg-white shadow-md fixed top-0 left-0 w-full z-10">
        <div class="text-2xl font-bold text-red-600">Gallery</div>
        <div class="hidden md:flex space-x-6">
            <a href="#about" class="text-gray-600 hover:text-black transition">About</a>
            <a href="#images" class="text-gray-600 hover:text-black transition">Images</a>
            <a href="#videos" class="text-gray-600 hover:text-black transition">Videos</a>
        </div>
        <div class="space-x-2">
            <a href="{{ route('login') }}" class="bg-red-500 text-white px-6 py-2 rounded-lg shadow-md hover:bg-red-600 transition">Log in</a>
            <a href="{{ route('register') }}" class="bg-white border px-6 py-2 rounded-lg shadow-md hover:bg-gray-100 transition">Sign up</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="flex flex-col items-center justify-center text-center px-10 py-40">
        <h1 class="text-4xl font-bold text-green-900 leading-tight">Selamat Datang di Galeri</h1>
        <p class="text-gray-600 text-lg mt-3 max-w-2xl">
            Silakan login untuk mengelola atau melihat foto & video.
        </p>
    </div>

    <!-- Images Section -->
    <div id="images" class="bg-white px-10 py-16 mt-10">
        <h2 class="text-3xl font-bold text-gray-800 text-center mb-6">Galeri Foto</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @php
                $randomPhotos = [
                    ['src' => 'gambar2(1).jpeg', 'desc' => 'Sunset at the beach'],
                    ['src' => 'gambar2(2).jpeg', 'desc' => 'Misty mountain vibes'],
                    ['src' => 'gambar2(3).jpeg', 'desc' => 'Aesthetic coffee shop'],
                    ['src' => 'gambar2(4).jpeg', 'desc' => 'Cozy rainy day'],
                    ['src' => 'gambar2(1).jpeg', 'desc' => 'Golden hour street view'],
                    ['src' => 'gambar2(2).jpeg', 'desc' => 'Minimalist home decor']
                ];
                shuffle($randomPhotos);
            @endphp
            
            @foreach ($randomPhotos as $photo)
                <div class="relative rounded-lg overflow-hidden shadow-lg">
                <img src="{{ asset('img/gambar2(1).jpeg') }}" class="w-full h-48 object-cover">
                    <p class="absolute bottom-2 left-2 bg-black bg-opacity-75 text-white px-3 py-1 text-sm rounded-lg">
                        {{ $photo['desc'] }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Videos Section -->
    <div id="videos" class="bg-gray-100 px-10 py-16 mt-10">
        <h2 class="text-3xl font-bold text-gray-800 text-center mb-6">Galeri Video</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $videos = [
                    ['src' => 'video1.mp4', 'desc' => 'Travel Vlog Beach'],
                    ['src' => 'video2.mp4', 'desc' => 'Nature Drone Footage'],
                    ['src' => 'video3.mp4', 'desc' => 'Street Photography Tips'],
                    ['src' => 'video4.mp4', 'desc' => 'Night City Time-lapse'],
                    ['src' => 'video5.mp4', 'desc' => 'Food Plating Art'],
                    ['src' => 'video6.mp4', 'desc' => 'Slow Motion Rain'],
                ];
            @endphp
            
            @foreach ($videos as $video)
                <div class="relative rounded-lg overflow-hidden shadow-lg bg-white p-3">
                    <video class="w-full h-48 object-cover rounded-lg" controls>
                        <source src="{{ asset('videos/' . $video['src']) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <p class="text-gray-800 text-center mt-2 text-sm font-semibold">
                        {{ $video['desc'] }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- About Section -->
    <div id="about" class="bg-white px-10 py-16 mt-10 flex flex-col items-center">
        <h2 class="text-3xl font-bold text-gray-800 text-center mb-4">About</h2>
        <p class="text-gray-600 text-lg text-left max-w-2xl">
            Galeri ini adalah platform yang memungkinkan pengguna untuk melihat, mengelola, dan berbagi koleksi foto & video mereka. 
            Dengan desain yang modern dan responsif, Anda dapat mengaksesnya dari berbagai perangkat dengan mudah.
        </p>
    </div>

</body>
</html>
