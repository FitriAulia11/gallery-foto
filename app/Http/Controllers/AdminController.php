<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Photo;
use App\Models\Album;
use App\Models\Comment;
use App\Models\Like;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        
        $totalPhotos = Photo::count();
        $totalComments = Comment::count();
        $totalLikes = Like::count();
        $totalUsers = User::count();

        return view('admin.dashboard', compact(
            'totalPhotos', 
            'totalComments', 
            'totalLikes', 
            'totalUsers'
            
        ));
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'User berhasil dihapus.');
    }

    public function likesChart()
    {
        // Membuat koleksi bulan-bulan terakhir
        $months = collect(range(0, 5))->map(function ($i) {
            return \Carbon\Carbon::now()->subMonths($i)->format('F Y');
        })->reverse()->values();
    
        // Menghitung jumlah like per bulan
        $likeCounts = [];
        foreach ($months as $month) {
            $start = \Carbon\Carbon::createFromFormat('F Y', $month)->startOfMonth();
            $end = \Carbon\Carbon::createFromFormat('F Y', $month)->endOfMonth();
    
            // Menghitung jumlah like dalam rentang tanggal tersebut
            $likeCounts[] = \App\Models\Like::whereBetween('created_at', [$start, $end])->count();
        }
    
        // Mengirim data ke view
        return view('admin.likes_chart', compact('months', 'likeCounts'));
    }
    
public function commentsChart()
{
    $months = collect(range(0, 5))->map(function ($i) {
        return \Carbon\Carbon::now()->subMonths($i)->format('F Y');
    })->reverse()->values();

    $commentCounts = [];

    foreach ($months as $month) {
        $start = \Carbon\Carbon::createFromFormat('F Y', $month)->startOfMonth();
        $end = \Carbon\Carbon::createFromFormat('F Y', $month)->endOfMonth();

        $commentCounts[] = \App\Models\Comment::whereBetween('created_at', [$start, $end])->count();
    }

    return view('admin.comments_chart', compact('months', 'commentCounts'));
}

public function photosChart()
{
    $months = collect(range(0, 5))->map(function ($i) {
        return Carbon::now()->subMonths($i)->format('F Y');
    })->reverse()->values();

    $photoCounts = [];

    foreach ($months as $month) {
        $start = Carbon::createFromFormat('F Y', $month)->startOfMonth();
        $end = Carbon::createFromFormat('F Y', $month)->endOfMonth();

        $photoCounts[] = Photo::whereBetween('created_at', [$start, $end])->count();
    }

    return view('admin.photos', compact('months', 'photoCounts'));
}

public function showUsers()
{
    // Ambil data pengguna
    $users = User::all();

    // Kirim data pengguna ke view admin.pengguna.blade.php
    return view('admin.pengguna.index', compact('users'));
}

public function editUser($id)
{
    // Mengambil data pengguna berdasarkan ID
    $user = User::findOrFail($id);  // Pastikan variabel $user ada dan tidak null

    // Kirim data pengguna ke view edit
    return view('admin.pengguna.edit', compact('user'));
}

public function updateUser(Request $request, $id)
{
    $request->validate([
        'name'  => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'role'  => 'required|in:admin,user',
    ]);

    $user = User::findOrFail($id);
    $user->update($request->only('name', 'email', 'role'));

    return redirect()->route('admin.pengguna.index')
                     ->with('success', 'Pengguna berhasil diperbarui.');
}

public function createPengguna()
{
    return view('admin.pengguna.create');
}

public function storePengguna(Request $request)
{
    $request->validate([
        'name'  => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'role'  => 'required|in:admin,user',
        'password' => 'required|string|min:6|confirmed',
    ]);

    User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'role'     => $request->role,
        'password' => bcrypt($request->password),
    ]);

    return redirect()->route('admin.pengguna.index')
                     ->with('success', 'Pengguna baru berhasil ditambahkan.');
}
}