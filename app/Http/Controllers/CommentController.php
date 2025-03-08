<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Auth;

class CommentController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate(['content' => 'required']);

        Comment::create([
            'content' => $request->content,
            'photo_id' => $id,
            'user_id' => Auth::id(),
        ]);

        return back();
    }
}
