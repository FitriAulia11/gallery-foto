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

}
