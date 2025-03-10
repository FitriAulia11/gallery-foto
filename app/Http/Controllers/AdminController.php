<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Photo;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        $photos = Photo::all();
        return view('admin.dashboard', compact('users', 'photos'));
    }

    public function destroyUser($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'User berhasil dihapus');
    }
}
