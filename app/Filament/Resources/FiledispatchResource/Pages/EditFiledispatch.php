<?php

namespace App\Filament\Resources\FiledispatchResource\Pages;

use App\Filament\Resources\FiledispatchResource;
use App\Mail\DocumentSentMail;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EditFiledispatch extends EditRecord
{
    protected static string $resource = FiledispatchResource::class;
    protected static ?string $title = 'Dispatch File';
    protected function getHeaderActions(): array
    {
        return [
            // Actions\ViewAction::make(),
        ];
    }

    protected static bool $canCreateAnother = false;
    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('File Dispatched')
            ->body('The file was scheduled for dispatch successfully')
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

}
