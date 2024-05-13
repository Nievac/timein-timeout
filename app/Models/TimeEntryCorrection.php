<?php

namespace App\Models;

use App\Enums\TimeEntryType;
use App\Enums\TimeEntryCorrectionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeEntryCorrection extends Model
{
    use HasFactory;

    protected $casts = [
        'correction_type' => TimeEntryType::class,
        'status' => TimeEntryCorrectionStatus::class,
    ];


    protected $fillable = [
        "user_id",
        "date_to_correct",
        "date_time_entry",
        "correction_type",
        "correction_reason",
        "status",
        "approver_id",
        "approval_message",
        "requested_timestamp",
        "resolved_timestamp",
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function approver() {
        return $this->belongsTo(User::class, 'approver_id');
    }

    protected static function booted(): void
    {
        static::creating(function (TimeEntryCorrection $time_entry_correction) {
            $time_entry_correction->status = is_null($time_entry_correction->status) ? TimeEntryCorrectionStatus::PENDING : $time_entry_correction->status;
            $time_entry_correction->requested_timestamp = now();
        });
    }
}
