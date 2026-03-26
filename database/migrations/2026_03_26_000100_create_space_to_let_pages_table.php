<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('space_to_let_pages', function (Blueprint $table) {
            $table->id();

            // Hero / value proposition
            $table->string('hero_title')->nullable();
            $table->text('hero_subtitle')->nullable();
            $table->json('hero_bullets')->nullable(); // array of strings

            // Location & accessibility
            $table->string('location_title')->nullable();
            $table->longText('location_html')->nullable(); // Summernote
            $table->text('google_map_embed_url')->nullable();

            // Types of spaces
            $table->json('space_types')->nullable(); // array of { key,title,starting_price,description }

            // Amenities
            $table->json('amenities')->nullable(); // array of strings

            // Visuals
            $table->json('gallery_images')->nullable(); // array of image paths (storage/...)

            // Pricing + CTA
            $table->longText('pricing_html')->nullable(); // Summernote
            $table->string('cta_primary_text')->nullable();
            $table->string('cta_primary_url')->nullable();

            // Optional sections
            $table->json('ideal_for')->nullable(); // array of strings
            $table->json('testimonials')->nullable(); // array of { quote, name, role }

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('space_to_let_pages');
    }
};

