@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto mt-10 bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-center mb-4">Upload Foto Baru</h2>
    
    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded-lg mb-4">{{ session('success') }}</div>
    @endif

    <form action="{{ route('photos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="title" class="block text-gray-700">Judul Foto (Opsional)</label>
            <input type="text" name="title" id="title" class="w-full border-gray-300 rounded-md shadow-sm p-2">
        </div>
        
        <div class="mb-4">
            <label for="photo" class="block text-gray-700">Pilih Foto</label>
            <input type="file" name="photo" id="photo" class="w-full border-gray-300 rounded-md shadow-sm p-2">
        </div>
        
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Upload</button>
    </form>
</div>
@endsection
