<?php

namespace App\Filament\Resources\AllfileResource\Pages;

use App\Filament\Resources\AllfileResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAllfile extends EditRecord
{
    protected static string $resource = AllfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
