<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo; // ✅ Panggil Model Photo

class WelcomeController extends Controller
{
    public function index() {
        $photos = Photo::latest()->get(); // ✅ Ambil foto terbaru
        return view('welcome', compact('photos'));
    }
}
