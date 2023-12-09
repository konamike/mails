<?php

namespace App\Filament\Resources\LettertreatResource\Pages;

use App\Filament\Resources\LettertreatResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLettertreat extends CreateRecord
{
    protected static string $resource = LettertreatResource::class;
    protected static ?string $title = 'Create New Letter';
}
