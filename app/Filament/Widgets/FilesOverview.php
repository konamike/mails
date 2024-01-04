<?php

namespace App\Filament\Widgets;

use App\Models\File;

use App\Models\Letter;

use App\Models\Memo;


use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Spatie\Permission\Traits\HasRoles;

class FilesOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected function getColumns(): int
    {
        return 4;
    }
    protected function getStats(): array
    {
        return [
            Stat::make('Files Received', File::count())
                ->description('Total Files received')
                ->icon('heroicon-s-academic-cap')
                ->color('primary'),
            Stat::make('File Being Processed',File::where('treated','=',0)->count())
                ->description('Total files being processed')
                ->icon('heroicon-s-academic-cap')
                ->color('warning'),
            Stat::make('Files Treated',File::where('treated', '=', 1)->count())
                ->description('Total Treated Files')
                ->icon('heroicon-s-academic-cap')
                ->color('success'),
            Stat::make('Files Dispatched',File::where('dispatched', '=', 1)->count())
                ->description('Total Files dispatched')
                ->icon('heroicon-s-academic-cap')
                ->color('info'),
            Stat::make('Letters Received', Letter::count())
                ->description('Total Letters received')
                ->icon('heroicon-s-envelope')
                ->color('primary'),
            Stat::make('Letters Being Processed',Letter::where('treated','=',0)->count())
                ->icon('heroicon-s-envelope')
                ->description('Total letters being processed')
                ->color('warning'),
            Stat::make('Letters Treated',Letter::where('treated', '=', 1)->count())
                ->description('Total letters treated')
                ->icon('heroicon-s-envelope')
                ->color('success'),
            Stat::make('Letters Dispatched',Letter::where('dispatched', '=', 1)->count())
                ->description('Total Letters dispatched')
                ->icon('heroicon-s-envelope')
                ->color('info'),
            Stat::make('Memos Received', Memo::count())
                ->description('Total memos received')
                ->icon('heroicon-s-chevron-double-down')
                ->color('primary'),
            Stat::make('Memos Being Processed',Memo::where('treated','=',0)->count())
                ->description('Total memos being processed')
                ->icon('heroicon-s-chevron-double-down')
                ->color('warning'),
            Stat::make('Memos Treated',Memo::where('treated', '=', 1)->count())
                ->description('Total memos treated')
                ->icon('heroicon-s-chevron-double-down')
                ->color('success'),
            Stat::make('Memos Dispatched',Memo::where('dispatched', '=', 1)->count())
                ->description('Total memos dispatched')
                ->icon('heroicon-s-chevron-double-down')
                ->color('info'),
        ];
    }

    public static function canView(): bool
    {
        // return auth()->user()->is_admin;
        return auth()->user()->hasAnyRole('md', 'admin', 'super-admin', 'hsd', 'cos');
    }

}
