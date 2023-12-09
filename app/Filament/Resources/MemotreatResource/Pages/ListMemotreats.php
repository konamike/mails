<?php

namespace App\Filament\Resources\MemotreatResource\Pages;

use App\Filament\Resources\MemotreatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMemotreats extends ListRecords
{
    protected static string $resource = MemotreatResource::class;
    protected static ?string $title = 'Memo Under Process';

    protected function getHeaderActions(): array
    {
        return [
//            Actions\CreateAction::make(),
        ];
    }
}
