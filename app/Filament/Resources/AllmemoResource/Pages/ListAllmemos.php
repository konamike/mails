<?php

namespace App\Filament\Resources\AllmemoResource\Pages;

use App\Filament\Resources\AllmemoResource;
use App\Models\Allmemo;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListAllmemos extends ListRecords
{
    protected static string $resource = AllmemoResource::class;
    protected static ?string $title = '';

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Memos'),
            'This Year' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('date_received', '>=', now()->subYear()))
                ->badge(Allmemo::query()->where('date_received', '>=', now()->subYear())->count()),
            'This Month' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('date_received', '>=', now()->subMonth()))
                ->badge(Allmemo::query()->where('date_received', '>=', now()->subMonth())->count()),
            'This Week' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('date_received', '>=', now()->subWeek()))
                ->badge(Allmemo::query()->where('date_received', '>=', now()->subWeek())->count()),
            'Today' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('date_received', '>=', now()->subDay()))
                ->badge(Allmemo::query()->where('date_received', '>=', now()->subDay())->count()),
        ];
    }

    public function getDefaultActiveTab(): string|int|null
    {
        return 'all';
    }
}
