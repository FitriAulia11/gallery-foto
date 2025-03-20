<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like($id)
    {
        $photo = Photo::findOrFail($id);

        // Cek apakah user sudah like sebelumnya
        $existingLike = Like::where('user_id', Auth::id())
                            ->where('photo_id', $photo->id)
                            ->first();

        if ($existingLike) {
            // Jika sudah like, maka unlike (hapus like)
            $existingLike->delete();
            return back()->with('success', 'Anda membatalkan like foto ini.');
        }

        // Jika belum, tambahkan like ke database
        Like::create([
            'user_id' => Auth::id(),
            'photo_id' => $photo->id,
        ]);

        return back()->with('success', 'Foto berhasil disukai.');
    }
}
