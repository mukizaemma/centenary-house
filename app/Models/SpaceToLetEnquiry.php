<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpaceToLetEnquiry extends Model
{
    protected $fillable = [
        'name',
        'company',
        'email',
        'phone',
        'space_type_id',
        'space_needed',
        'budget_range',
        'move_in_timeline',
        'message',
        'visiting_space',
        'visit_time_preference',
        'status',
        'admin_response',
        'responded_at',
        'responded_by',
    ];

    protected $casts = [
        'visiting_space' => 'boolean',
        'responded_at' => 'datetime',
    ];

    public function spaceType(): BelongsTo
    {
        return $this->belongsTo(SpaceType::class);
    }

    public function responder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responded_by');
    }
}

