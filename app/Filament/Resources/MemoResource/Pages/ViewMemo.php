<?php

namespace App\Filament\Resources\MemoResource\Pages;

use App\Filament\Resources\MemoResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMemo extends ViewRecord
{
    protected static string $resource = MemoResource::class;
    protected static ?string $title = 'Details';

    protected function getHeaderActions(): array
    {
        return [
//            Actions\EditAction::make(),
        ];
    }
}
