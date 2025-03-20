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

}
