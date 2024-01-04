<?php

namespace App\Policies;


use App\Models\User;
use RickDBCN\FilamentEmail\Models\Email;
use Illuminate\Auth\Access\Response;

class EmailPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['super-admin', 'admin']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Email $email): bool
    {
        return $user->hasAnyRole(['super-admin', 'admin']);
    }

}
