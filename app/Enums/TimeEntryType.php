<?php

namespace App\Enums;

class TimeEntryType
{
    const IN = 'IN';
    const OUT = 'OUT';

    public static function getList()
    {
        return [
            self::IN => 'In',
            self::OUT => 'Out',
        ];
    }
}
