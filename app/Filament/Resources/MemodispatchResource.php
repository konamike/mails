<?php /** @noinspection ALL */

namespace App\Filament\Resources;

use App\Filament\Resources\MemodispatchResource\Pages;
use App\Filament\Resources\MemodispatchResource\RelationManagers;
use App\Models\Memodispatch;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MemodispatchResource extends Resource
{
    protected static ?string $model = Memodispatch::class;
    protected static ?string $navigationIcon = 'heroicon-s-chevron-double-down';
    protected static ?string $navigationGroup = 'Outgoing Documents';
    protected static ?string $navigationLabel = 'Memos';
    protected static ?int $navigationSort = 3;


    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('dispatched', false)->where('treated', true)->count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'info';
    }

    public static function getEloquentQuery(): Builder
    {
        return static::getModel()::query()
            ->where('treated', true)
            ->where('dispatched', false);
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->readOnly()
                            ->disabled()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('sent_from')
                            ->default('MD/CEO')
                            ->placeholder('MD/CEO')
                            ->maxLength(30),
                        Forms\Components\TextInput::make('sent_to')
                            ->maxLength(255),
                        Forms\Components\Toggle::make('dispatched')
                            ->label('Ready for Dispatch?')
                            ->offIcon('heroicon-m-no-symbol')
                            ->offColor('danger')
                            ->onIcon('heroicon-m-check-badge')
                            ->inline(false)
                            ->required(),
                        Forms\Components\TextInput::make('dispatch_phone')
                            ->minLength(11)
                            ->maxLength(11)
                            ->required(),
                        Forms\Components\TextInput::make('dispatch_email')
                            ->email()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('dispatched_by')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('dispatch_note')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('contractor.name')
                    ->label('Mail Source')
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->wrap(),
                Tables\Columns\IconColumn::make('treated')
                    ->boolean(),
                Tables\Columns\TextColumn::make('date_treated')
                    ->date()
                    ->label('Date Treated')
                    ->sortable(),
                Tables\Columns\IconColumn::make('dispatched')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
//                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                ->label('Process Dispatch')
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
            'index' => Pages\ListMemodispatches::route('/'),
//            'create' => Pages\CreateMemodispatch::route('/create'),
            'view' => Pages\ViewMemodispatch::route('/{record}'),
            'edit' => Pages\EditMemodispatch::route('/{record}/edit'),
        ];
    }
}
