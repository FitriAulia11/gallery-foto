<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Photo;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function likePhoto($photoId)
    {
        $photo = Photo::findOrFail($photoId);
        $user = Auth::user();
    
        $existingLike = Like::where('photo_id', $photo->id)
                            ->where('user_id', $user->id)
                            ->first();
    
        if ($existingLike) {
            $existingLike->delete();
            $totalLikes = $photo->likes()->count(); // Perbaikan di sini
            return response()->json([
                'status' => 'unliked',
                'total_likes' => $totalLikes
            ]);
        } else {
            Like::create([
                'photo_id' => $photo->id,
                'user_id' => $user->id
            ]);
    
            $totalLikes = $photo->likes()->count(); // Perbaikan di sini
            return response()->json([
                'status' => 'liked',
                'total_likes' => $totalLikes
            ]);
        }
    }