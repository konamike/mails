<?php

namespace App\Filament\Resources\ContractorResource\Pages;

use App\Filament\Resources\ContractorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Kainiklas\FilamentScout\Traits\InteractsWithScout;

class ListContractors extends ListRecords
{
    use InteractsWithScout;
    protected static string $resource = ContractorResource::class;
    protected static ?string $title = ' ';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-briefcase')
                ->color('primary')
                ->iconPosition('after')
                ->label('New Contractor'),
        ];
    }
}
