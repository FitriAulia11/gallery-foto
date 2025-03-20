@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Profil Pengguna -->
    <div class="text-center mb-4">
        <h2 class="fw-bold">Profil {{ $user->name }}</h2>
        <p>Email: {{ $user->email }}</p>
    </div>

    <!-- Foto yang Diupload Pengguna -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Foto Saya</h4>
        @if(Auth::id() == $user->id)
            <a href="{{ route('photos.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Foto
            </a>
        @endif
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
                 data-like-count="{{ $photo->likes_count }}"
                 data-comment-count="{{ $photo->comments_count }}"
                 data-is-liked="{{ $photo->likes->where('user_id', auth()->id())->count() > 0 ? 'true' : 'false' }}"/>
            <div class="card-body">
                <h5 class="card-title">{{ $photo->caption }}</h5>
            </div>
            <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                <small class="text-muted">{{ $photo->user->name }}</small>
                <div class="d-flex align-items-center">
                    <!-- Tombol Like -->
                    <form action="{{ route('photos.like', $photo->id) }}" method="POST" class="me-2 like-form">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm like-button" data-photo-id="{{ $photo->id }}">
                            <i class="bi {{ Auth::user() && $photo->likes->contains('user_id', Auth::id()) ? 'bi-heart-fill text-danger' : 'bi-heart' }} me-1 like-icon"></i> 
                            <span class="like-count">{{ $photo->likes_count ?? 0 }}</span>
                        </button>
                    </form>

                    <!-- Jumlah Komentar -->
                    <a href="{{ route('photos.show', $photo->id) }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center">
                        <i class="bi bi-chat-dots me-1"></i> <span class="comment-count">{{ $photo->comments_count ?? 0 }}</span>
                    </a>
                </div>
                @if(Auth::id() == $photo->user_id || Auth::user()->role == 'admin')
                    <a href="{{ route('photos.edit', $photo->id) }}" class="btn btn-warning btn-sm me-2">
                        <i class="bi bi-pencil"></i>
                    </a>
                    @if(Auth::id() == $photo->user_id || Auth::user()->role == 'admin')
    <form action="{{ route('photos.destroy', $photo->id) }}" method="POST" onsubmit="return confirmDelete(event)">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm">
            <i class="bi bi-trash"></i>
        </button>
    </form>
@endif

<script>
    function confirmDelete(event) {
        event.preventDefault();
        if (confirm('Hapus foto ini?')) {
            event.target.submit();
        }
    }
</script>
                @endif
            </div>
        </div>
    </div>
@endforeach
        </div>
    @endif
</div>

<!-- Modal untuk menampilkan foto -->
<div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoModalLabel">Foto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
    <img id="modalPhoto" src="" class="img-fluid rounded" 
         alt="Preview"
         style="width: 100%; max-height: 500px; object-fit: cover;">
    <p class="mt-2 text-muted" id="photoCaption"></p>
    <p class="text-muted" id="photoUser"></p>
</div>

            <div class="modal-footer d-flex align-items-center">
                <span id="likeCount" class="me-2 fs-5 text-dark"></span>
                <form id="likeForm" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger d-flex align-items-center">
                        <i id="likeIcon" class="bi bi-heart me-1"></i> Like
                    </button>
                </form>
                <span id="commentCount" class="ms-3 me-2 fs-5 text-dark"></span>
                <a href="#" id="commentLink" class="btn btn-outline-secondary d-flex align-items-center">
                    <i class="bi bi-chat-dots me-1"></i> Komentar
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

            let likeCount = this.getAttribute("data-like-count") || 0;
            let commentCount = this.getAttribute("data-comment-count") || 0;
            
            document.getElementById("likeCount").innerText = likeCount;
            document.getElementById("commentCount").innerText = commentCount;
            
            let isLiked = this.getAttribute("data-is-liked") === "true";
            let likeIcon = document.getElementById("likeIcon");
            
            if (isLiked) {
                likeIcon.classList.remove("bi-heart");
                likeIcon.classList.add("bi-heart-fill", "text-danger");
            } else {
                likeIcon.classList.remove("bi-heart-fill", "text-danger");
                likeIcon.classList.add("bi-heart");
            }
        });
    });
});
</script>
@endsection
