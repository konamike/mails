<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityResource\Pages;
use App\Filament\Resources\ActivityResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Date;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Permission;

class ActivityResource extends Resource
{
    protected static ?string $model = Activity::class;
    protected static ?string $navigationGroup = 'Admin Management';
    protected static ?string $navigationIcon = 'heroicon-s-banknotes';
    protected static ?string $navigationLabel = 'Activities Log';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\Section::make()
                ->schema([
                    TextInput::make('id'),
                    TextInput::make('causer_id')
                        ->label('Logged By'),
                    TextInput::make('description')
                        ->label('Description'),
                    TextInput::make('subject_type')
                        ->label('Model'),
                    TextInput::make('properties.old.description')
                        ->label('Old Description'),
                    TextInput::make('properties.attributes.description')
                        ->label('New Description'),
                    TextInput::make('properties.old.amount')
                        ->label('Old Email'),
                    TextInput::make('properties.attributes.amount')
                        ->label('New Email'),
                    TextInput::make('properties.old.treated')
                        ->label('Old Treated'),
                    TextInput::make('properties.attributes.treated')
                        ->label('New Treated'),
                    TextInput::make('properties.old.treated_note')
                        ->label('Old Treated Note'),
                    TextInput::make('properties.attributes.treated_note')
                        ->label('New Treated Note'),
                    TextInput::make('properties.old.dispatched')
                        ->label('Old Dispatched'),
                    TextInput::make('properties.attributes.dispatched')
                        ->label('New Dispatched'),
                    TextInput::make('properties.old.dispatch_note')
                        ->label('Old Dispatch Note'),
                    TextInput::make('properties.attributes.dispatch_note')
                        ->label('New Dispatch Note'),
                    Forms\Components\DateTimePicker::make('created_at')
                        ->label('Created'),
                    Forms\Components\DateTimePicker::make('updated_at')
                        ->label('Updated'),
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
               Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('causer_id')
                ->label('Logged By'),
                Tables\Columns\TextColumn::make('description')
                    ->label('Type of Action'),
                Tables\Columns\TextColumn::make('properties.attributes.description')
                    ->label('Document Name'),
                Tables\Columns\TextColumn::make('subject_type')
                ->label('Model'),

                Tables\Columns\TextColumn::make('created_at')
                ->label('Logged At')
                ->dateTime('d-M-Y'),
            ])
            ->filters([
                //
            ])
            ->actions([
//                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListActivities::route('/'),
//            'create' => Pages\CreateActivity::route('/create'),
            'view' => Pages\ViewActivity::route('/{record}'),
        ];
    }
}
