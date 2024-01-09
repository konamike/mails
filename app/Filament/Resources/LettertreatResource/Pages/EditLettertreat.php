<?php

namespace App\Filament\Resources\LettertreatResource\Pages;

use App\Filament\Resources\LettertreatResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Spatie\Permission\Traits\HasRoles;

class EditLettertreat extends EditRecord
{
    protected static string $resource = LettertreatResource::class;

    protected static ?string $title = 'Letter Processing';
    protected static bool $canCreateAnother = false;


    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Update the dispatch data if the user id COS
        if(auth()->user()->hasAnyRole('cos')){
        $data['dispatched'] = true;
        $data['dispatched_by'] = auth()->id();
        $data['date_dispatched'] = now();
        $data['sent_from'] = 'MD/CEO';
        $data['sent_to'] = 'MD/CEO';
        // $data['dispatch_phone'] = '';
        // $data['dispatch_email'] = 'MD/CEO';
        $data['dispatch_note'] = $data['treated_note'];
        $data['treated_by'] = auth()->id();
        }

        $data['treated_by'] = auth()->id();

        return $data;
    }
    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Letter Treated/Processed')
            ->body('The letter was updated successfully');
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
