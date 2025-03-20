<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery Foto</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        html {
            scroll-behavior: smooth;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn {
            animation: fadeIn 1s ease-out;
        }
    </style>
</head>
<body class="bg-gray-100">

    <!-- Navbar -->

    <!-- Navbar -->
    <nav class="flex justify-between items-center px-6 py-4 bg-white shadow-md fixed top-0 left-0 w-full z-10">
        <div class="text-3xl font-bold text-blue-600">Gallery</div>
        <div class="hidden md:flex space-x-6">
            <a href="#images" class="text-gray-600 hover:text-blue-500 transition">Images</a>
            <a href="#about" class="text-gray-600 hover:text-blue-500 transition">About</a>
        </div>
        <div class="space-x-2">
            <a href="{{ route('login') }}" class="bg-blue-500 text-white px-6 py-2 rounded-lg shadow-md hover:bg-blue-600 transition">Log in</a>
            <a href="{{ route('register') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg shadow-md hover:bg-gray-300 transition">Sign up</a>
        </div>
    </nav>
    

    <!-- Hero Section -->
    <section class="relative flex items-center justify-center text-center px-8 py-32 bg-cover bg-center" 
        style="background-image: url('https://source.unsplash.com/1600x900/?photography,art');">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-pink-500 opacity-50"></div>
        <div class="relative z-10 bg-white bg-opacity-10 backdrop-blur-md px-10 py-14 rounded-lg shadow-xl">
            <h1 class="text-5xl font-bold text-white leading-snug drop-shadow-lg">Selamat Datang di Galeri</h1>
            <p class="mt-3 text-lg text-white max-w-2xl mx-auto">Jelajahi koleksi foto terbaik dan abadikan momen berharga Anda.</p>
            <div class="mt-6">
                <a href="{{ route('login') }}" class="bg-blue-600 text-white px-8 py-3 rounded-full shadow-lg text-base font-semibold hover:bg-blue-700 transition duration-300">Mulai Jelajahi</a>
            </div>
        </div>
        </section>

    <!-- Gallery Section -->
    <section id="images" class="bg-white px-10 py-20">
        <h2 class="text-4xl font-bold text-gray-800 text-center mb-8">Galeri Foto</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @php
                $randomPhotos = ['gambar2(1).jpeg', 'gambar2(2).jpeg', 'gambar2(3).jpeg', 'gambar2(4).jpeg', 'gambar6.jpeg', 'gambar8.jpeg', 'gambar7.jpeg', 'gambar5.jpeg'];
                shuffle($randomPhotos);
            @endphp
            @foreach ($randomPhotos as $photo)
                <div class="relative rounded-lg overflow-hidden shadow-lg group">
                    <img src="{{ asset('img/' . $photo) }}" class="w-full h-64 object-cover transition-transform transform group-hover:scale-110 duration-300">
                    <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <p class="text-white text-lg font-semibold">Lihat Detail</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="bg-gray-100 px-10 py-20 flex flex-col items-center">
        <h2 class="text-4xl font-bold text-gray-800 text-center mb-4">Tentang Galeri</h2>
        <p class="text-gray-600 text-lg text-left max-w-2xl text-center">Galeri ini menyediakan koleksi foto berkualitas tinggi dari berbagai kategori.</p>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white text-center py-6">
        <p>&copy; 2025 Gallery Foto. All rights reserved.</p>
    </footer>

</body>
</html>
