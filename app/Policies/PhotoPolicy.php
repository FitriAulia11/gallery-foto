<?php

namespace App\Policies;

use App\Models\Photo;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PhotoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
{
    return true; // Semua pengguna bisa melihat foto
}

public function create(User $user)
{
    return true; // Semua pengguna bisa menambah foto
}

}
