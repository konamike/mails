<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LettertreatResource\Pages;
use App\Filament\Resources\LettertreatResource\RelationManagers;
use App\Models\Lettertreat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LettertreatResource extends Resource
{
    protected static ?string $model = Lettertreat::class;

    protected static ?string $navigationIcon = 'heroicon-s-envelope';
    protected static ?string $navigationGroup = 'Documents Under Review';
    protected static ?string $navigationLabel = 'Letters';
    protected static ?int $navigationSort = 2;

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
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->wrap()
                    ->sortable(),
                Tables\Columns\TextColumn::make('doc_author')
                    ->label('Document Author')
                    ->wrap()
                    ->searchable(),
                Tables\Columns\IconColumn::make('treated')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
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
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListLettertreats::route('/'),
//            'create' => Pages\CreateLettertreat::route('/create'),
            'view' => Pages\ViewLettertreat::route('/{record}'),
            'edit' => Pages\EditLettertreat::route('/{record}/edit'),
        ];
    }
}
