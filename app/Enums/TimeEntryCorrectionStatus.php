<?php

namespace App\Enums;
use Filament\Support\Contracts\HasLabel;

enum TimeEntryCorrectionStatus: string implements HasLabel
{
    case PENDING = 'Pending';
    case APPROVED = 'Approved';
    case REJECTED = 'Rejected';

    public function getLabel(): ?string
    {
        return $this->name;
    }
}
