<?php

namespace App\Enums;
use Filament\Support\Contracts\HasLabel;

enum TimeEntryType: string implements HasLabel
{
    case IN = 'In';
    case OUT = 'Out';

    public function getLabel(): ?string
    {
        return $this->name;
    }
}
