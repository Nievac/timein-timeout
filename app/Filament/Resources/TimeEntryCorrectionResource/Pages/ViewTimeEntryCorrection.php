<?php

namespace App\Filament\Resources\TimeEntryCorrectionResource\Pages;

use App\Filament\Resources\TimeEntryCorrectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTimeEntryCorrection extends ViewRecord
{
    protected static string $resource = TimeEntryCorrectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
