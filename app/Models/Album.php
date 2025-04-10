<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;
    
    protected $table = 'albums'; // Sesuaikan dengan nama tabel di database
    protected $fillable = ['name', 'description']; // Pastikan sesuai dengan kolom di tabel

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
}
