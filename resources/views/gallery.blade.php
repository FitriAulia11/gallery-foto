@extends('layouts.app')

@section('content')
<div class="container mt-5">

<div class="text-center mb-4">
        <h2 class="fw-bold text-primary">Galeri Foto</h2>
        <p class="text-muted">Tempat menyimpan kenangan dalam bentuk foto</p>
    </div>


    <div class="text-end mb-3">
        <a href="{{ route('photos.create') }}" class="btn btn-success">Tambah Foto</a>
    </div>


    <div class="row">
        @foreach ($photos as $photo)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <img src="{{ asset('img/' . $photo->src) }}" class="card-img-top" alt="Foto">
                <div class="card-body">
                    <p class="card-text">{{ $photo->description }}</p>
                    <div class="d-flex justify-content-between">

                    <a href="{{ route('photos.edit', $photo->id) }}" class="btn btn-primary btn-sm">Edit</a>


                    <form action="{{ route('photos.destroy', $photo->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus foto ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
