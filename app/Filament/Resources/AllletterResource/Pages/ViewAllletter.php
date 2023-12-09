<?php

namespace App\Filament\Resources\AllletterResource\Pages;

use App\Filament\Resources\AllletterResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAllletter extends ViewRecord
{
    protected static string $resource = AllletterResource::class;
    protected static ?string $title = 'Letter Details';

    protected function getHeaderActions(): array
    {
        return [
//            Actions\EditAction::make(),
        ];
    }
}
