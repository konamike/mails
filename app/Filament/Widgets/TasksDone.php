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
        return 4;
    }

protected function getStats(): array
{
     $now = Carbon::now();
    return [
        Stat::make('Files Received Today', File::where('created_at', '=', today())->count()),
        Stat::make('Files Received This Week', File::where('created_at', '>=', now()->subWeek())->count()),
        Stat::make('Files Received This Month', File::where('created_at', '>=', now()->subMonth())->count()),
        Stat::make('Files Received This Year', File::where('created_at', '>=', now()->subYear())->count()),

        Stat::make('Letters Received Today', Letter::where('created_at', '=', today())->count()),
        Stat::make('Letters Received This Week', Letter::where('created_at', '>=', now()->subWeek())->count()),
        Stat::make('Letters Received This Month', Letter::where('created_at', '>=', now()->subMonth())->count()),
        Stat::make('Letters Received This Year', Letter::where('created_at', '>=', now()->subYear())->count()),

        Stat::make('Memos Received Today', Memo::where('created_at', '=', today())->count()),
        Stat::make('Memos Received This Week', Memo::where('created_at', '>=', now()->subWeek())->count()),
        Stat::make('Memos Received This Month', Memo::where('created_at', '>=', now()->subMonth())->count()),
        Stat::make('Memos Received This Year', Memo::where('created_at', '>=', now()->subYear())->count()),

    ];
}

public static function canView(): bool
{
    // return auth()->user()->is_admin;
    return auth()->user()->hasAnyRole('user', 'engineer');
}
}
