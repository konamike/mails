<?php

namespace App\Filament\Resources\FiletreatResource\Pages;

use App\Filament\Resources\FiletreatResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditFiletreat extends EditRecord
{
    protected static string $resource = FiletreatResource::class;

    protected static ?string $title = 'File Processing';
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
            ->title('File Treated/Processed')
            ->body('The file was updated successfully')
            ->duration(4000);
    }



    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
//            Actions\DeleteAction::make(),
        ];
    }
}
