<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FiletreatResource\Pages;
use App\Filament\Resources\FiletreatResource\RelationManagers;
use App\Models\Filetreat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FiletreatResource extends Resource
{
    protected static ?string $model = Filetreat::class;

    protected static ?string $navigationIcon = 'heroicon-s-film';
    protected static ?string $navigationGroup = 'Documents Under Review';
    protected static ?string $navigationLabel = 'Files';
    protected static ?int $navigationSort = 1;

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
                    ->label('Date Treated')
                    ->date()
                    ->native(false)
                    ->default(now())
                    ->required(),
                Forms\Components\Textarea::make('treated_notes')
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
                    ->searchable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('doc_author')
                    ->numeric()
                    ->sortable(),
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
                Tables\Actions\EditAction::make()
                ->label('Process')
                ->button(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
//
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
            'index' => Pages\ListFiletreats::route('/'),
//            'create' => Pages\CreateFiletreat::route('/create'),
            'edit' => Pages\EditFiletreat::route('/{record}/edit'),
        ];
    }
}
