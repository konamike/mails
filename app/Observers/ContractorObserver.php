<?php

namespace App\Observers;

use App\Models\Contractor;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class ContractorObserver
{
    /**
     * Handle the Contractor "created" event.
     */
    public function created(Contractor $contractor): void
    {
//
    }

    /**
     * Handle the Contractor "updated" event.
     */
    public function updated(Contractor $contractor): void
    {
//
    }

    /**
     * Handle the Contractor "deleted" event.
     */
    public function deleted(Contractor $contractor): void
    {
        //
    }

    /**
     * Handle the Contractor "restored" event.
     */
    public function restored(Contractor $contractor): void
    {
        //
    }

    /**
     * Handle the Contractor "force deleted" event.
     */
    public function forceDeleted(Contractor $contractor): void
    {
        //
    }
}
