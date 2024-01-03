<?php

namespace App\Filament\Resources\FileResource\Pages;

use App\Filament\Loggers\FileLogger;
use App\Filament\Resources\FiledispatchResource;
use App\Filament\Resources\FileResource;
use App\Models\File;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Actions\Action;
use \Spatie\Permission\Traits\HasRoles;

class EditFile extends EditRecord
{
    protected static string $resource = FileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\ViewAction::make(),
            // Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
       protected function getSavedNotification(): ?Notification
       {

           return
               Notification::make()
                   ->success()
                   ->title('File Update.')
                   ->duration(4000)
                   ->body('File successfully updated!');
       }

    protected function afterSave(): void
    {
        $name = Auth::user()->name;
        $recipient = auth()->user();
        $recipients = User::where('is_admin', '=', 1)->get();
            Notification::make()
            ->success()
            ->title('File update')
            ->body('The File: ' . $this->record->description . ' was updated by ' . $name)
            ->actions([
                Action::make('View File')
                    ->url(FileResource::getUrl('view', ['record' => $this->record]))
                    ->button(),
            ])
            ->sendToDatabase($recipients);
    }
}
