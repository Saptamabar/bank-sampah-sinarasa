<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectionPost extends Model
{
    protected $fillable = [
        'name',
        'address',
        'rt',
        'rw',
        'latitude',
        'longitude',
        'pic_name',
        'pic_phone',
        'operational_hours',
        'photo',
        'is_active',
    ];

    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'is_active' => 'boolean',
    ];
}
