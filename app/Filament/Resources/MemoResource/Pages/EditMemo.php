<?php

namespace App\Filament\Resources\MemoResource\Pages;

use App\Filament\Resources\MemoResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Actions\Action;
use App\Models\User;

class EditMemo extends EditRecord
{
    protected static string $resource = MemoResource::class;

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
                ->title('Memo Updated')
                ->body('Memo updated successfully')
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
            ->title('Memo update')
            ->body('The Memo: ' . $this->record->description . ' was updated by ' . $name)
            ->actions([
                Action::make('View File')
                    ->url(MemoResource::getUrl('view', ['record' => $this->record]))
                    ->button(),
            ])
            ->sendToDatabase($recipients);
    }

}
