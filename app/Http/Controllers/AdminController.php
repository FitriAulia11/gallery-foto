<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Photo;

class AdminController extends Controller
{
    public function index()
    {
        $photos = Photo::all();
        return view('admin.dashboard', compact('photos'));
    }

    public function users()
    {
        $users = User::where('role', 'user')->get();
        return view('admin.users', compact('users'));
    }

    public function destroyUser($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'User deleted.');
    }
}
