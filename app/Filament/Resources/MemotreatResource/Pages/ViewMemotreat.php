<?php

namespace App\Filament\Resources\MemotreatResource\Pages;

use App\Filament\Resources\MemotreatResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMemotreat extends ViewRecord
{
    protected static string $resource = MemotreatResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            Actions\EditAction::make(),
        ];
    }
}
