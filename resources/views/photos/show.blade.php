@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

    <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h3 class="fw-bold">{{ $photo->title }}</h3>
                    <div class="mt-3">
                        <img src="{{ asset('storage/' . $photo->image_path) }}" 
                             class="img-fluid rounded shadow-sm" 
                             style="max-width: 350px; border: 1px solid #ddd;">
                    </div>
                    <p class="mt-3 text-muted">{{ $photo->description }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-8 mt-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold">Komentar</h5>
                    @if($photo->comments->isEmpty())
                        <p class="text-muted text-center">Belum ada komentar.</p>
                    @else
                        <div class="list-group" id="commentList">
                            @foreach($photo->comments as $comment)
                                <div class="list-group-item d-flex align-items-start">
                                    <div class="me-3">
                                        <img src="https://via.placeholder.com/40" 
                                             class="rounded-circle" 
                                             alt="User Avatar">
                                    </div>
                                    <div>
                                        <strong>{{ $comment->user->name ?? 'User' }}</strong>
                                        <p class="mb-1">{{ $comment->content }}</p>
                                        <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-8 mt-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Tambahkan Komentar</h5>

                    <form id="commentForm" data-photo-id="{{ $photo->id }}">
                        @csrf
                        <div class="input-group">
                            <input type="text" id="commentInput" class="form-control" placeholder="Tulis komentar..." required>
                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </div>
                    </form>

                    <ul id="commentList" class="mt-3">
                        @foreach ($photo->comments as $comment)
                            <li><strong>{{ $comment->user->name }}</strong>: {{ $comment->content }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("commentForm").addEventListener("submit", function(event) {
            event.preventDefault();

            let photoId = this.getAttribute("data-photo-id");
            let commentInput = document.getElementById("commentInput");
            let commentList = document.getElementById("commentList");

            fetch(`/photos/${photoId}/comments`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ content: commentInput.value })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    let newComment = document.createElement("li");
                    newComment.innerHTML = `<strong>${data.user_name}</strong>: ${data.content}`;
                    commentList.prepend(newComment);
                    commentInput.value = "";
                } else {
                    alert("Gagal menambahkan komentar.");
                }
            })
            .catch(error => console.error("Error:", error));
        });
    });
</script>

@endsection
