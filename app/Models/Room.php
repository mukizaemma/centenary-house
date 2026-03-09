<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'floor',
        'slug',
        'square_meters',
        'amount',
        'pricing_mode',
        'amount_per_sqm',
        'description',
        'cover_image_path',
        'is_available',
        'sort_order',
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'square_meters' => 'decimal:2',
        'amount' => 'decimal:2',
        'amount_per_sqm' => 'decimal:2',
    ];

    public function images()
    {
        return $this->hasMany(RoomImage::class)->orderBy('sort_order');
    }

    public function enquiries()
    {
        return $this->hasMany(RoomEnquiry::class, 'room_id');
    }
}
