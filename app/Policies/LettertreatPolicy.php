<?php

namespace App\Policies;

use App\Models\Lettertreat;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LettertreatPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['super-admin', 'admin', 'cos', 'engineer']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Lettertreat $lettertreat): bool
    {
        return $user->hasAnyRole(['super-admin', 'admin', 'cos', 'engineer']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['super-admin', 'admin', 'cos', 'engineer']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Lettertreat $lettertreat): bool
    {
        return $user->hasAnyRole(['super-admin', 'admin', 'cos', 'engineer']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Lettertreat $lettertreat): bool
    {
        return $user->hasAnyRole(['super-admin', 'admin']);

            }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Lettertreat $lettertreat): bool
    {
        return $user->hasAnyRole(['super-admin', 'admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Lettertreat $lettertreat): bool
    {
        return $user->hasAnyRole(['super-admin', 'admin']);
    }
}
