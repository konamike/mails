<?php

namespace App\Filament\Resources\AllletterResource\Pages;

use App\Filament\Resources\AllletterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAllletter extends EditRecord
{
    protected static string $resource = AllletterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
