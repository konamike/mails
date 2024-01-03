<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MemoResource\Pages;
use App\Filament\Resources\MemoResource\RelationManagers;
use App\Models\Category;
use App\Models\Memo;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;


class MemoResource extends Resource
{
    protected static ?string $model = Memo::class;
    protected static ?string $navigationIcon = 'heroicon-s-chevron-double-down';
    protected static ?string $navigationGroup = 'Incoming Documents';
    protected static ?string $navigationLabel = 'Memo';
    protected static ?int $navigationSort = 3;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('treated', 'false')->count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'success';
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

                Fieldset::make('PRIMARY INFORMATION')
                ->schema([

                    Forms\Components\Textarea::make('description')
                    ->required()
                    ->label('File Description')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Select::make('contractor_id')
                    ->label('Mail Source')
                    ->relationship('contractor', 'name')
                    ->searchable()
                    ->preload()
                    ->native(false)
                    ->required()
                    ->default(1),
                Forms\Components\Select::make('category_id')
                    ->label('Category')
                    ->searchable()
                    ->options(Category::where('document_type', 'MEMO')->pluck('name', 'id'))
                    ->preload()
                    ->label('Document Category')
                    ->reactive(),
                Forms\Components\Select::make('received_by')
                    ->label('Received By')
                    ->native(false)
                    ->required()
                    ->options(User::where('is_admin', 0)->pluck('name', 'id'))
                    ->preload(),
                Forms\Components\DatePicker::make('date_received')
                    ->native(false)
                    ->default(now())
                    ->required(),
                Forms\Components\TextInput::make('doc_author')
                    ->label('Document Author')
                    ->maxLength(255),
                Forms\Components\TextInput::make('file_number')
                    ->maxLength(255),
                ])->columns(3),


                Fieldset::make('ADDITIONAL DETAILS')
                ->schema([
                    Forms\Components\TextInput::make('amount')
                    ->numeric(),
                Forms\Components\TextInput::make('phone')
                    ->label('Phone Number')
                    ->minLength(11)
                    ->maxLength(11),
                Forms\Components\TextInput::make('email')
                    ->label('Email'),
                Forms\Components\Textarea::make('remarks')
                    ->maxLength(65535)
                    ->columnSpanFull(),

                ])->columns(3),


                Fieldset::make('DOCUMENT RETRIEVAL')
                ->schema([
                    Forms\Components\TextInput::make('hand_carried')
                    ->maxLength(255),
                Forms\Components\TextInput::make('retrieved_by')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('date_retrieved')
                    ->native(false)
                    ->default(now()),
            ])->columns(3)->visibleOn(['edit', 'view']),
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
                    ->wrap()
                    ->label('Letter Description')
                    ->sortable(),

                Tables\Columns\TextColumn::make('doc_author')
                    ->label('Document Author')
                    ->wrap()
                    ->searchable(),

                Tables\Columns\IconColumn::make('treated')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->date(format: 'dS M. Y h:i A')
                    ->label('Created At')
                    //                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(auth()->user()->hasAnyRole(['super-admin'])),
                    ExportBulkAction::make()
                        ->visible(auth()->user()->hasAnyRole(['super-admin', 'admin'])),
                ]),
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
            'index' => Pages\ListMemos::route('/'),
            'create' => Pages\CreateMemo::route('/create'),
            'view' => Pages\ViewMemo::route('/{record}'),
            'edit' => Pages\EditMemo::route('/{record}/edit'),
        ];
    }
}
