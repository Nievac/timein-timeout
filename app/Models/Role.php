<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function booted()
    {
        static::creating(function (Role $role) {
            $role->guard_name = is_null($role->guard_name) ? 'web' : $role->guard_name;
        });
    }
}
