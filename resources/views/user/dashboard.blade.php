@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="fw-bold">Dashboard</h2>
    <p class="text-muted">Lihat semua foto yang telah diunggah oleh pengguna.</p>

    <!-- Search Bar di Bawah Navbar -->
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-4">
                <form action="{{ route('dashboard') }}" method="GET">
                    <div class="input-group shadow-sm">
                        <input class="form-control" type="search" name="search" placeholder="Cari gambar..." value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tambahkan Jarak antara Search Bar dan Galeri -->
    <div class="mb-4"></div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($photos as $photo)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('storage/' . $photo->image_path) }}" 
                         class="card-img-top img-fluid w-100 preview-photo" 
                         style="max-height: 300px; object-fit: cover; cursor: pointer;" 
                         data-bs-toggle="modal" 
                         data-bs-target="#photoModal"
                         data-src="{{ asset('storage/' . $photo->image_path) }}"
                         data-caption="{{ $photo->caption }}"
                         data-user="{{ $photo->user->name }}"
                         data-like-url="{{ route('photos.like', $photo->id) }}"
                         data-comment-url="{{ route('photos.show', $photo->id) }}"
                         data-like-count="{{ $photo->likes_count }}"
                         data-comment-count="{{ $photo->comments_count }}"
                         data-is-liked="{{ $photo->likes->where('user_id', auth()->id())->count() > 0 ? 'true' : 'false' }}"
                         alt="Photo">

                    <div class="card-body">
                        <h5 class="card-title">{{ $photo->caption }}</h5>
                        <p class="text-muted">{{ $photo->user->name }}</p>
                    </div>
                    <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                        <span class="text-muted small">👤 {{ $photo->user->name }}</span>

                        <div class="d-flex align-items-center">
                            <form action="{{ route('photos.like', $photo->id) }}" method="POST" class="me-2 like-form">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm like-button">
                                    <i class="bi {{ Auth::user() && $photo->likes->contains('user_id', Auth::id()) ? 'bi-heart-fill text-danger' : 'bi-heart' }} me-1 like-icon"></i> 
                                    <span class="like-count">{{ $photo->likes_count ?? 0 }}</span>
                                </button>
                            </form>

                            <a href="{{ route('photos.show', $photo->id) }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center">
                                <i class="bi bi-chat-dots me-1"></i> 
                                <span class="comment-count">{{ $photo->comments_count ?? 0 }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Modal untuk menampilkan detail foto -->
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
            document.getElementById("photoUser").innerText = "👤 " + this.getAttribute("data-user");
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
