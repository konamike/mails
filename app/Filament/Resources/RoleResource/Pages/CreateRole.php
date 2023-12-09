<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateRole extends CreateRecord
{
    protected static string $resource = RoleResource::class;

    protected static bool $canCreateAnother = false;
    protected function getRedirectUrl(): string
    {
        Notification::make()
            ->success()
            ->title('Role created')
            ->body('New Role successfully created');

        return $this->getResource()::getUrl('index'); // Return to index page after creation of resource
    }
}
