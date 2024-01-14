<?php

namespace App\Filament\Resources\FiledispatchResource\Pages;

use App\Filament\Resources\FiledispatchResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFiledispatches extends ListRecords
{
    protected static string $resource = FiledispatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            Actions\CreateAction::make(),
        ];
    }

    // public static ?string $title = 'Files for Dispatch';
    protected static ?string $title = ' ';
}
