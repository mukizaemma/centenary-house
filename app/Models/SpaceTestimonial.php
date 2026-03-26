<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpaceTestimonial extends Model
{
    protected $fillable = [
        'quote',
        'name',
        'role',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}

