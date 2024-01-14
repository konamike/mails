<?php

namespace App\Filament\Resources\LetterdispatchResource\Pages;

use App\Filament\Resources\LetterdispatchResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\DocumentSentMail;

class EditLetterdispatch extends EditRecord
{
    protected static string $resource = LetterdispatchResource::class;
    protected static ?string $title = 'Letter Dispatch';
    protected static bool $canCreateAnother = false;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['date_dispatched'] = now();
        return $data;
    }
    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Letter Processed')
            ->body('The letter processed for dispatch successful')
            ->duration(4000);
    }

    protected function afterSave(): void
    {
        // Runs after the form fields are saved to the database.
        $name = Auth::user()->name;
        $storedDataEmail = $this->record->dispatch_email;
        $storedDataDescription = $this->record->description;
        Mail::to($storedDataEmail)->send(new DocumentSentMail($storedDataDescription));
    }



    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            // Actions\ViewAction::make(),
//            Actions\DeleteAction::make(),
        ];
    }
}
