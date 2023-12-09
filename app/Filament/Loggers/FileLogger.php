<?php

namespace App\Filament\Loggers;

use App\Filament\Resources\FileResource;
use App\Models\File;
use Illuminate\Contracts\Support\Htmlable;
use Noxo\FilamentActivityLog\Loggers\Logger;
use Noxo\FilamentActivityLog\ResourceLogger\Field;
use Noxo\FilamentActivityLog\ResourceLogger\RelationManager;
use Noxo\FilamentActivityLog\ResourceLogger\ResourceLogger;

class FileLogger extends Logger
{
    public static ?string $model = File::class;

    public static function getLabel(): string | Htmlable | null
    {
        return FileResource::getModelLabel();
    }

    public static function resource(ResourceLogger $logger): ResourceLogger
    {
        return $logger
            ->fields([
                Field::make('description')
                    ->label(__('Description')),
                Field::make('contractor.name')
                    ->label(__('Contractor/Author')),
                Field::make('date_received'),
                Field::make('received_by'),
                Field::make('doc_author'),
                Field::make('doc_sender'),
                Field::make('category.name'),
                Field::make('amount'),
                Field::make('phone'),
                Field::make('remarks'),
            ])
            ->relationManagers([
                //
            ]);
    }
}
