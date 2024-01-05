<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AllfileResource\Pages;
use App\Filament\Resources\AllfileResource\RelationManagers;
use App\Models\Allfile;
use Filament\Forms;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Infolist;
use Illuminate\Support\Facades\Auth;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class AllfileResource extends Resource
{
    protected static ?string $model = Allfile::class;
    protected static ?string $navigationGroup = 'All Documents';
    protected static ?string $navigationIcon = 'heroicon-s-film';
    protected static ?string $navigationLabel = 'Files';
    protected static ?int $navigationSort = 1;


    public static function form(Form $form): Form
    {
        return $form
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

                Tabs::make('Details')
                    ->tabs([
                        Tabs\Tab::make('Main Information')
                            ->icon('heroicon-m-bell')
                            ->schema([
                                Forms\Components\TextInput::make('file_number')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('amount')
                                    ->numeric(),
                                Forms\Components\Select::make('received_by')
                                    ->relationship('user', 'name')
                                    ->label('Received By'),
                                Forms\Components\TextInput::make('doc_author')
                                    ->label('Document Author')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('doc_sender')
                                    ->label('Document Sender')
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('remarks')
                                    ->maxLength(65535)
                                    ->columnSpanFull(),
                            ])->columns(3),
                        Tabs\Tab::make('Processing Info')
                            ->icon('heroicon-m-presentation-chart-bar')
                            ->schema([
                                Forms\Components\Toggle::make('treated')
                                    ->label('Document Processed?')
                                    ->offIcon('heroicon-m-no-symbol')
                                    ->offColor('danger')
                                    ->onIcon('heroicon-m-check-badge')
                                    ->inline(false),
                                Forms\Components\DatePicker::make('date_treated')
                                    ->label('Date Processed'),
                                Forms\Components\TextInput::make('treated_by')
                                    ->label('Document Processed By')
                                    ->numeric(),
                                Forms\Components\Textarea::make('treated_notes')
                                    ->label('Document Note')
                                    ->maxLength(65535)->columnSpanFull(),
                            ])->columns(3),
                        Tabs\Tab::make('Dispatch Info')
                            ->icon('heroicon-m-paper-airplane')
                            ->schema([
                                Forms\Components\Toggle::make('dispatched')
                                    ->offIcon('heroicon-m-no-symbol')
                                    ->offColor('danger')
                                    ->onIcon('heroicon-m-check-badge')
                                    ->inline(false),
                                Forms\Components\TextInput::make('sent_from')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('sent_to')
                                    ->maxLength(255),
                                Forms\Components\DatePicker::make('date_dispatched'),
                                Forms\Components\TextInput::make('dispatch_phone')
                                    ->tel()
                                    ->maxLength(11),
                                Forms\Components\TextInput::make('dispatch_email')
                                    ->email()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('dispatched_by')
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('dispatch_note')
                                    ->maxLength(65535)
                                    ->columnSpanFull(),
                            ])->columns(3),
                        Tabs\Tab::make('Additional Information')
                            ->icon('heroicon-m-arrow-top-right-on-square')
                            ->schema([
                                Forms\Components\TextInput::make('hand_carried')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('retrieved_by')
                                    ->maxLength(255),
                                Forms\Components\DatePicker::make('date_retrieved')
                                    ->date()
                                    ->native(false),
                            ])->columns(3),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date_received')
                    ->date()
                    ->label('Date Received')
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('File Description/Name')
                    ->searchable()
                    ->wrap(),
                Tables\Columns\IconColumn::make('treated')
                    ->label('Treated?')
                    ->boolean()
                    ->visible(auth()->user()->hasRole('engineer')),
                Tables\Columns\IconColumn::make('treated')
                    ->label('In-Process?')
                    ->boolean()
                    ->visible(!auth()->user()->hasRole('engineer')),
                Tables\Columns\TextColumn::make('date_treated')
                    ->label('Date Treated')
                    ->date()
                    ->visible(auth()->user()->hasRole('engineer')),
                Tables\Columns\IconColumn::make('dispatched')
                    ->label('Dispatched?')
                    ->boolean(),
                Tables\Columns\TextColumn::make('date_dispatched')
                    ->date()
                    ->label('Date Dispatched'),
                Tables\Columns\TextColumn::make('sent_to')
                    ->label('Dispatched To'),
                // Tables\Columns\TextColumn::make('created_at')
                //     ->label('Date Created')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListAllfiles::route('/'),
            'view' => Pages\ViewAllfile::route('/{record}'),
        ];
    }
}
