<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery Foto & Video</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="flex justify-between items-center px-6 py-4 bg-white shadow-md fixed top-0 left-0 w-full z-10">
        <div class="text-3xl font-bold text-blue-600">Gallery</div>
        <div class="hidden md:flex space-x-6">
            <a href="#about" class="text-gray-600 hover:text-blue-500 transition">About</a>
            <a href="#images" class="text-gray-600 hover:text-blue-500 transition">Images</a>
            <a href="#videos" class="text-gray-600 hover:text-blue-500 transition">Videos</a>
        </div>
        <div class="space-x-2">
            <a href="{{ route('login') }}" class="bg-blue-500 text-white px-6 py-2 rounded-lg shadow-md hover:bg-blue-600 transition">Log in</a>
            <a href="{{ route('register') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg shadow-md hover:bg-gray-300 transition">Sign up</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative flex items-center justify-center text-center px-10 py-40 bg-cover bg-center" style="background-image: url('https://source.unsplash.com/1600x900/?photography,landscape');">
        <div class="bg-black bg-opacity-50 px-10 py-16 rounded-lg">
            <h1 class="text-5xl font-bold text-white leading-tight">Selamat Datang di Galeri</h1>
            <p class="text-gray-300 text-lg mt-4 max-w-2xl">
                Temukan dan bagikan foto serta video favoritmu. Login untuk mulai mengelola koleksimu!
            </p>
            <div class="mt-6">
                <a href="{{ route('login') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-blue-700 transition">Get Started</a>
            </div>
        </div>
    </section>

    <!-- Images Section -->
    <section id="images" class="bg-white px-10 py-20">
        <h2 class="text-4xl font-bold text-gray-800 text-center mb-8">Galeri Foto</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @php
                $randomPhotos = [
                    ['src' => 'gambar1.jpg', 'desc' => 'Sunset at the beach'],
                    ['src' => 'gambar2.jpg', 'desc' => 'Misty mountain vibes'],
                    ['src' => 'gambar3.jpg', 'desc' => 'Aesthetic coffee shop'],
                    ['src' => 'gambar4.jpg', 'desc' => 'Cozy rainy day'],
                    ['src' => 'gambar5.jpg', 'desc' => 'Golden hour street view'],
                    ['src' => 'gambar6.jpg', 'desc' => 'Minimalist home decor']
                ];
                shuffle($randomPhotos);
            @endphp
            
            @foreach ($randomPhotos as $photo)
                <div class="relative rounded-lg overflow-hidden shadow-lg">
                    <img src="{{ asset('img/' . $photo['src']) }}" class="w-full h-64 object-cover">
                    <p class="absolute bottom-2 left-2 bg-black bg-opacity-70 text-white px-3 py-1 text-sm rounded-lg">
                        {{ $photo['desc'] }}
                    </p>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Videos Section -->
    <section id="videos" class="bg-gray-100 px-10 py-20">
        <h2 class="text-4xl font-bold text-gray-800 text-center mb-8">Galeri Video</h2>
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
    </section>

    <!-- About Section -->
    <section id="about" class="bg-white px-10 py-20 flex flex-col items-center">
        <h2 class="text-4xl font-bold text-gray-800 text-center mb-4">About</h2>
        <p class="text-gray-600 text-lg text-left max-w-2xl">
            Galeri ini adalah platform yang memungkinkan pengguna untuk melihat, mengelola, dan berbagi koleksi foto & video mereka. 
            Dengan desain yang modern dan responsif, Anda dapat mengaksesnya dari berbagai perangkat dengan mudah.
        </p>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white text-center py-6">
        <p>&copy; 2025 Gallery Foto & Video. All rights reserved.</p>
    </footer>

</body>
</html>
