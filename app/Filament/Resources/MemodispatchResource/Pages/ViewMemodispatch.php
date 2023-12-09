<?php

namespace App\Filament\Resources\MemodispatchResource\Pages;

use App\Filament\Resources\MemodispatchResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMemodispatch extends ViewRecord
{
    protected static string $resource = MemodispatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
