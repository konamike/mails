<?php

namespace App\Filament\Resources\AllletterResource\Pages;

use App\Filament\Resources\AllletterResource;
use App\Models\Allletter;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListAllletters extends ListRecords
{
    protected static string $resource = AllletterResource::class;
    protected static ?string $title = ' All Letters';

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Letter'),
            'This Year' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('date_received', '>=', now()->subYear()))
                ->badge(Allletter::query()->where('date_received', '>=', now()->subYear())->count()),
            'This Month' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('date_received', '>=', now()->subMonth()))
                ->badge(Allletter::query()->where('date_received', '>=', now()->subMonth())->count()),
            'This Week' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('date_received', '>=', now()->subWeek()))
                ->badge(Allletter::query()->where('date_received', '>=', now()->subWeek())->count()),
        ];
    }

    public function getDefaultActiveTab(): string|int|null
    {
        return 'all';
    }

}
