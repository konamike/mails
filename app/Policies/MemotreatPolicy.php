<?php

namespace App\Policies;

use App\Models\Memotreat;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MemotreatPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['super-admin', 'admin', 'engineer']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Memotreat $memotreat): bool
    {
        return $user->hasAnyRole(['super-admin', 'admin', 'engineer']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['super-admin', 'admin', 'engineer']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Memotreat $memotreat): bool
    {
        return $user->hasAnyRole(['super-admin', 'admin', 'engineer']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Memotreat $memotreat): bool
    {
        return $user->hasAnyRole(['super-admin', 'admin']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Memotreat $memotreat): bool
    {
        return $user->hasAnyRole(['super-admin', 'admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Memotreat $memotreat): bool
    {
        return $user->hasAnyRole(['super-admin', 'admin']);
    }
}
