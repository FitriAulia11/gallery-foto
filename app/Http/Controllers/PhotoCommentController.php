<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, $photoId)
    {
        // Validasi input sesuai kolom database
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        // Simpan komentar baru
        Comment::create([
            'user_id' => Auth::id(),
            'photo_id' => $photoId,
            'content' => $request->input('content'), // Kolom di database bernama content
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan!');
    }
}
