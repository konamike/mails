<?php

namespace App\Filament\Resources\MemodispatchResource\Pages;

use App\Filament\Resources\MemodispatchResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\DocumentSentMail;
use Filament\Resources\Pages\EditRecord;

class EditMemodispatch extends EditRecord
{
    protected static string $resource = MemodispatchResource::class;

    protected static ?string $title = 'Memo Dispatch';
    protected static bool $canCreateAnother = false;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['dispatched_by'] = auth()->id();
        return $data;
    }
    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Memo Processed')
            ->body('The memo processed for dispatch successful')
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
            Actions\ViewAction::make(),
//            Actions\DeleteAction::make(),
        ];
    }
}
