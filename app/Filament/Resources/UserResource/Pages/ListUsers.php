<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;
    protected static ?string $title = 'All Users';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('New User')
            ->color('primary')
                ->iconPosition('after')
            ->icon('heroicon-o-users'),
        ];
    }
}
