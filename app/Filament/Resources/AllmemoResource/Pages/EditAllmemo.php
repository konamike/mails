<?php

namespace App\Filament\Resources\AllmemoResource\Pages;

use App\Filament\Resources\AllmemoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAllmemo extends EditRecord
{
    protected static string $resource = AllmemoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
