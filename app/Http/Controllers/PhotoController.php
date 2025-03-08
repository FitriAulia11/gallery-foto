<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use Auth;

class PhotoController extends Controller
{
    public function create()
    {
        return view('photos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required|image',
        ]);

        $path = $request->file('image')->store('photos', 'public');

        Photo::create([
            'title' => $request->title,
            'path' => $path,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Foto berhasil diunggah');
    }

    public function like($id)
    {
        $photo = Photo::findOrFail($id);
        $photo->likes()->attach(Auth::id());
        return back();
    }

    public function toggleStatus($id)
    {
        $photo = Photo::findOrFail($id);
        $photo->status = !$photo->status;
        $photo->save();
        return back();
    }
}
