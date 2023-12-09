<?php

namespace App\Policies;

use App\Models\Allfile;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AllfilePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['super-admin', 'md', 'hsd', 'cos', 'engineer', 'frontdesk']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Allfile $allfile): bool
    {
        return $user->hasAnyRole(['super-admin', 'md', 'hsd', 'cos', 'engineer']);
    }



}
