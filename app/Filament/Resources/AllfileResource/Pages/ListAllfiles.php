<?php

namespace App\Filament\Resources\AllfileResource\Pages;

use App\Filament\Resources\AllfileResource;
use App\Models\Allfile;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListAllfiles extends ListRecords
{
    protected static ?string $title = '';
    protected static string $resource = AllfileResource::class;

    public static function canView(): bool
    {
        return auth()->user()->is_admin;
        // return auth()->user()->hasAnyRole('admin');
    }


    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Files'),
            'This Year' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('date_received', '>=', now()->subYear()))
                ->badge(Allfile::query()->where('date_received', '>=', now()->subYear())->count()),
            'This Month' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('date_received', '>=', now()->subMonth()))
                ->badge(Allfile::query()->where('date_received', '>=', now()->subMonth())->count()),
            'This Week' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('date_received', '>=', now()->subWeek()))
                ->badge(Allfile::query()->where('date_received', '>=', now()->subWeek())->count()),
            'Today' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('date_received', '>=', now()->subDay()))
                ->badge(Allfile::query()->where('date_received', '>=', now()->subDay())->count()),
        ];
    }


    public function getDefaultActiveTab(): string|int|null
    {
        return 'all';
    }
}
