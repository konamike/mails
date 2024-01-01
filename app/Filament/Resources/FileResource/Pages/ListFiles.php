<?php

namespace App\Filament\Resources\FileResource\Pages;

use App\Filament\Resources\FileResource;
use Filament\Actions;
use Filament\Actions\ActionGroup;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
class ListFiles extends ListRecords
{
    protected static string $resource = FileResource::class;
    protected static ?string $title = 'All Files';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-film')
                ->color('warning')
                ->label('Create New File'),

            // ExportAction::make()->exports([
            //     // Pass a string
            //     ExcelExport::make()->withFilename(date('Y-m-d') . ' - export'),
            // ]),
        ];
    }
}
