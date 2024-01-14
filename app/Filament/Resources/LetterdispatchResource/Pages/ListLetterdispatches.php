<?php

namespace App\Filament\Resources\LetterdispatchResource\Pages;

use App\Filament\Resources\LetterdispatchResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLetterdispatches extends ListRecords
{
    protected static string $resource = LetterdispatchResource::class;
    // protected static ?string $title = 'Letters for Dispatch';

    protected static ?string $title = ' ';

    protected function getHeaderActions(): array
    {
        return [
//            Actions\CreateAction::make(),
        ];
    }
}
