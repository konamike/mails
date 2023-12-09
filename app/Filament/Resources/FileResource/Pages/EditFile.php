<?php

namespace App\Filament\Resources\FileResource\Pages;

use App\Filament\Loggers\FileLogger;
use App\Filament\Resources\FiledispatchResource;
use App\Filament\Resources\FileResource;
use App\Models\File;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Actions\Action;
use Noxo\FilamentActivityLog\Extensions\LogEditRecord;
use \Spatie\Permission\Traits\HasRoles;

class EditFile extends EditRecord
{
    use LogEditRecord;
    protected static string $resource = FileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
//    protected function getSavedNotification(): ?Notification
//    {
////        $name = \Illuminate\Support\Facades\Auth::user()->name;
//        $recipients = auth()->user()->hasAnyRoles(['super-admin', 'admin', 'user']);
//        return
//            Notification::make()
//                ->success()
//                ->title('Changes to a file.')
//                ->duration(4000)
//                ->body('The File: ' . $this->record->description . ' was updated by ' . $name)
//                ->actions([
//                    Action::make('View File')
//                        ->url(FileResource::getUrl('view', ['record' => $this->record]))
//                        ->button(),
//                ])
//                ->sendToDatabase($recipients);
//    }

/*    protected function afterSave(): void
    {
//        $filedispatched = $this->record;
        Notification::make()
            ->title('New Dispatch File Made')
            ->icon('heroicon-m-shopping-bag')
            ->body("FIle {$filedispatched->description} was updated!")
            ->actions([
                Action::make('View')
//                    ->url(
//                    FiledispatchResource::getUrl('view', ['record' => $filedispatched])
                        ->url(FiledispatchResource::getUrl('view', ['record' => $this->record])
                )
            ])
            ->sendToDatabase(auth()->user());

    }*/

    public function getSavedNotification(): ?Notification
    {
        $name = \Illuminate\Support\Facades\Auth::user()->name;
        return
            Notification::make()
                ->success()
                ->title('File update')
                ->duration(4000)
                ->body('The File: ' . $this->record->description . ' was updated by ' . $name)
                ->actions([
                    Action::make('View File')
                        ->url(FiledispatchResource::getUrl('view', ['record' => $this->record]))
                        ->button(),
                ]);
//                ->sendToDatabase(User::whereIn('role', ['ADMIN', 'USER', 'MD'])->get());
    }

}
