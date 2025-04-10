<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class PhotoController extends Controller
{
    public function index(Request $request)
    {
        $query = Photo::with(['user', 'likes', 'comments']);
    
        if ($request->has('search')) {
            $search = $request->search;
    
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', '%' . $search . '%')                   ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', '%' . $search . '%');
                  });
            });
        }
    
        $photos = $query->latest()->get();
    
        return view('photos.index', compact('photos'));
    }    
            

    public function create()
    {
        return view('photos.create'); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:500'
        ]);
    
        // Simpan file ke storage
        $imageName = time() . '.' . $request->image->extension();
        $imagePath = 'photos/' . $imageName; // Tambahkan path
    
        $request->image->storeAs('public/photos', $imageName);
    
        // Simpan ke database
        Photo::create([
            'user_id' => Auth::id(), // Pastikan user login
            'image_path' => $imagePath, // Pastikan kolom ini ada di database
            'title' => $request->title,
            'description' => $request->description,
        ]);
    
        return redirect()->route('user.dashboard')->with('success', 'Foto berhasil diunggah!');
    }
    

    public function show($id)
    {
        $photo = Photo::with('comments')->findOrFail($id);
        return view('photos.show', compact('photo'));
    }

public function like(Photo $photo)
{
    $user = auth()->user();

    if (!$user) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $liked = $photo->likes()->where('user_id', $user->id)->exists();

    if ($liked) {
        $photo->likes()->where('user_id', $user->id)->delete();
    } else {
        $photo->likes()->create(['user_id' => $user->id]);
    }

    return response()->json([
        'liked' => !$liked,
        'likes' => $photo->likes()->count(),
    ]);
}

  
    public function toggleStatus($id)
{
    $photo = Photo::findOrFail($id);
    $photo->status = !$photo->status; // Ubah status aktif/nonaktif
    $photo->save();

    return redirect()->route('admin.dashboard')->with('success', 'Status foto berhasil diperbarui.');
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

// Menampilkan form edit foto
public function edit($id)
{
    $photo = Photo::findOrFail($id);
    
    // Pastikan hanya pemilik foto yang bisa mengedit
    if ($photo->user_id !== auth()->id()) {
        return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki izin untuk mengedit foto ini.');
    }

    return view('photos.edit', compact('photo'));
}

// Menyimpan hasil edit
public function update(Request $request, $id)
{
    $photo = Photo::findOrFail($id);

    $request->validate([
        'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        'description' => 'required|string|max:255',
    ]);

    if ($request->hasFile('photo')) {
        // Hapus foto lama jika ada foto baru
        Storage::delete('public/' . $photo->image_path);

        // Simpan foto baru
        $path = $request->file('photo')->store('photos', 'public');
        $photo->image_path = $path;
    }

    $photo->description = $request->description;
    $photo->save();

    // Kembali ke halaman profil dengan pesan sukses
    return redirect()->route('profile.show', $photo->user_id)->with('success', 'Foto berhasil diperbarui!');
}

public function profile(User $user)
{
    $photos = Photo::where('user_id', $user->id)
        ->withCount(['likes', 'comments']) // Pastikan ini ada
        ->get();

    return view('profile', compact('user', 'photos'));
}




}
