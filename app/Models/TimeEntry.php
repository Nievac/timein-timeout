<?php

namespace App\Models;

use App\Enums\TimeEntryType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPUnit\Framework\isNull;

class TimeEntry extends Model
{
    use HasFactory;

    protected $casts = [
        'time_entry_type' => TimeEntryType::class,
    ];


    protected $fillable = [
        'user_id',
        'entry_date',
        'date_time_entry',
        'time_entry_type',
        'is_correction',
        'corrected_by_user_id',
    ];

    public function user_not_admin() {
        return $this->belongsTo(User::class, 'user_id')
            // ->where('email', 'not like', '%admin.com')
        ;
    }

    protected static function booted(): void
    {
        static::creating(function (TimeEntry $time_entry) {
            $time_entry->is_correction = isNull($time_entry->is_correction) ? false : $time_entry->is_correction;
        });
        static::updating(function (TimeEntry $time_entry) {
            $time_entry->is_correction = isNull($time_entry->is_correction) ? false : $time_entry->is_correction;
        });
    }
}
