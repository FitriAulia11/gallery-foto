<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;

class UserController extends Controller
{
    public function index()
    {
        $photos = Photo::where('user_id', auth()->id())->get();
        return view('user.dashboard', compact('photos'));
    }
}
