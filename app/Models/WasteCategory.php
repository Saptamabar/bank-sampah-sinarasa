<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WasteCategory extends Model
{
    protected $fillable = [
        'name',
        'unit',
        'points_per_unit',
        'description',
        'icon',
        'is_active',
    ];

    protected $casts = [
        'points_per_unit' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function wasteSubmissionItems()
    {
        return $this->hasMany(WasteSubmissionItem::class);
    }
}
