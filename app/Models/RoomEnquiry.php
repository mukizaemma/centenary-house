<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomEnquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'visitor_name',
        'visitor_email',
        'visitor_phone',
        'message',
        'admin_response',
        'responded_at',
        'responded_by',
        'status',
    ];

    protected $casts = [
        'responded_at' => 'datetime',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function responder()
    {
        return $this->belongsTo(User::class, 'responded_by');
    }
}
