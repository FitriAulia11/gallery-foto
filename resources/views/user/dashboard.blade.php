@extends('layouts.app')

@section('content')
<div class="container">
    <div class="text-center mb-4">
        <h2 class="fw-bold">Galeri Foto</h2>
        <p class="text-muted">Jelajahi dan bagikan foto terbaikmu</p>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Foto Saya</h4>
        <a href="{{ route('photos.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Foto
        </a>
    </div>

    @if($photos->isEmpty())
        <div class="alert alert-warning text-center">Belum ada foto yang diunggah.</div>
    @else
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($photos as $photo)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ asset('storage/' . $photo->image_path) }}" 
                             class="card-img-top img-fluid w-100 preview-photo" 
                             style="max-height: 200px; object-fit: cover; cursor: pointer;" 
                             data-bs-toggle="modal" 
                             data-bs-target="#photoModal"
                             data-src="{{ asset('storage/' . $photo->image_path) }}"
                             data-caption="{{ $photo->caption }}"
                             data-like-url="{{ route('photos.like', $photo->id) }}"
                             data-comment-url="{{ route('photos.show', $photo->id) }}"
                             alt="Photo">
                        <div class="card-body">
                            <h5 class="card-title">{{ $photo->caption }}</h5>
                        </div>
                        <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                            <small class="text-muted">Diunggah oleh: {{ $photo->user->name }}</small>

                            <div class="d-flex align-items-center">

                            <form action="{{ route('photos.like', $photo->id) }}" method="POST" class="me-2">
                                    @csrf
                                    <button type="submit" class="btn btn-light btn-sm">
                                        <i class="bi bi-hand-thumbs-up"></i>
                                    </button>
                                </form>

                                <a href="{{ route('photos.show', $photo->id) }}" class="btn btn-light btn-sm me-2">
                                    <i class="bi bi-chat-dots"></i>
                                </a>

                                @if(Auth::user()->role == 'admin')
                                    <a href="{{ route('photos.edit', $photo->id) }}" class="btn btn-warning btn-sm me-2">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form action="{{ route('photos.destroy', $photo->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus foto ini?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoModalLabel">Foto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalPhoto" src="" class="img-fluid rounded" alt="Preview">
                <p class="mt-2" id="photoCaption"></p>
            </div>
            <div class="modal-footer">
                <form id="likeForm" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="bi bi-hand-thumbs-up"></i> Like
                    </button>
                </form>
                <a href="#" id="commentLink" class="btn btn-outline-secondary">
                    <i class="bi bi-chat-dots"></i> Komentar
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".preview-photo").forEach(photo => {
        photo.addEventListener("click", function() {
            document.getElementById("modalPhoto").src = this.getAttribute("data-src");
            document.getElementById("photoCaption").innerText = this.getAttribute("data-caption");
            document.getElementById("likeForm").action = this.getAttribute("data-like-url");
            document.getElementById("commentLink").href = this.getAttribute("data-comment-url");
        });
    });
});
</script>
@endsection
