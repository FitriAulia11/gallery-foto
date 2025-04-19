@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Header Galeri -->
    <div class="text-center mb-4">
        <h2 class="fw-bold display-5 text-gradient">
            <i class="bi bi-images me-2"></i> Galeri Foto
        </h2>
        <p class="text-muted fs-5">Jelajahi dan bagikan foto terbaikmu di sini 🎨</p>
    </div>

    <!-- Kategori aktif -->
    @isset($activeCategory)
        <div class="text-center mb-4">
            <span class="badge rounded-pill bg-light text-dark px-4 py-2 shadow-sm">
                Kategori: <strong>{{ $activeCategory->name }}</strong>
            </span>
        </div>
    @endisset

    <!-- Form Pencarian -->
    <div class="row justify-content-center mb-5">
        <div class="col-md-10 col-lg-8">
            <form method="GET" action="{{ route('photos.index') }}">
                <div class="input-group shadow-sm">
                    <input type="text" name="search" class="form-control rounded-start-pill px-4 py-2"
                        placeholder="🔍 Cari judul, deskripsi, user, atau kategori..."
                        value="{{ request('search') }}">
                    
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif

                    <button type="submit" class="btn btn-pink-purple rounded-end-pill px-4">
                        <i class="bi bi-search me-1"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div>


    {{-- Tampilkan foto --}}
    @if($photos->isEmpty())
        <div class="alert alert-warning text-center">Belum ada foto yang ditemukan.</div>
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
                             data-comment-url="{{ route('photos.show', $photo->id) }}"
                             alt="Photo">

                        <div class="card-body d-flex justify-content-between">
                            <!-- ❤️ Like Button -->
                            <form action="{{ route('photos.like', $photo->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-like btn-sm">
                                    <i class="bi {{ $photo->likedByUser() ? 'bi-heart-fill text-danger' : 'bi-heart' }}"></i>
                                    <span class="like-count">{{ $photo->likes->count() }}</span>
                                </button>
                            </form>

                            <!-- 💬 Comment Button -->
                            <a href="{{ route('photos.show', $photo->id) }}" class="btn btn-light btn-sm comment-button">
                                <i class="bi bi-chat-dots"></i>
                                <span class="comment-count">{{ $photo->comments->count() }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $photos->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection

@section('scripts')
<!-- Masonry Layout -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/4.2.2/masonry.pkgd.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".preview-photo").forEach(photo => {
        photo.addEventListener("click", function() {
            const commentUrl = this.getAttribute("data-comment-url");
            if (commentUrl) {
                window.location.href = commentUrl;
            }
        });
    });

    var grid = document.querySelector('.row');
    if (grid) {
        new Masonry(grid, {
            itemSelector: '.col-md-3',
            percentPosition: true
        });
    }
});
</script>

<!-- Style Like Button -->
<style>
    .btn-like {
        background-color: white;
        border: 1px solid #dc3545;
        color: #dc3545;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
    }

    .btn-like:hover {
        background-color: #dc3545;
        color: white;
    }

    .btn-like .bi-heart-fill {
        color: #dc3545 !important;
    }

    .btn-like .bi-heart {
        color: #dc3545;
    }

    .like-count {
        margin-left: 4px;
    }
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
