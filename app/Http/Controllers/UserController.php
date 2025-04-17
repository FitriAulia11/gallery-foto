<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $photos = Photo::where('user_id', auth()->id())->get();
        return view('user.dashboard', compact('photos'));
    }

    public function showProfile($id)
{
    $user = User::findOrFail($id);
    $photos = Photo::where('user_id', $id)->get();
    $photos = $user->photos()->latest()->get(); 
    return view('profile.show', compact('user', 'photos'));
}

public function showWelcome()
{
    $photos = photo::latest()->take(6)->get();
    return view('Welcome',compact('photos'));
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'role' => 'required|in:admin,user',
        'password' => 'required|min:6|confirmed',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role,
        'password' => Hash::make($request->password),
    ]);

    return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan');
}


}


