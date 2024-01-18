<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LetterResource\Pages;
use App\Filament\Resources\LetterResource\RelationManagers;
use App\Models\Category;
use App\Models\Letter;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Forms\Components\Fieldset;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Tabs;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Blade;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class LetterResource extends Resource
{
    protected static ?string $model = Letter::class;
    protected static ?string $navigationIcon = 'heroicon-s-envelope';
    protected static ?string $navigationGroup = 'Incoming Documents';
    protected static ?string $navigationLabel = 'Letter';
    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        //        return static::getModel()::count();
        return Letter::where('treated', 'false')->count();
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

                Fieldset::make()
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->required()
                            ->label('File Description')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                        Forms\Components\Select::make('category_id')
                            ->label('Category')
                            ->searchable()
                            ->options(Category::where('document_type', 'LETTER')->pluck('name', 'id'))
                            ->preload()
                            ->required()
                            ->label('Document Category')
                            ->reactive(),
                        Forms\Components\Select::make('contractor_id')
                            ->label('Mail Source')
                            ->relationship('contractor', 'name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required()
                            ->default(1),

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

                Fieldset::make()
                    ->schema([
                        Forms\Components\TextInput::make('amount')
                            ->numeric()->visibleOn('create'),
                        Forms\Components\TextInput::make('amount')
                            ->prefix('NGN')
                            ->currencyMask(thousandSeparator: ',',decimalSeparator: '.',precision: 2)
                            ->visibleOn(['edit', 'view']),
                        Forms\Components\TextInput::make('phone')
                            ->label('Phone Number')
                            ->mask('999-9999-9999')
                            ->placeholder('080-0000-0000'),
                        Forms\Components\TextInput::make('email')
                            ->label('Email'),
                    ])->columns(3),

                Fieldset::make()
                    ->schema([
                        Forms\Components\TextInput::make('hand_carried')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('retrieved_by')
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('date_retrieved')
                            ->native(false)
                            ->default(now()),
                    ])->columns(2)->visibleOn(['edit', 'view']),

                Fieldset::make()
                    ->schema([
                        Forms\Components\Textarea::make('remarks')
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
                    //                    ->sortable()
                    ->label('Created At')
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
                        ->visible(auth()->user()->hasAnyRole(['super-admin',])),
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
            'index' => Pages\ListLetters::route('/'),
            'create' => Pages\CreateLetter::route('/create'),
            'view' => Pages\ViewLetter::route('/{record}'),
            'edit' => Pages\EditLetter::route('/{record}/edit'),
        ];
    }
}
