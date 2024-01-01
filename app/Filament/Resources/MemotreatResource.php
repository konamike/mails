<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MemotreatResource\Pages;
use App\Filament\Resources\MemotreatResource\RelationManagers;
use App\Models\Memotreat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MemotreatResource extends Resource
{
    protected static ?string $model = Memotreat::class;

    protected static ?string $navigationIcon = 'heroicon-s-chevron-double-down';

    protected static ?string $navigationGroup = 'Documents In-Process';
    protected static ?string $navigationLabel = 'Memos';
    protected static ?int $navigationSort = 3;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('treated', false)->count();
    }

    public static function getEloquentQuery(): Builder
    {
        return static::getModel()::query()
            ->where('treated', false);
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->readOnly()
                            ->disabled(true)
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('treated')
                            ->label('Treated?')
                            ->offIcon('heroicon-m-no-symbol')
                            ->offColor('danger')
                            ->onIcon('heroicon-m-check-badge')
                            ->inline(true)
                            ->required(),
                        Forms\Components\DatePicker::make('date_treated')
                            ->native(false)
                            ->required(),
                        Forms\Components\Textarea::make('treated_note')
                            ->label('Note for MD/CEO')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                    ])


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date_received')
                    ->date()
                    ->label('Date Received')
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->wrap()
                    ->searchable(),
                Tables\Columns\TextColumn::make('doc_author')
                    ->label('Document Author')
                    ->limit(40),
                Tables\Columns\IconColumn::make('treated')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
//                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                ->label('Process')
                ->button(),
            ])
            ->bulkActions([
//
            ])
            ->emptyStateActions([
//                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMemotreats::route('/'),
            'create' => Pages\CreateMemotreat::route('/create'),
            'view' => Pages\ViewMemotreat::route('/{record}'),
            'edit' => Pages\EditMemotreat::route('/{record}/edit'),
        ];
    }
}
