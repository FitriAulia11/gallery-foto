<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function create()
    {
        return view('photos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|max:2048'
        ]);

        $path = $request->file('image')->store('photos', 'public');

        Photo::create([
            'user_id' => Auth::id(),
            'title' => $request->title ?? 'Untitled',
            'description' => $request->description,
            'image_path' => $path,
            'status' => true,
        ]);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|max:2048'
        ]);

        
        return redirect()->route('user.dashboard')->with('success', 'Photo uploaded successfully.');
    }

    public function edit($id)
    {
        $photo = Photo::findOrFail($id);
        if (Auth::id() !== $photo->user_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('photos.edit', compact('photo'));
    }

    public function update(Request $request, $id)
    {
        $photo = Photo::findOrFail($id);
        if (Auth::id() !== $photo->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            Storage::delete('public/' . $photo->image_path);
            $photo->image_path = $request->file('image')->store('photos', 'public');
        }

        $photo->title = $request->title;
        $photo->description = $request->description;
        $photo->save();

        return redirect()->route('user.dashboard')->with('success', 'Photo updated successfully.');
    }

    public function destroy($id)
    {
        $photo = Photo::findOrFail($id);
        if (Auth::id() !== $photo->user_id) {
            abort(403, 'Unauthorized action.');
        }

        Storage::delete('public/' . $photo->image_path);
        $photo->delete();

        return redirect()->route('user.dashboard')->with('success', 'Photo deleted successfully.');
    }

    public function like($id)
    {
        return response()->json(['message' => 'Feature coming soon!']);
    }

    public function toggleStatus($id)
    {
        $photo = Photo::findOrFail($id);
        $photo->status = !$photo->status;
        $photo->save();

        return redirect()->route('admin.dashboard')->with('success', 'Photo status updated.');
    }
}
