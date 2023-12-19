<?php

namespace App\Observers;

use App\Models\Contractor;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Illuminate\Support\Facades\Auth;

class ContractorObserver
{
    /**
     * Handle the Contractor "created" event.
     */
    public function created(Contractor $contractor): void
    {
        Notification::make()
            ->warning()
            ->title('New Contractor Created')
            ->body('A new contractor has been created in the database')
            ->actions([
	            Action::make('View')
                    ->button()
                    ->url(route('filament.admin.resources.contractors.index')),
            ])
            ->sendToDatabase(\auth()->user());
    }

    /**
     * Handle the Contractor "updated" event.
     */
    public function updated(Contractor $contractor): void
    {
        Notification::make()
            ->warning()
            ->title('Contractor Updated')
            ->body('Contractor updated successfully')
            // ->actions([
	        //     Action::make('View')
            //         ->button()
            //         ->url(route('filament.admin.resources.contractors.index')),
            // ])
            ->sendToDatabase(\auth()->user());
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
