<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FileResource\Pages;
use App\Filament\Resources\FileResource\RelationManagers;
use App\Models\File;
use App\Models\Category;
use App\Models\Contractor;
use App\Models\User;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\PseudoTypes\TraitString;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Rmsramos\Activitylog\RelationManagers\ActivitylogRelationManager;

class FileResource extends Resource
{
    protected static ?string $model = File::class;

    protected static ?string $navigationIcon = 'heroicon-s-film';
    protected static ?string $navigationGroup = 'Incoming Documents';
    protected static ?string $navigationLabel = 'Files';
    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::query()->where('treated', false)->count();
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
                Wizard::make([
                    Wizard\Step::make('PRIMARY INFORMATION')
                        ->description('Primary Data')
                        ->icon('heroicon-m-academic-cap')
                        ->schema([
                            Forms\Components\Textarea::make('description')
                                ->required()
                                ->label('File Description')
                                ->maxLength(65535)
                                ->columnSpanFull(),
                            Forms\Components\Select::make('category_id')
                                ->label('Category')
                                ->searchable()
                                ->options(Category::where('document_type', 'FILE')->pluck('name', 'id'))
                                ->preload()
                                ->required()
                                ->label('Document Category')
                                ->reactive(),
                            Forms\Components\Select::make('contractor_id')
                                ->label('Mail Source')
                                ->relationship('contractor', 'name')
                                ->native(false)
                                ->required()
                                ->default(1),
                            Forms\Components\TextInput::make('file_number')
                                ->maxLength(255),
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

                        ])->columns(3),

                    Wizard\Step::make('ADDITIONAL DETAILS')
                        ->description('Additional Details ')
                        ->icon('heroicon-m-building-office-2')
                        ->schema([
                            Forms\Components\TextInput::make('doc_sender')
                                ->label('Document Sender')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('amount')
                                ->numeric(),
                            Forms\Components\TextInput::make('phone')
                                ->label('Phone Number')
                                ->mask('999-9999-9999')
                                ->placeholder('080-0000-0000'),
//                                ->minLength(11)
//                                ->maxLength(11),
                            Forms\Components\TextInput::make('email')
                                ->label('Email')
                                ->placeholder('Pls enter email for receipt of document info'),
                            Forms\Components\Textarea::make('remarks')
                                ->maxLength(65535)
                                ->columnSpanFull(),
                        ])->columns(2),

                    Wizard\Step::make('DOCUMENT RETRIEVAL')
                        ->description('Retrieval Data')
                        ->icon('heroicon-m-banknotes')
                        ->schema([
                            Forms\Components\TextInput::make('hand_carried')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('retrieved_by')
                                ->maxLength(255),
                            Forms\Components\DatePicker::make('date_retrieved')
                                ->native(false)
                                ->default(now()),
                        ])->columns(2)->visibleOn(['edit', 'view']),
                ])->columnSpanFull(),
                /*                    ->submitAction(new HtmlString(Blade::render(<<<BLADE
                                            <x-filament::button
                                                type="submit"
                                                size="sm"
                                            >
                                                Submit
                                            </x-filament::button>
                                        BLADE
                                    ))),*/
//            ]);


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->label('Description')
                    ->wrap(),
                Tables\Columns\TextColumn::make('date_received')
                ->date(),
                    // ->since(),
                Tables\Columns\TextColumn::make('doc_author')
                    ->label('Document Author')
                    ->limit(35)
                    ->searchable(),
                Tables\Columns\IconColumn::make('treated')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->date(format: 'dS M. Y h:i A')
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
            // ActivitylogRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFiles::route('/'),
            'create' => Pages\CreateFile::route('/create'),
           'view' => Pages\ViewFile::route('/{record}'),
            'edit' => Pages\EditFile::route('/{record}/edit'),
        ];
    }
}
