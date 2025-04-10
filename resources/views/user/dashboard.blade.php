@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-4">
        <h2 class="fw-bold">📸 Galeri Foto</h2>
        <p class="text-muted">Jelajahi dan bagikan foto terbaikmu di sini.</p>
    </div>

    <div class="row justify-content-center mb-5">
        <div class="col-md-8">
            <form method="GET" action="{{ route('photos.index') }}">
                <div class="input-group shadow-sm">
                    <input type="text" name="search" class="form-control rounded-start-pill" placeholder="🔍 Cari foto berdasarkan caption atau pengguna..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary rounded-end-pill px-4">Cari</button>
                </div>
            </form>
        </div>
    </div>

    @if($photos->isEmpty())
        <div class="alert alert-warning text-center">
            Belum ada foto yang diunggah.
        </div>
    @else
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @foreach($photos as $photo)
                <div class="col">
                    <div class="card border-0 shadow rounded-4 h-100">
                        <img 
                            src="{{ asset('storage/' . $photo->image_path) }}" 
                            alt="Photo"
                            class="card-img-top preview-photo rounded-top-4"
                            loading="lazy"
                            style="cursor: pointer; transition: transform 0.2s, opacity 0.3s;"
                            onmouseover="this.style.transform='scale(1.03)'; this.style.opacity='0.9';"
                            onmouseout="this.style.transform='scale(1)'; this.style.opacity='1';"
                            data-bs-toggle="modal"
                            data-bs-target="#photoModal"
                            data-src="{{ asset('storage/' . $photo->image_path) }}"
                            data-caption="{{ $photo->caption }}"
                            data-user="{{ $photo->user->name }}"
                            data-like-url="{{ route('photos.like', $photo->id) }}"
                            data-comment-url="{{ route('photos.show', $photo->id) }}"
                            data-like-count="{{ $photo->likes->count() }}"
                            data-comment-count="{{ $photo->comments->count() }}"
                            data-is-liked="{{ $photo->likes->contains('user_id', auth()->id()) ? 'true' : 'false' }}"
                        >

                        <div class="card-body text-center">
                            <h6 class="fw-semibold mb-1">{{ $photo->caption ?? 'Tanpa Judul' }}</h6>
                            <p class="text-muted small mb-2">👤 {{ $photo->user->name }}</p>
                            <div class="d-flex justify-content-center gap-2">
                                <!-- Tombol Like -->
                                <form action="{{ route('photos.like', $photo->id) }}" method="POST" class="like-form">
                                    @csrf
                                    <button type="submit" class="btn btn-light btn-sm like-button">
                                        <i class="bi {{ $photo->likes->contains('user_id', auth()->id()) ? 'bi-heart-fill text-danger' : 'bi-heart' }}"></i>
                                        <span class="like-count">{{ $photo->likes->count() }}</span>
                                    </button>
                                </form>
                                <!-- Tombol Komentar -->
                                <a href="{{ route('photos.show', $photo->id) }}" class="btn btn-light btn-sm">
                                    <i class="bi bi-chat-dots"></i>
                                    <span class="comment-count">{{ $photo->comments->count() }}</span>
                                </a>
                            </div>
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
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header">
                <h5 class="modal-title">Detail Foto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalPhoto" class="img-fluid rounded-4 shadow mb-3" style="max-height: 400px; object-fit: cover;" alt="Preview">
                <p class="fw-bold mb-1" id="photoCaption"></p>
                <p class="text-muted small" id="photoUser"></p>
            </div>
            <div class="modal-footer justify-content-center">
                <span class="me-2 fs-6" id="likeCount"></span>
                <button type="button" class="btn btn-outline-danger btn-sm d-flex align-items-center" id="modalLikeButton">
                    <i id="likeIcon" class="bi bi-heart me-1"></i> Suka
                </button>
                <span class="ms-3 me-2 fs-6" id="commentCount"></span>
                <a href="#" id="commentLink" class="btn btn-outline-secondary btn-sm d-flex align-items-center">
                    <i class="bi bi-chat-dots me-1"></i> Komentar
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".preview-photo").forEach(photo => {
        photo.addEventListener("click", function () {
            const modalPhoto = document.getElementById("modalPhoto");
            const photoCaption = document.getElementById("photoCaption");
            const photoUser = document.getElementById("photoUser");
            const likeCount = document.getElementById("likeCount");
            const commentCount = document.getElementById("commentCount");
            const likeIcon = document.getElementById("likeIcon");
            const modalLikeButton = document.getElementById("modalLikeButton");
            const commentLink = document.getElementById("commentLink");

            modalPhoto.src = this.dataset.src;
            photoCaption.textContent = this.dataset.caption;
            photoUser.textContent = "👤 " + this.dataset.user;
            likeCount.textContent = this.dataset.likeCount + " suka";
            commentCount.textContent = this.dataset.commentCount + " komentar";
            commentLink.href = this.dataset.commentUrl;

            const isLiked = this.dataset.isLiked === "true";
            likeIcon.className = isLiked ? "bi bi-heart-fill text-danger me-1" : "bi bi-heart me-1";

            modalLikeButton.onclick = () => {
                fetch(this.dataset.likeUrl, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({})
                })
                .then(res => res.json())
                .then(data => {
                    likeCount.textContent = data.likes + " suka";
                    likeIcon.className = data.liked ? "bi bi-heart-fill text-danger me-1" : "bi bi-heart me-1";
                });
            };
        });
    });
});
</script>
@endsection
