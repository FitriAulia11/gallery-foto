@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Admin Dashboard</h2>

    {{-- Kelola Pengguna --}}
    <h4>Kelola Pengguna</h4>
    <table class="table">
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Aksi</th>
        </tr>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                @can('delete-user', $user)
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                </form>
                @endcan
            </td>
        </tr>
        @endforeach
    </table>

    {{-- Kelola Foto --}}
    <h4>Kelola Foto</h4>
    <table class="table">
        <tr>
            <th>Foto</th>
            <th>Caption</th>
            <th>Diunggah Oleh</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        @foreach($photos as $photo)
        <tr>
            <td><img src="{{ asset('storage/' . $photo->image_path) }}" width="100"></td>
            <td>{{ $photo->caption }}</td>
            <td>{{ $photo->user->name }}</td>
            <td>{{ $photo->status ? 'Aktif' : 'Nonaktif' }}</td>
            <td>
                {{-- Admin bisa aktifkan/nonaktifkan foto --}}
                <form action="{{ route('photos.toggle', $photo->id) }}" method="POST" style="display:inline;">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-sm {{ $photo->status ? 'btn-danger' : 'btn-success' }}">
                        {{ $photo->status ? 'Nonaktifkan' : 'Aktifkan' }}
                    </button>
                </form>

                {{-- Admin bisa hapus foto --}}
                <form action="{{ route('photos.destroy', $photo->id) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                </form>

                {{-- Lihat detail foto & komentar --}}
                <a href="{{ route('photos.show', $photo->id) }}" class="btn btn-sm btn-primary">Lihat</a>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
