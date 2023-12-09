<?php

namespace App\Filament\Resources\LetterdispatchResource\Pages;

use App\Filament\Resources\LetterdispatchResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditLetterdispatch extends EditRecord
{
    protected static string $resource = LetterdispatchResource::class;
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
            ->title('Letter Processed')
            ->body('The letter processed for dispatch successful')
            ->duration(4000);
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
