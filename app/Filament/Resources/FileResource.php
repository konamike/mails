<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FileResource\Pages;
use App\Filament\Resources\FileResource\RelationManagers;
use App\Filament\Resources\FileResource\RelationManagers\ContractorsRelationManager;
use App\Models\File;
use App\Models\Category;
use App\Models\Contractor;
use App\Models\User;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Number;
use phpDocumentor\Reflection\PseudoTypes\TraitString;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Rmsramos\Activitylog\RelationManagers\ActivitylogRelationManager;
use Pelmered\FilamentMoneyField\Tables\Columns\MoneyColumn;
use Pelmered\FilamentMoneyField\Infolists\Components\MoneyEntry;
use Filament\Forms\Components;

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
                            ->relationship('category', 'name')
                            ->options(Category::where('document_type', 'FILE')->pluck('name', 'id'))
                            // ->getSearchResultsUsing(fn (string $search): array => Category::where('name', 'like', "%{$search}%")->limit(50)->pluck('name', 'id')->toArray())
                            // ->getOptionLabelUsing(fn ($value): ?string => Category::find($value)?->name)
                            ->preload()
                            ->required()
                            ->label('Document Category')
                            ->reactive()
                        // ->createOptionForm([
                        //     Forms\Components\TextInput::make('document_type')
                        //         ->default('LETTER')
                        //         ->label('Document Type')
                        //         ->readOnly(),
                        //     Forms\Components\TextInput::make('name')
                        //         ->label('Name')
                        //         ->required()
                        // ])
                        ,
                        Forms\Components\Select::make('contractor_id')
                            ->label('Mail Source')
                            ->relationship('contractor', 'name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required()
                            ->default(1)
                        // ->createOptionForm([
                        //     Forms\Components\TextInput::make('name')
                        //         ->label('Name')
                        //         ->required()
                        //         ->columnSpanFull(),
                        //     Forms\Components\TextInput::make('email')
                        //         ->label('Email'),
                        //     Forms\Components\TextInput::make('phone')
                        //         ->label('Phone'),
                        //     Forms\Components\TextInput::make('contact_person')
                        //         ->label('Contact Person'),
                        //     Forms\Components\TextInput::make('contact_phone')
                        //         ->label('Contact Phone')
                        //         ->columns(2),
                        // ])
                        ,
                        Forms\Components\TextInput::make('file_number')
                            ->maxLength(255),
                        Forms\Components\Select::make('received_by')
                            ->label('Received By')
                            ->native(false)
                            ->required()
                            ->options(User::where('is_admin', 0)->pluck('name', 'id'))
                            ->preload(),
                        Forms\Components\DatePicker::make('date_received')
                            ->default(now())
                            ->required(),
                        Forms\Components\TextInput::make('doc_author')
                            ->label('Document Author')
                            ->maxLength(255),

                    ])->columns(3),

                Fieldset::make()
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

                    ])->columns(2),

                Fieldset::make('DOCUMENT RETRIEVALS')
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
                    ->date(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->label('Description')
                    ->wrap(),
/*                MoneyColumn::make('amount')
//                    ->currency('USD')

                    ->locale('en_USD'),*/
                Tables\Columns\TextColumn::make('doc_author')
                    ->label('Document Author')
                    ->limit(35)
                    ->searchable(),
                Tables\Columns\IconColumn::make('treated')
                    ->boolean(),
                // Tables\Columns\TextColumn::make('amount')
                //     ->numeric(
                //         decimalPlaces: 2,
                //         decimalSeparator: '.',
                //         thousandsSeparator: ','
                //     ),
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
                        ->visible(auth()->user()->hasAnyRole(['super-admin'])),
                    ExportBulkAction::make()
                        ->visible(auth()->user()->hasAnyRole(['super-admin', 'admin'])),
                ])->iconButton(),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array

    {
        return [
            // ContractorsRelationManager::class
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
