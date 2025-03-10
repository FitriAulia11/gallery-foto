@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Foto Saya</h2>
    <div class="row">
        @foreach($photos as $photo)
            <div class="col-md-4">
                <div class="card mb-3">
                    <img src="{{ asset('storage/' . $photo->image_path) }}" class="card-img-top" alt="Photo">
                    <div class="card-body">
                        <p>{{ $photo->caption }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
