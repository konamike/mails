<?php

namespace App\Filament\Resources\AllmemoResource\Pages;

use App\Filament\Resources\AllmemoResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAllmemo extends ViewRecord
{
    protected static string $resource = AllmemoResource::class;
    protected static ?string $title = 'Memo Details';

    protected function getHeaderActions(): array
    {
        return [
//            Actions\EditAction::make(),
        ];
    }
}
