<?php

namespace App\Filament\Resources\FileResource\Pages;

use App\Filament\Loggers\FileLogger;
use App\Filament\Resources\FileResource;
use App\Mail\DocumentReceivedMail;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Noxo\FilamentActivityLog\Extensions\LogCreateRecord;

class CreateFile extends CreateRecord
{
    use LogCreateRecord;
    protected static string $resource = FileResource::class;
    protected static ?string $title = 'New File';

    protected function mutateFormDataBeforeCreate(array $data): array
    {

        $data['user_id'] = auth()->id();
        $data['category_name'] = 'category.name';
        return $data;
    }

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
            ->title('File Created')
            ->body('The file was created successfully')
            ->duration(4000);
    }


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        // Runs after the form fields are saved to the database.
//        $delay = now()->addMinutes(10);
        $name = Auth::user()->name;
        $storedDataEmail = $this->record->email;
        $storeDataID = $this->record->id;
        $storedDataDescription = $this->record->description;
        if (!is_null($storedDataEmail ))
        {
            Mail::to($storedDataEmail) ->later(now()->addMinutes(10), new DocumentReceivedMail($storedDataDescription));
        }

    }

}
