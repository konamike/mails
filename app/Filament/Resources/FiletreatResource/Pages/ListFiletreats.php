<?php

namespace App\Filament\Resources\FiletreatResource\Pages;

use App\Filament\Resources\FiletreatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFiletreats extends ListRecords
{
    protected static string $resource = FiletreatResource::class;
    protected static ?string $title = 'Files In Process';

    protected function getHeaderActions(): array
    {
        return [
//            Actions\CreateAction::make(),
        ];
    }
}
