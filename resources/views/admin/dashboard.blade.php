@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-10">
    <h2 class="text-2xl font-bold text-gray-800 mb-2">Admin Dashboard</h2>
    <p class="text-gray-600 mb-6">
        Sebagai admin, Anda dapat menambah, mengedit, dan menghapus foto di album.
    </p>

    <h3 class="text-xl font-bold text-green-800 mb-4">Album Foto</h3>

    <div class="mb-4">
        <a href="{{ route('photos.create') }}" class="bg-green-500 text-white px-4 py-2 rounded-lg text-sm shadow-md hover:bg-green-600">
            Tambah Foto
        </a>
    </div>

    @if ($photos->isEmpty())
        <p class="text-gray-500">Tidak ada foto dalam album ini.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($photos as $photo)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="{{ asset('storage/' . $photo->src) }}" class="w-full h-48 object-cover" alt="Foto">
                <div class="p-4">
                    <p class="text-gray-600 text-sm">{{ $photo->desc }}</p>
                    <div class="mt-2 flex space-x-2">
                        <form action="{{ route('photos.destroy', $photo->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg text-sm shadow-md hover:bg-red-600">
                                Hapus
                            </button>
                        </form>
                        <a href="{{ route('photos.edit', $photo->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm shadow-md hover:bg-blue-600">
                            Edit
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
