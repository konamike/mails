<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\LetterResource;
use Filament\Widgets\TableWidget as BaseWidget;
use Spatie\Permission\Traits\HasRoles;

class LatestLetters extends BaseWidget
{
    protected static ?int $sort = 2;
    // protected int|string|array $columnSpan = 3;
    // protected int|string|array $columnStart = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(LetterResource::getEloquentQuery()->limit(5))
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
        return auth()->user()->hasAnyRole('user', 'engineer', 'frontdesk');
    }
}
