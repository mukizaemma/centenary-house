<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpaceToLetPage extends Model
{
    protected $fillable = [
        'hero_title',
        'hero_subtitle',
        'hero_bullets',
        'location_title',
        'location_html',
        'google_map_embed_url',
        'space_types',
        'amenities',
        'gallery_images',
        'pricing_html',
        'cta_primary_text',
        'cta_primary_url',
        'ideal_for',
        'testimonials',
        'is_active',
    ];

    protected $casts = [
        'hero_bullets' => 'array',
        'space_types' => 'array',
        'amenities' => 'array',
        'gallery_images' => 'array',
        'ideal_for' => 'array',
        'testimonials' => 'array',
        'is_active' => 'boolean',
    ];
}

