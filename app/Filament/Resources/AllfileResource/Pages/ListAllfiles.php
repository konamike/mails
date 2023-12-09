<?php

namespace App\Filament\Resources\AllfileResource\Pages;

use App\Filament\Resources\AllfileResource;
use App\Models\File;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListAllfiles extends ListRecords
{
    protected static ?string $title = ' All Files';
    protected static string $resource = AllfileResource::class;


    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Files'),
            'This Year' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('date_received', '>=', now()->subYear()))
                ->badge(File::query()->where('date_received', '>=', now()->subYear())->count()),
            'This Month' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('date_received', '>=', now()->subMonth()))
                ->badge(File::query()->where('date_received', '>=', now()->subMonth())->count()),
            'This Week' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('date_received', '>=', now()->subWeek()))
                ->badge(File::query()->where('date_received', '>=', now()->subWeek())->count()),
        ];
    }


    public function getDefaultActiveTab(): string|int|null
    {
        return 'all';
    }

    public function getAllTableRecordsCount(): int
    {
    }

}
