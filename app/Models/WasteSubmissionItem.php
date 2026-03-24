<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WasteSubmissionItem extends Model
{
    protected $fillable = [
        'waste_submission_id',
        'waste_category_id',
        'quantity',
        'points_per_unit',
        'subtotal_points',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'points_per_unit' => 'decimal:2',
    ];

    public function submission()
    {
        return $this->belongsTo(WasteSubmission::class, 'waste_submission_id');
    }

    public function category()
    {
        return $this->belongsTo(WasteCategory::class, 'waste_category_id');
    }
}
