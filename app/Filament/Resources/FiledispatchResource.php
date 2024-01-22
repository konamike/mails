<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FiledispatchResource\Pages;
use App\Filament\Resources\FiledispatchResource\RelationManagers;
use App\Models\Filedispatch;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FiledispatchResource extends Resource
{
    protected static ?string $model = Filedispatch::class;
    protected static ?string $navigationIcon = 'heroicon-o-film';
    protected static ?string $navigationGroup = 'Outgoing Documents';
    protected static ?string $navigationLabel = 'Files';
    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('dispatched', false)->where('treated', true)->count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'success';
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
                            ->label('File Description')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('sent_from')
                            ->default('MD/CEO')
                            ->label('Sent From')
                            ->placeholder('MD/CEO')
                            ->maxLength(30),
                        Forms\Components\TextInput::make('sent_to')
                            ->label('Sent To')
                            ->maxLength(255),
                        Forms\Components\Toggle::make('dispatched')
                            ->label('Ready for Dispatch?')
                            ->offIcon('heroicon-m-no-symbol')
                            ->offColor('danger')
                            ->onIcon('heroicon-m-check-badge')
                            ->inline(false)
                            ->required(),
                        // Forms\Components\DatePicker::make('date_dispatched')
                        //     ->label('Dispatched Date')
                        //     ->default(now())
                        //     ->required()
                        //     ->native(false),
                        Forms\Components\TextInput::make('dispatch_phone')
                            ->label('Dispatch Phone')
                            ->minLength(11)
                            ->maxLength(11),
                        // ->required(),
                        Forms\Components\TextInput::make('dispatch_email')
                            ->label('Dispatch Email')
                            ->helperText('Email to be used to deliver the dispatch message.')
                            ->email()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('dispatched_by')
                            ->label('Dispatched By/Hand Carried')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('dispatch_note')
                            ->label('Dispatch Remarks')
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
                    ->searchable()
                    ->wrap()
                    ->label('Mail Source'),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->searchable()
                    ->wrap(),
                Tables\Columns\IconColumn::make('treated')
                    ->boolean(),
                Tables\Columns\TextColumn::make('date_treated')
                    ->date()
                    ->label('Date Treated'),
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
            ->bulkActions([])
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
            'index' => Pages\ListFiledispatches::route('/'),
            //            'create' => Pages\CreateFiledispatch::route('/create'),
            'view' => Pages\ViewFiledispatch::route('/{record}'),
            'edit' => Pages\EditFiledispatch::route('/{record}/edit'),
        ];
    }
}
