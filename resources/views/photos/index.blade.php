@extends('layouts.app')

@section('content')
<div class="container">
    <div class="text-center mb-4">
        <h2 class="fw-bold">Galeri Foto</h2>
        <p class="text-muted">Jelajahi dan bagikan foto terbaikmu</p>
    </div>

    @if($photos->isEmpty())
        <div class="alert alert-warning text-center">Belum ada foto yang diunggah.</div>
    @else
        <div class="row" data-masonry='{"percentPosition": true }'>
            @foreach($photos as $photo)
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="card border-0 shadow-sm">
                        <img src="{{ asset('storage/' . $photo->image_path) }}" 
                             class="card-img-top img-fluid preview-photo"
                             style="cursor: pointer; border-radius: 15px; transition: 0.3s ease-in-out;"
                             onmouseover="this.style.opacity='0.8';"
                             onmouseout="this.style.opacity='1';"
                             data-bs-toggle="modal"
                             data-bs-target="#photoModal"
                             data-src="{{ asset('storage/' . $photo->image_path) }}"
                             data-caption="{{ $photo->caption }}"
                             data-like-url="{{ route('photos.like', $photo->id) }}"
                             data-comment-url="{{ route('photos.show', $photo->id) }}"
                             alt="Photo">
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<div class="d-flex align-items-center">
<div class="d-flex align-items-center">

<button type="button" class="btn btn-light btn-sm like-button" data-photo-id="{{ $photo->id }}">
        <i class="bi bi-hand-thumbs-up"></i>
        <span class="like-count">{{ $photo->likes->count() }}</span>
    </button>

    <a href="{{ route('photos.show', $photo->id) }}" class="btn btn-light btn-sm me-2 comment-button" data-photo-id="{{ $photo->id }}">
        <i class="bi bi-chat-dots"></i>
        <span class="comment-count">{{ $photo->comments->count() }}</span>
    </a>
</div>

<div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoModalLabel">Foto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalPhoto" src="" class="img-fluid rounded shadow" alt="Preview">
                <p class="mt-2 fw-bold" id="photoCaption"></p>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <form id="likeForm" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="bi bi-hand-thumbs-up"></i> Like
                    </button>
                </form>
                <a href="#" id="commentLink" class="btn btn-outline-secondary">
                    <i class="bi bi-chat-dots"></i> Komentar
                </a>
                <form action="{{ route('photo.like', $photo->id) }}" method="POST">
    @csrf
    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">
        ❤️ {{ $photo->likes->count() }} Suka
    </button>
</form>

            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/4.2.2/masonry.pkgd.min.js"></script>

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

    var grid = document.querySelector('.row');
    if (grid) {
        var masonry = new Masonry(grid, {
            itemSelector: '.col-md-3',
            percentPosition: true
        });
    }
});
</script>
@endsection
@foreach ($photos as $photo)
    <div class="card mb-3">
        <img src="{{ asset('storage/' . $photo->image) }}" class="card-img-top" alt="Photo">
        <div class="card-body">
            <h5 class="card-title">{{ $photo->title }}</h5>
            <p class="card-text">{{ $photo->description }}</p>
            <button class="btn btn-light btn-sm me-2 open-comments" 
                data-bs-toggle="modal" 
                data-bs-target="#commentModal"
                data-comment-url="{{ route('photos.comments', $photo->id) }}">
                <i class="bi bi-chat-dots"></i> Komentar
            </button>
        </div>
    </div>
@endforeach
