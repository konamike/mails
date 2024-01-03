<?php

namespace App\Filament\Resources\ContractorResource\Pages;

use App\Filament\Resources\ContractorResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Filament\Actions\Action;

class CreateContractor extends CreateRecord
{
    protected static string $resource = ContractorResource::class;
    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {

        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Contractor Created')
            ->body('New Contractor created successfully.');
    }

    protected function afterCreate(): void
    {
        $storedDataEmail = $this->record->email;
        $storedDataDescription = $this->record->description;


        $name = Auth::user()->name;
        $recipient = \auth()->user();
        $recipients = User::where('is_admin', '=', 1)->get();
        $storedDataDescription = $this->record->name;
        Notification::make()
        ->info()
        ->title('A New Contractor Created')
        ->body('New Contractor : ' . $this->record->name . ' was created by ' . $name)
            ->sendToDatabase($recipients);
    }
}
