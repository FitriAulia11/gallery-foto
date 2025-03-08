<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Photo;

class AdminController extends Controller
{
    public function index()
    {
        $photos = Photo::latest()->get();
        return view('admin.index', compact('photos'));
    }

    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function destroyUser($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.users')->with('success', 'User berhasil dihapus');
    }
}
