<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        // Ambil semua foto yang diunggah, urutkan berdasarkan tanggal dibuat terbaru
        $photos = Photo::orderBy('created_at', 'desc')->get();

        // Tampilkan halaman galeri
        return view('gallery.index', compact('photos'));
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');

        // Cari foto berdasarkan caption atau tags, urutkan berdasarkan tanggal dibuat terbaru
        $photos = Photo::where('caption', 'like', '%' . $searchTerm . '%')
            ->orWhere('tags', 'like', '%' . $searchTerm . '%')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('gallery.index', compact('photos'));
    }


    public function update(Request $request, $id)
    {
        // Cari foto yang ingin diubah
        $photo = Photo::findOrFail($id);
    
        // Validasi dan update data foto
        $photo->update([
            'caption' => $request->caption,
            'tags' => $request->tags,
            // Tambahkan data lain sesuai kebutuhan
        ]);
    
        // Redirect kembali ke halaman gallery setelah update berhasil
        return redirect()->route('gallery.index')->with('success', 'Foto berhasil diperbarui!');
    }
    
    public function edit($id)
    {
        $photo = Photo::findOrFail($id);
    
        // Pastikan admin atau pemilik foto yang bisa mengedit
        if (auth()->user()->is_admin || auth()->id() === $photo->user_id) {
            return view('gallery.edit', compact('photo'));
        }
    
        // Jika bukan admin atau pemilik foto, redirect
        return redirect()->route('gallery.index')->with('error', 'Anda tidak memiliki hak akses untuk mengedit foto ini.');
    }
    
    public function destroy($id)
    {
        // Cari foto yang ingin dihapus
        $photo = Photo::findOrFail($id);
    
        // Hapus foto
        $photo->delete();
    
        // Redirect kembali ke halaman gallery setelah foto dihapus
        return redirect()->route('gallery.index')->with('success', 'Foto berhasil dihapus!');
    }
        
    
}
