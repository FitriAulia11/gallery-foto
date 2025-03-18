<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{

    public function index()
    {
        $photos = Photo::withCount(['likes', 'comments'])->latest()->get();
        return view('photos.index', compact('photos'));
            }

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
        $photo = Photo::findOrFail($id);
    
        $existingLike = Like::where('photo_id', $photo->id)
                            ->where('user_id', auth()->id())
                            ->first();
    
        if ($existingLike) {
            $existingLike->delete();
            $photo->decrement('likes'); 
            return response()->json(['status' => 'unliked', 'likes' => $photo->likes]);
        } else {

            Like::create([
                'photo_id' => $photo->id,
                'user_id' => auth()->id(),
            ]);
            $photo->increment('likes');
            return response()->json(['status' => 'liked', 'likes' => $photo->likes]);
        }
         
    // Tambahkan like baru
    $photo->likes()->create([
        'user_id' => auth()->id()
    ]);

    // Kembalikan jumlah like terbaru dalam JSON response
    return response()->json(['likes_count' => $photo->likes()->count()]);
    }
        
    public function toggleStatus($id)
    {
        $photo = Photo::findOrFail($id);
        $photo->status = !$photo->status;
        $photo->save();

        return redirect()->route('admin.dashboard')->with('success', 'Photo status updated.');
    }
    public function user()
{
    
    $photos = Photo::where('user_id', auth()->id())->get();

    return view('photos.user', compact('photos'));
}

public function show($id)
    {
        $photo = Photo::with('comments.user')->find($id);

        if (!$photo) {
            return response()->json(['message' => 'Photo not found'], 404);
        }

        return response()->json([
            'comments_count' => $photo->comments->count(),
            'comments' => $photo->comments->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'user' => $comment->user->name,
                    'content' => $comment->content,
                    'created_at' => $comment->created_at->diffForHumans(),
                ];
                return view('photos.show', compact('photo'));
            }),
        ]);
    }
}
