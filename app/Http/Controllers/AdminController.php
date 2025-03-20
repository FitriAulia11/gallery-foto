<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Photo;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all(); // Ambil semua user
        $photos = Photo::with('user')->get(); // Ambil semua foto dengan data user

        return view('admin.dashboard', compact('users', 'photos'));
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'User berhasil dihapus.');
    }
}
