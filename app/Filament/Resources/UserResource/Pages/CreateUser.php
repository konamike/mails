<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static bool $canCreateAnother = false;
    protected static string $resource = UserResource::class;
    protected function getRedirectUrl(): string
    {
        Notification::make()
            ->success()
            ->title('Created successful')
            ->body('User successfully created');

        return $this->getResource()::getUrl('index'); // Return to index page after creation of resource
    }
}
