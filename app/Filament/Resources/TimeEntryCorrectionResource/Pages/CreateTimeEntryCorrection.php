<?php

namespace App\Filament\Resources\TimeEntryCorrectionResource\Pages;

use App\Filament\Resources\TimeEntryCorrectionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTimeEntryCorrection extends CreateRecord
{
    protected static string $resource = TimeEntryCorrectionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}
