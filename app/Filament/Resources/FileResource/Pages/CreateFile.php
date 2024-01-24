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
use App\Models\User;
use \Spatie\Permission\Traits\HasRoles;

class CreateFile extends CreateRecord
{
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
        $storedDataEmail = $this->record->email;
        $storedDataDescription = $this->record->description;


        $name = Auth::user()->name;
        $recipients = User::where('is_admin', '=', 1)->get();
        // $recipient = User::all();
        // $recipient = auth()->user()->is_admin()->toArray();
        // $storeDataID = $this->record->id;
        $storedDataDescription = $this->record->description;
        Notification::make()
            ->success()
            ->title('A New File Created')
            ->body('The File: ' . $this->record->description . ' was created by ' . $name)
            // ->actions([
            //     Action::make('View File')
            //         ->url(FileResource::getUrl('view', ['record' => $this->record]))
            //         ->button(),
            // ])
            ->sendToDatabase($recipients);



        Mail::to($storedDataEmail)->send(new DocumentReceivedMail($storedDataDescription));
    }
}
