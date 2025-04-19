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
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
            @foreach($photos as $photo)
                <div class="col mb-3">
                    <div class="d-flex flex-column align-items-center">
                        <img 
                            src="{{ asset('storage/' . $photo->image_path) }}" 
                            alt="Photo"
                            class="img-fluid mb-3 preview-photo shadow-sm"
                            style="cursor: pointer; object-fit: cover; border-radius: 15px; width: 100%; max-height: {{ rand(250, 350) }}px; transition: transform 0.3s ease, opacity 0.3s ease; margin-bottom: 10px;"
                            onmouseover="this.style.transform='scale(1.05)'; this.style.opacity='0.9';"
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
                        @if($photo->caption)
                            <h6 class="fw-semibold mb-1 text-center" style="font-size: {{ rand(16, 20) }}px; color: #333;">{{ $photo->caption }}</h6>
                        @endif
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
                <p class="text-muted small" id="photoUser" style="display: none;"></p>
            </div>
            <div class="card-body d-flex justify-content-between">
                            <!-- ❤️ Like Button -->
                            <form action="{{ route('photos.like', $photo->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-like btn-sm">
                                    <i class="bi {{ $photo->likedByUser() ? 'bi-heart-fill text-danger' : 'bi-heart' }}"></i>
                                    <span class="like-count">{{ $photo->likes->count() }}</span>
                                </button>
                            </form>
                            
                    <button type="button" class="btn btn-sm btn-outline-danger" id="modalLikeButton">
                        <i class="bi" id="likeIcon"></i> 
                    </button>

                    <span class="ms-3 me-2 fs-6">
                        Komentar : <span id="commentCount"></span>
                    </span>
                    <a href="#" id="commentLink" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-chat-dots"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", () => {
    const modalPhoto = document.getElementById("modalPhoto");
    const photoCaption = document.getElementById("photoCaption");
    const photoUser = document.getElementById("photoUser");
    const likeCount = document.getElementById("likeCount");
    const commentCount = document.getElementById("commentCount");
    const likeIcon = document.getElementById("likeIcon");
    const modalLikeButton = document.getElementById("modalLikeButton");
    const commentLink = document.getElementById("commentLink");

    document.querySelectorAll(".preview-photo").forEach(photo => {
        photo.addEventListener("click", function () {
            // Set data ke modal
            modalPhoto.src = this.dataset.src;
            modalPhoto.dataset.likeUrl = this.dataset.likeUrl;
            photoCaption.textContent = this.dataset.caption;
            photoUser.textContent = "👤 " + this.dataset.user;
            likeCount.textContent = this.dataset.likeCount;
            commentCount.textContent = this.dataset.commentCount;
            commentLink.href = this.dataset.commentUrl;

            // Update ikon
            const isLiked = this.dataset.isLiked === "true";
            likeIcon.className = isLiked ? "bi bi-heart-fill text-danger me-1" : "bi bi-heart me-1";

            // Tampilkan elemen
            photoUser.style.display = "block";
        });
    });

    modalLikeButton.addEventListener("click", function () {
        const likeUrl = modalPhoto.dataset.likeUrl;

        fetch(likeUrl, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                "Accept": "application/json"
            }
        })
        .then(res => res.json())
        .then(data => {
            likeCount.textContent = data.likes;
            likeIcon.className = data.liked ? "bi bi-heart-fill text-danger me-1" : "bi bi-heart me-1";
        })
        .catch(err => console.error("Gagal Like:", err));
    });
});
</script>
@endsection
