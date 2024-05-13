<?php

namespace App\Filament\Resources\TimeEntryCorrectionResource\Pages;

use App\Filament\Resources\TimeEntryCorrectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTimeEntryCorrections extends ListRecords
{
    protected static string $resource = TimeEntryCorrectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
