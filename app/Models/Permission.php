<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPUnit\Framework\isNull;

class Permission extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function booted()
    {
        static::creating(function (Permission $permission) {
            $permission->guard_name = is_null($permission->guard_name) ? 'web' : $permission->guard_name;
        });
    }
}
