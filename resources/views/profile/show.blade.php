@extends('layouts.app')

@section('content')
<div class="container py-5">

    <!-- Header Profil -->
    <div class="text-center mb-5">
        <h2 class="fw-bold text-gradient display-5">
            <i class="bi bi-person-circle me-2"></i> Profil Pengguna
        </h2>
        <p class="text-muted fs-5">
            Informasi & galeri milik <strong>{{ $user->name }}</strong> 🖼️✨
        </p>
    </div>

    <!-- Info Pengguna -->
    <div class="row justify-content-center mb-4">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm border-0 rounded-4 text-center p-4 bg-white">
                <div class="mb-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=8ecae6&color=ffffff&rounded=true&size=100" alt="Avatar"
                         class="rounded-circle shadow-sm" width="100" height="100">
                </div>
                <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                <p class="text-muted mb-0">
                    <i class="bi bi-envelope me-1"></i>{{ $user->email }}
                </p>
            </div>
        </div>
    </div>

    <!-- Tombol Tambah Foto -->
    @if(Auth::id() == $user->id)
    <div class="text-center mb-4">
        <a href="{{ route('photos.create') }}" class="btn btn-pink-purple rounded-pill px-4 shadow-sm">
            <i class="bi bi-plus-circle me-2"></i> Tambah Foto
        </a>
    </div>
    @endif

    <!-- Form Pencarian -->
    <div class="row justify-content-center mb-5">
        <div class="col-md-10 col-lg-8">
            <form method="GET" action="{{ route('photos.index') }}">
                <div class="input-group shadow-sm">
                    <input type="text" name="search" class="form-control rounded-start-pill px-4 py-2"
                        placeholder="🔍 Cari foto milik {{ $user->name }}..."
                        value="{{ request('search') }}">
                    <button class="btn btn-pink-purple rounded-end-pill px-4" type="submit">
                        <i class="bi bi-search me-1"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div>


    <!-- Galeri Foto -->
    @if($photos->isEmpty())
        <div class="alert alert-warning text-center rounded-3">
            Belum ada foto yang diunggah.
        </div>
    @else
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        @foreach($photos as $photo)
        <div class="col">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <img 
                    src="{{ asset('storage/' . $photo->image_path) }}" 
                    alt="Foto"
                    class="card-img-top rounded-top-4"
                    style="height: 430px; object-fit: cover; cursor: pointer;"
                    onclick="showImageModal('{{ asset('storage/' . $photo->image_path) }}')"
                />
                <div class="card-body text-center">
                    <h6 class="fw-semibold mb-0" title="Diunggah: {{ $photo->created_at->format('d M Y, H:i') }}">
                        {{ $photo->caption ?? 'Gallery' }}
                    </h6>
                </div>

                <div class="card-footer bg-white border-top text-center">
                    <form action="{{ route('photos.like', $photo->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="bi {{ $photo->likes->contains('user_id', auth()->id()) ? 'bi-heart-fill text-danger' : 'bi-heart' }}"></i>
                            <span>{{ $photo->likes->count() }}</span>
                        </button>
                    </form>

                    <a href="{{ route('photos.show', $photo->id) }}" class="btn btn-outline-secondary btn-sm mt-2 ms-2">
                        <i class="bi bi-chat-dots"></i> {{ $photo->comments->count() }}
                    </a>

                    @if(Auth::id() == $photo->user_id || Auth::user()->role == 'admin')
                    <a href="{{ route('photos.edit', $photo->id) }}" class="btn btn-warning btn-sm ms-2 mt-2">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('photos.destroy', $photo->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus foto ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm ms-2 mt-2">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

</div>

<!-- Modal Preview Foto -->
<div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content rounded-4">
      <div class="modal-header border-0">
        <h5 class="modal-title" id="photoModalLabel">Preview Foto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body text-center">
        <img id="modalImage" src="" class="img-fluid rounded-3 w-100" style="max-height: 600px; object-fit: contain;">
      </div>
    </div>
  </div>
</div>
<style>
    .text-gradient {
    background: linear-gradient(45deg, #fbc2eb, #a6c1ee);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.btn-pink-purple {
    background: linear-gradient(135deg, #fbc2eb, #a6c1ee);
    color: white;
    border: none;
}

.btn-pink-purple:hover {
    background: linear-gradient(135deg, #e2b2f0, #91bdf2);
    color: white;
}

    </style>
@endsection

@push('scripts')
<script>
  function showImageModal(imageUrl) {
    const modalImage = document.getElementById('modalImage');
    modalImage.src = imageUrl;

    const modal = new bootstrap.Modal(document.getElementById('photoModal'));
    modal.show();
  }
</script>
@endpush
