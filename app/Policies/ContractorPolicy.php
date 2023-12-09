<?php

namespace App\Policies;

use App\Models\Contractor;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ContractorPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['super-admin', 'admin', 'user']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Contractor $contractor): bool
    {
        return $user->hasAnyRole(['super-admin', 'admin', 'user']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['super-admin', 'admin', 'user']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Contractor $contractor): bool
    {
        return $user->hasAnyRole(['super-admin', 'admin', 'user']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Contractor $contractor): bool
    {
        return $user->hasAnyRole(['super-admin', 'admin']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Contractor $contractor): bool
    {
        return $user->hasAnyRole(['super-admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Contractor $contractor): bool
    {
        return $user->hasAnyRole(['super-admin']);
    }
}
