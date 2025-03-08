@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-10 text-center">
    <h2 class="text-3xl font-bold text-gray-800 mb-4">Selamat Datang di Galeri Foto</h2>
    <p class="text-gray-600 mb-6">Silakan login untuk mengelola atau melihat foto.</p>

    @guest
        <a href="{{ route('login') }}" class="bg-blue-500 text-white px-6 py-3 rounded-lg text-lg shadow-md hover:bg-blue-600">
            Login
        </a>
    @else
        @if(Auth::user()->role == 'admin')
            <a href="{{ route('admin.dashboard') }}" class="bg-green-500 text-white px-6 py-3 rounded-lg text-lg shadow-md hover:bg-green-600">
                Masuk ke Halaman Admin
            </a>
        @else
        <a href="{{ route('user.dashboard') }}" class="bg-blue-500 text-blue px-6 py-3 rounded-lg text-lg shadow-md hover:bg-blue-600">
    Masuk ke Halaman User
</a>
        @endif
    @endguest
</div>
@endsection
