<?php

namespace App\Filament\Resources\FiledispatchResource\Pages;

use App\Filament\Resources\FiledispatchResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewFiledispatch extends ViewRecord
{
    protected static string $resource = FiledispatchResource::class;
    protected static ?string $title = 'View File';

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
