<?php

namespace App\Filament\Resources\LettertreatResource\Pages;

use App\Filament\Resources\LettertreatResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditLettertreat extends EditRecord
{
    protected static string $resource = LettertreatResource::class;

    protected static ?string $title = 'Letter Processing';
    protected static bool $canCreateAnother = false;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['treated_by'] = auth()->id();
        return $data;
    }
    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Letter Treated/Processed')
            ->body('The letter was updated successfully')
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
            Actions\DeleteAction::make(),
        ];
    }
}
