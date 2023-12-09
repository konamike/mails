<?php

namespace App\Filament\Resources\MemodispatchResource\Pages;

use App\Filament\Resources\MemodispatchResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMemodispatches extends ListRecords
{
    protected static string $resource = MemodispatchResource::class;
    protected static ?string $title = 'Memos for Dispatch';

    protected function getHeaderActions(): array
    {
        return [
//            Actions\CreateAction::make(),
        ];
    }
}
