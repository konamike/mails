<?php

namespace App\Filament\Resources\MemotreatResource\Pages;

use App\Filament\Resources\MemotreatResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditMemotreat extends EditRecord
{
    protected static string $resource = MemotreatResource::class;

    protected static ?string $title = 'Memo Processing';
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
            ->title('Memo Treated/Processed')
            ->body('The memo was updated successfully')
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
