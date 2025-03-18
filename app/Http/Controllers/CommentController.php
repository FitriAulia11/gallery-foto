<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Photo;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:255'
        ]);

        $photo = Photo::findOrFail($id);

        $comment = Comment::create([
            'photo_id' => $photo->id,
            'user_id' => Auth::id(),
            'content' => $request->content
        ]);

        return response()->json([
            'comment' => true,
                'user' => Auth::user()->name,
                'content' => $comment->content
            ]
        );
    }
}
