<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = Photo::with(['user', 'likes', 'comments']); // Memuat relasi user, likes, dan comments
    
        // Pencarian berdasarkan caption atau nama pengguna
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', '%' . $search . '%')
                  ->orWhere('title', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', '%' . $search . '%');
                  });
            });
        }
    


        $activeCategory = null;
        if ($request->filled('category')) {
            $categorySlug = $request->category;
            $query->where('category', $categorySlug);
            
            $activeCategory = (object)[
                'name' => ucwords(str_replace('-', ' ', $categorySlug))
            ];
        }
        
        // Menambahkan paginasi dengan 12 foto per halaman
        $photos = $query->latest()->paginate(12); 
    
        // Mengembalikan ke view dengan data photos
        return view('photos.index', compact('photos'));
    }
    
    public function showProfile($id)
{
    $user = User::findOrFail($id);
    $photos = Photo::where('user_id', $id)->get();
    $photos = $user->photos()->latest()->get(); 
    return view('profile.show', compact('user', 'photos'));
}

public function showWelcome()
{
    $photos = photo::latest()->take(6)->get();
    return view('Welcome',compact('photos'));
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'role' => 'required|in:admin,user',
        'password' => 'required|min:6|confirmed',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role,
        'password' => Hash::make($request->password),
    ]);

    return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan');
}


}


