<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AllletterResource\Pages;
use App\Filament\Resources\AllletterResource\RelationManagers;
use App\Models\Allletter;
use Filament\Forms;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class AllletterResource extends Resource
{
    protected static ?string $model = Allletter::class;

    protected static ?string $navigationGroup = 'All Documents';
    protected static ?string $navigationIcon = 'heroicon-s-envelope';
    protected static ?string $navigationLabel = 'Letters';
    protected static ?int $navigationSort = 2;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Textarea::make('description')
                                    ->readOnly()
                                    ->label('Document Title')
                                    ->maxLength(65535)
                                    ->visibleOn('view')
                                    ->columnSpan(8),
                                Forms\Components\Toggle::make('treated')
                                    ->label('Processed?')
                                    ->offIcon('heroicon-m-no-symbol')
                                    ->offColor('danger')
                                    ->onIcon('heroicon-m-check-badge')
                                    ->inline(false),
                                Forms\Components\Toggle::make('dispatched')
                                    ->label('Dispatched?')
                                    ->offIcon('heroicon-m-no-symbol')
                                    ->offColor('danger')
                                    ->onIcon('heroicon-m-check-badge')
                                    ->inline(false),
                            ])->columns(10),

                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\DatePicker::make('date_received')
                                    ->format('D, d M Y')
                                    ->label('Date Received'),
                                Forms\Components\Select::make('category_id')
                                    ->relationship('category', 'name')
                                    ->label('Document Category'),
                                Forms\Components\Select::make('contractor_id')
                                    ->relationship('contractor', 'name')
                                    ->label('Contractor/Initiator Name'),
                            ])->columns(3),
                    ]),

                Tabs::make('Details')
                    ->tabs([
                        Tabs\Tab::make('Main Information')
                            ->icon('heroicon-m-bell')
                            ->schema([
                                Forms\Components\TextInput::make('file_number')
                                    ->placeholder('No File Number'),
                                Forms\Components\TextInput::make('amount')
                                    ->currencyMask(thousandSeparator: ',',decimalSeparator: '.',precision: 2)->currencyMask()
                                    ->prefix('NGN'),
                                Forms\Components\Select::make('received_by')
                                    ->relationship('user', 'name')
                                    ->label('Received By'),
                                Forms\Components\TextInput::make('doc_author')
                                    ->label('Document Author')
                                    ->placeholder('No Author'),
                                Forms\Components\TextInput::make('doc_sender')
                                    ->label('Document Sender')
                                    ->placeholder('No Sender Name'),
                                Forms\Components\Textarea::make('remarks')
                                    ->maxLength(65535)
                                    ->columnSpanFull(),
                            ])->columns(3),
                        Tabs\Tab::make('Processing Information')
                            ->icon('heroicon-m-presentation-chart-bar')
                            ->schema([
/*                                Forms\Components\Toggle::make('treated')
                                    ->label('Document Processed?')
                                    ->offIcon('heroicon-m-no-symbol')
                                    ->offColor('danger')
                                    ->onIcon('heroicon-m-check-badge')
                                    ->inline(false),*/
                                Forms\Components\DatePicker::make('date_treated')
                                    ->label('Date Processed'),
                                Forms\Components\Select::make('treated_by')
                                    ->relationship('user', 'name')
                                    ->label('Processed By'),
                                Forms\Components\Textarea::make('treated_notes')
                                    ->label('Document Note')
                                    ->maxLength(65535)->columnSpanFull(),
                            ])->columns(2),
                        Tabs\Tab::make('Dispatch Information')
                            ->icon('heroicon-m-paper-airplane')
                            ->schema([
/*                                Forms\Components\Toggle::make('dispatched')
                                    ->offIcon('heroicon-m-no-symbol')
                                    ->offColor('danger')
                                    ->onIcon('heroicon-m-check-badge')
                                    ->inline(false),*/
                                Forms\Components\TextInput::make('sent_from')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('sent_to')
                                    ->maxLength(255),
                                Forms\Components\DatePicker::make('date_dispatched'),
                                Forms\Components\TextInput::make('dispatch_phone')
                                    ->label('Dispatch Phone')
                                    ->maxLength(11),
                                Forms\Components\TextInput::make('dispatch_email')
                                    ->label('Dispatch Email'),
                                Forms\Components\Select::make('dispatched_by')
                                    ->relationship('user', 'name')
                                    ->label('Dispatched By'),
                                Forms\Components\Textarea::make('dispatch_note')
                                    ->label('Dispatch Note')
                                    ->columnSpanFull(),
                            ])->columns(3),
                        Tabs\Tab::make('Additional Information')
                            ->icon('heroicon-m-arrow-top-right-on-square')
                            ->schema([
                                Forms\Components\TextInput::make('hand_carried')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('retrieved_by')
                                    ->maxLength(255),
                                Forms\Components\DatePicker::make('date_retrieved'),
                            ])->columns(3),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->deferLoading()
            ->columns([
                Tables\Columns\TextColumn::make('date_received')
                    ->label('Date Received')
                    ->date(),
                Tables\Columns\TextColumn::make('contractor.name')
                    ->label('Mail Source')
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description/Name')
                    ->searchable()
                    ->wrap(),

                Tables\Columns\IconColumn::make('treated')
                    ->label('Treated?')
                    ->boolean()
                    ->visible(Auth::user()->hasRole('engineer')),
                Tables\Columns\IconColumn::make('treated')
                    ->label('In-Process?')
                    ->boolean()
                    ->visible(!Auth::user()->hasRole('engineer')),
                Tables\Columns\TextColumn::make('treated_note')
                    ->label('Doc. Remark')
                    ->visible(auth()->user()->hasRole('md')),
                Tables\Columns\TextColumn::make('date_treated')
                    ->label('Date Treated')
                    ->visible(Auth::user()->hasRole('engineer'))
                    ->date(),
                // ->hidden(Auth::user()->hasRole('frontdesk')),
                Tables\Columns\IconColumn::make('dispatched')
                    ->label('Dispatched?')
                    ->boolean(),
                Tables\Columns\TextColumn::make('date_dispatched')
                    ->label('Date Dispatched')
                    ->date(),
                Tables\Columns\TextColumn::make('sent_to')
                    ->label('Sent To'),
/*                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),*/
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                //
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
            'index' => Pages\ListAllletters::route('/'),
            'view' => Pages\ViewAllletter::route('/{record}'),
        ];
    }
}
