<?php

namespace App\Filament\Resources\LetterResource\Pages;

use App\Filament\Resources\LetterResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Actions\Action;
use App\Models\User;
class EditLetter extends EditRecord
{
    protected static string $resource = LetterResource::class;

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
                ->title('Letter Updated')
                ->body('Letter updated successfully')
                ->success()
                ->send();
    }

    protected function afterSave(): void
    {
        $name = Auth::user()->name;
        $recipient = auth()->user();
        $recipients = User::where('is_admin', '=', 1)->get();
            Notification::make()
            ->success()
            ->title('Letter update')
            ->body('The Letter: ' . $this->record->description . ' was updated by ' . $name)
            ->actions([
                Action::make('View File')
                    ->url(LetterResource::getUrl('view', ['record' => $this->record]))
                    ->button(),
            ])
            ->sendToDatabase($recipients);
    }
}
