<?php

namespace App\Http\Controllers;
use App\Models\Photo;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        // Ambil semua foto yang diunggah
        $photos = Photo::all();

        // Tampilkan halaman galeri
        return view('gallery.index', compact('photos'));
    }
    public function search(Request $request)
    {
        $searchTerm = $request->input('search');

        // Cari foto berdasarkan caption atau tags
        $photos = Photo::where('caption', 'like', '%' . $searchTerm . '%')
            ->orWhere('tags', 'like', '%' . $searchTerm . '%')
            ->get();

        return view('gallery.index', compact('photos'));
    }
}

