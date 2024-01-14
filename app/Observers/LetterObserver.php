<?php

namespace App\Observers;

use App\Models\Letter;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Illuminate\Support\Facades\Auth;

class LetterObserver
{
    /**
     * Handle the Letter "created" event.
     */
    public function created(Letter $letter): void
    {
        // Notification::make()
        //     ->warning()
        //     ->title('New File Created')
        //     ->body('A new letter has been created in the database')
        //     ->actions([
	    //         Action::make('View')
        //             ->button()
        //             ->url(route('filament.admin.resources.letters.index')),
        //     ])
        //     ->sendToDatabase(\auth()->user());
    }

    /**
     * Handle the Letter "updated" event.
     */
    public function updated(Letter $letter): void
    {
        // Notification::make()
        //     ->warning()
        //     ->title('Letter Updated')
        //     ->body('Letter has been successfully updated.')
        //     ->actions([
	    //         Action::make('View')
        //             ->button()
        //             ->url(route('filament.admin.resources.letters.index')),
        //     ])
        //     ->sendToDatabase(\auth()->user());
    }

    /**
     * Handle the Letter "deleted" event.
     */
    public function deleted(Letter $letter): void
    {
        //
    }

    /**
     * Handle the Letter "restored" event.
     */
    public function restored(Letter $letter): void
    {
        //
    }

    /**
     * Handle the Letter "force deleted" event.
     */
    public function forceDeleted(Letter $letter): void
    {
        //
    }
}
