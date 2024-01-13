<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AllmemoResource\Pages;
use App\Filament\Resources\AllmemoResource\RelationManagers;
use App\Models\Allmemo;
use Filament\Forms;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class AllmemoResource extends Resource
{
    protected static ?string $model = Allmemo::class;

    protected static ?string $navigationGroup = 'All Documents';
    protected static ?string $navigationIcon = 'heroicon-s-chevron-double-down';
    protected static ?string $navigationLabel = 'Memos';
    protected static ?int $navigationSort = 3;


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
                                    ->numeric(),
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
                        Tabs\Tab::make('Document Processing')
                            ->icon('heroicon-m-presentation-chart-bar')
                            ->schema([
                                //                                Forms\Components\Toggle::make('treated')
                                //                                    ->label('Document Processed?')
                                //                                    ->offIcon('heroicon-m-no-symbol')
                                //                                    ->offColor('danger')
                                //                                    ->onIcon('heroicon-m-check-badge')
                                //                                    ->inline(false),
                                Forms\Components\DatePicker::make('date_treated')
                                    ->label('Date Processed')
                                    ->date()
                                    ->native(false),
                                Forms\Components\Select::make('treated_by')
                                    ->relationship('user', 'name')
                                    ->label('Processed By'),
                                Forms\Components\Textarea::make('treated_notes')
                                    ->label('Document Note')
                                    ->maxLength(65535)->columnSpanFull(),
                            ])->columns(2),
                        Tabs\Tab::make('Document Dispatch')
                            ->icon('heroicon-m-paper-airplane')
                            ->schema([
                                //                                Forms\Components\Toggle::make('dispatched')
                                //                                    ->offIcon('heroicon-m-no-symbol')
                                //                                    ->offColor('danger')
                                //                                    ->onIcon('heroicon-m-check-badge')
                                //                                    ->inline(false),
                                Forms\Components\DatePicker::make('date_dispatched')
                                    ->date()
                                    ->native(false)
                                    ->label('Date Dispatched'),
                                Forms\Components\TextInput::make('sent_from')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('sent_to')
                                    ->maxLength(255),
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
                        Tabs\Tab::make('Retrieval Details')
                            ->icon('heroicon-m-arrow-top-right-on-square')
                            ->schema([
                                Forms\Components\DatePicker::make('date_retrieved')
                                    ->date()
                                    ->native(false)
                                    ->label('Date Retrieved/Hand Carried'),
                                Forms\Components\TextInput::make('hand_carried')
                                    ->label('Hand Carried By')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('retrieved_by')
                                    ->label('Retrieved By')
                                    ->maxLength(255),

                            ])->columns(3),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date_received')
                    ->label('Date Received')
                    ->date()
                    ->sortable(),
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
                    // ->visible(Auth::user()->hasRole('engineer'))
                    ->date()
                    ->hidden(Auth::user()->hasRole('frontdesk')),

                Tables\Columns\IconColumn::make('dispatched')
                    ->label('Dispatched')
                    ->boolean(),
                Tables\Columns\TextColumn::make('date_dispatched')
                    ->label('Dispatch Date')
                    ->date(),
                Tables\Columns\TextColumn::make('sent_to')
                    ->limit(20)
                    ->label('Sent To')
                    ->default('Not Sent'),
                Tables\Columns\TextColumn::make('sent_to')
                    ->label('Dispatched To'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                //                Tables\Actions\BulkActionGroup::make([
                //                    Tables\Actions\DeleteBulkAction::make(),
                //                ]),
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
            'index' => Pages\ListAllmemos::route('/'),
            'view' => Pages\ViewAllmemo::route('/{record}'),
        ];
    }
}
