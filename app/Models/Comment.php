<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','photo_id', 'content'];

    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }
}
