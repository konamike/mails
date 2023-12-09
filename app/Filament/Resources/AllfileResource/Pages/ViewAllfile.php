<?php

namespace App\Filament\Resources\AllfileResource\Pages;

use App\Filament\Resources\AllfileResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAllfile extends ViewRecord
{
    protected static string $resource = AllfileResource::class;
    protected static ?string $title = 'File Details';

    protected function getHeaderActions(): array
    {
        return [
//            Actions\EditAction::make(),
        ];
    }
}
