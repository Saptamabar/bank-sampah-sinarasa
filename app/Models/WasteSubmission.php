<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WasteSubmission extends Model
{
    protected $fillable = [
        'user_id',
        'collection_post_id',
        'submission_date',
        'status',
        'notes',
        'admin_notes',
        'validated_by',
        'validated_at',
        'total_points_earned',
    ];

    protected $casts = [
        'submission_date' => 'date',
        'validated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function collectionPost()
    {
        return $this->belongsTo(CollectionPost::class);
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    public function items()
    {
        return $this->hasMany(WasteSubmissionItem::class);
    }
}
