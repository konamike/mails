<?php

namespace App\Filament\Resources\LetterResource\Pages;

use App\Filament\Resources\LetterResource;
use App\Mail\DocumentReceivedMail;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Constraint\IsNull;

class CreateLetter extends CreateRecord
{
    protected static string $resource = LetterResource::class;


    protected function getCreateFormAction(): Action
    {
        return Action::make('create')
            ->label('Submit')
            ->submit('create')
            ->keyBindings(['mod+s']);
    }


    protected static bool $canCreateAnother = false;
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Letter Created')
            ->body('The letter was created successfully')
            ->duration(4000);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {

        $data['user_id'] = auth()->id();
//        $data['category_name'] = 'category.name';
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        // Runs after the form fields are saved to the database.
        $name = Auth::user()->name;
        $storedDataEmail = $this->record->email;
        $storeDataID = $this->record->id;
        $storedDataDescription = $this->record->description;
        if (!is_null($storedDataEmail ))
        {
            Mail::to($storedDataEmail)->later(now()->addMinutes(10), new DocumentReceivedMail($storedDataDescription));
        }
    }


}
