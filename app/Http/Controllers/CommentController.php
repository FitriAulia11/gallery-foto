<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request, $photoId)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'photo_id' => $photoId,
            'content' => $request->content,
        ]);
        

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    public function __construct()
{
    $this->middleware('auth');
}
public function destroy(Comment $comment)
{
    // Cek apakah user yang login adalah pemilik komentar
    if (auth()->id() !== $comment->user_id) {
        return back()->with('error', 'Tidak punya izin untuk menghapus komentar ini.');
    }

    $comment->delete();
    return back()->with('success', 'Komentar berhasil dihapus.');
}


}
