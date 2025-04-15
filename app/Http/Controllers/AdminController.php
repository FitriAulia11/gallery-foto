<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Photo;
use App\Models\Album;
use App\Models\Comment;
use App\Models\Like;

class AdminController extends Controller
{
    public function index()
    {
        $totalPhotos = Photo::count();
        $totalComments = Comment::count();
        $totalLikes = Like::count();
        $totalUsers = User::count();

        return view('admin.dashboard', compact(
            'totalPhotos', 
            'totalComments', 
            'totalLikes', 
            'totalUsers'
            
        ));
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'User berhasil dihapus.');
    }
}
