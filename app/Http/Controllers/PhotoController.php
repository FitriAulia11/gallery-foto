<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\Like;
use App\Models\User;
use App\Models\Category;

class PhotoController extends Controller
{
    public function index(Request $request)
    {
        $query = Photo::with(['user', 'likes', 'comments', 'category']); 
       
        if ($request->has('search')) {
            $search = $request->search;
    
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%') 
                  ->orWhere('description', 'like', '%' . $search . '%') 
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', '%' . $search . '%'); 
                  })
                  ->orWhereHas('category', function ($catQuery) use ($search) {
                      $catQuery->where('name', 'like', '%' . $search . '%');
                  });
            });
        }
    
        
        if ($request->filled('category')) {
            $categoryId = $request->category;
    
            
            $activeCategory = Category::find($categoryId);
    
            if ($activeCategory) {
                $query->where('category_id', $categoryId);
            }
        }
        $photos = $query->latest()->paginate(12);
    
        $activeCategory = $request->category ? \App\Models\Category::find($request->category) : null;
    
        return view('photos.index', compact('photos', 'activeCategory'));
    }
        
public function create()
{
    $categories = Category::all();
    return view('photos.create', compact('categories'));
}


    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:500',
            'category_id' => 'required|exists:categories,id',
        ]);
    
        $imageName = time() . '.' . $request->image->extension();
        $imagePath = 'photos/' . $imageName; 
    
        $request->image->storeAs('public/photos', $imageName);
        Photo::create([
            'user_id' => Auth::id(),
            'image_path' => $imagePath,
            'file_path' => $imagePath,
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id
        ]);
        return redirect()->route('user.dashboard')->with('success', 'Foto berhasil diunggah!');
    }
    

    public function show($id)
    {
        $photo = Photo::with('comments')->findOrFail($id);
        return view('photos.show', compact('photo'));
    }



    public function like($id)
    {
        $photo = Photo::findOrFail($id);
        $user = auth()->user();
    
       
        $like = Like::where('photo_id', $photo->id)->where('user_id', $user->id)->first();
    
        if ($like) {
           
            $like->delete();
            $liked = false;
        } else {
            $photo->likes()->create(['user_id' => $user->id]);
            $liked = true;
        }
    
        return response()->json([
            'likes' => $photo->likes()->count(),
            'liked' => $liked,
        ]);
    }
  


public function destroy($id)
{
    $photo = Photo::findOrFail($id);

    \Log::info("User yang mencoba hapus: " . Auth::id() . " - Pemilik Foto: " . $photo->user_id);

    if (Auth::id() !== $photo->user_id && Auth::user()->role !== 'admin') {
        abort(403, 'Unauthorized action.');
    }

    Storage::delete('public/' . $photo->image_path);
    $photo->delete();

    $this->authorize('delete', $photo);

    return redirect()->route('profile.show', Auth::id())->with('success', 'Foto berhasil dihapus!');
}

public function edit($id)
{
    $photo = Photo::findOrFail($id);
    
    if ($photo->user_id !== auth()->id()) {
        return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki izin untuk mengedit foto ini.');
    }

    return view('photos.edit', compact('photo'));
}


public function update(Request $request, $id)
{
    $photo = Photo::findOrFail($id);

    $request->validate([
        'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        'description' => 'required|string|max:255',
    ]);

    if ($request->hasFile('photo')) {
        Storage::delete('public/' . $photo->image_path);

        $path = $request->file('photo')->store('photos', 'public');
        $photo->image_path = $path;
    }

    $photo->description = $request->description;
    $photo->save();

    return redirect()->route('profile.show', $photo->user_id)->with('success', 'Foto berhasil diperbarui!');
}

public function profile(User $user)
{
    $photos = Photo::where('user_id', $user->id)
        ->withCount(['likes', 'comments'])
        ->get();

    return view('profile', compact('user', 'photos'));
}

public function __construct()
{
    $this->middleware('auth'); 
}


public function byCategory($id)
{
    $category = Category::findOrFail($id);
    $photos = $category->photos()->latest()->paginate(12);

    return view('photos.index', compact('photos', 'category'));
}

public function toggleStatus($id)
{
    $photo = Photo::findOrFail($id);
    $photo->status = !$photo->status; 
    $photo->save();

    return redirect()->route('admin.dashboard')->with('success', 'Status foto berhasil diperbarui.');
}


}
