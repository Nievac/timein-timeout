<?php

namespace App\Filament\Resources\TimeEntryCorrectionResource\Pages;

use App\Filament\Resources\TimeEntryCorrectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTimeEntryCorrection extends EditRecord
{
    protected static string $resource = TimeEntryCorrectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
