<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WebsiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'logo_path',
        'partner_logo_path',
        'home_background_image_path',
        'home_background_text',
        'home_quote',
        'cta_background_image_path',
        'cta_title',
        'cta_description',
        'about_description',
        'about_history',
        'about_heading',
        'about_values_subheading',
        'about_value_cards',
        'email',
        'phone_reception',
        'phone_urgency',
        'phone_whatsapp',
        'phone_billing',
        'phone_restaurant',
        'address',
        'map_embed_url',
        'mission',
        'vision',
        'core_values',
        'facebook_url',
        'instagram_url',
        'linkedin_url',
        'youtube_url',
        'x_url',
        'threads_url',
        'gallery_external_url',
    ];
}

