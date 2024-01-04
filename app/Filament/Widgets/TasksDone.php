<?php

namespace App\Filament\Widgets;

use App\Models\File;

use App\Models\Letter;

use App\Models\Memo;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Week;
use Spatie\Permission\Traits\HasRoles;

class TasksDone extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getColumns(): int
    {
        return 3;
    }

    protected function getStats(): array
    {
        $now = Carbon::now();
        return [
            Stat::make('Files Received Today', File::where('created_at', '=', today())->count())
                ->color('primary'),
            Stat::make('Files Received This Month', File::whereMonth('created_at', Carbon::parse($now->month)->format('Y-m'))->count())
                ->color('warning'),
            Stat::make('Files Received This Year', File::where('created_at', '=', today())->count())
                ->color('success'),


            Stat::make('Letters Received', Letter::count())
                ->description('Total Letters received')
                ->icon('heroicon-s-envelope')
                ->color('primary'),
            Stat::make('Letters Being Processed', Letter::where('treated', '=', 0)->count())
                ->icon('heroicon-s-envelope')
                ->description('Total letters being processed')
                ->color('warning'),
            Stat::make('Letters Treated', Letter::where('treated', '=', 1)->count())
                ->description('Total letters treated')
                ->icon('heroicon-s-envelope')
                ->color('success'),

            Stat::make('Memos Received', Memo::count())
                ->description('Total memos received')
                ->icon('heroicon-s-chevron-double-down')
                ->color('primary'),
            Stat::make('Memos Being Processed', Memo::where('treated', '=', 0)->count())
                ->description('Total memos being processed')
                ->icon('heroicon-s-chevron-double-down')
                ->color('warning'),
            Stat::make('Memos Treated', Memo::where('treated', '=', 1)->count())
                ->description('Total memos treated')
                ->icon('heroicon-s-chevron-double-down')
                ->color('success'),

        ];
    }

    public static function canView(): bool
    {
        // return auth()->user()->is_admin;
        return auth()->user()->hasAnyRole('user');
    }
}
