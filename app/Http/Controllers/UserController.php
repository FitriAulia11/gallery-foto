<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;

class UserController extends Controller
{
    public function index()
    {
        $photos = Photo::where('status', true)->latest()->get();
        return view('user.index', compact('photos')); // Perbaiki nama variabel
    }
    
    public function __construct()
    {
        $this->middleware('auth');
    }
}
