@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
  <div class="card mb-4 shadow-sm rounded">
    <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
      <h5 class="mb-0">Daftar Pengguna</h5>
      <a href="{{ route('admin.pengguna.create') }}" class="btn btn-light btn-sm">
        <i class="bi bi-plus-circle me-1"></i> Tambah Pengguna
      </a>
    </div>
    <div class="card-body">
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
      <div class="table-responsive">
        <table class="table table-striped table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th style="width: 5%;">#</th>
              <th style="width: 35%;">Nama</th>
              <th style="width: 30%;">Email</th>
              <th style="width: 15%;">Peran</th>
              <th style="width: 15%;" class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($users as $user)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ Str::limit($user->name, 30) }}</td>
              <td>{{ $user->email }}</td>
              <td>
                <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : 'secondary' }}">
                  {{ ucfirst($user->role) }}
                </span>
              </td>
              <td class="text-center">
                <div class="d-flex justify-content-center gap-1">
                  <a href="{{ route('admin.pengguna.edit', $user->id) }}" 
                     class="btn btn-outline-warning btn-sm p-1"
                     title="Edit">
                    <i class="bi bi-pencil-square fs-6"></i>
                  </a>
                  <form action="{{ route('admin.pengguna.destroy', $user->id) }}" 
                        method="POST" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')" 
                        class="m-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="btn btn-outline-danger btn-sm p-1"
                            title="Hapus">
                      <i class="bi bi-trash fs-6"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="text-center py-3">Belum ada pengguna.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
