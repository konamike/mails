<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\FileResource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;

use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\TableWidget as BaseWidget;
use Spatie\Permission\Traits\HasRoles;

class LatestFiles extends BaseWidget
{
    protected static ?int $sort = 2;
    // protected int|string|array $columnSpan = 3;
    // protected int|string|array $columnStart = 1;


    public function table(Table $table): Table
    {
        return $table
            ->query(FileResource::getEloquentQuery()->limit(5))
            ->paginated(false)
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date Created')
                    ->date(),
                Tables\Columns\TextColumn::make('date_received')
                    ->label('Date Received')
                    ->date(),

                Tables\Columns\TextColumn::make('description')
                ->limit(50)
                    ->wrap(),
            ]);
    }


    public static function canView(): bool
{
    return auth()->user()->hasAnyRole('user', 'engineer');
}
}
