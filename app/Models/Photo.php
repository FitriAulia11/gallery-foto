<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use App\Models\Like;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image_path',
         'category_id',
        'file_path',
        'user_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class); // jika ada fitur komentar
    }

    
    public function likedByUser()
{
    return $this->likes()->where('user_id', auth()->id())->exists();
}

// app/Models/Photo.php
public function category()
{
    return $this->belongsTo(Category::class);
}
}