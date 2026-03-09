<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('website_settings', function (Blueprint $table) {
            // Contact / map fields
            if (!Schema::hasColumn('website_settings', 'phone_urgency')) {
                $table->string('phone_urgency')->nullable()->after('phone_reception');
            }

            if (!Schema::hasColumn('website_settings', 'phone_billing')) {
                $table->string('phone_billing')->nullable()->after('phone_urgency');
            }

            if (!Schema::hasColumn('website_settings', 'phone_restaurant')) {
                $table->string('phone_restaurant')->nullable()->after('phone_billing');
            }

            if (!Schema::hasColumn('website_settings', 'map_embed_url')) {
                $table->longText('map_embed_url')->nullable()->after('address');
            }

            // About / values fields
            if (!Schema::hasColumn('website_settings', 'about_heading')) {
                $table->string('about_heading')->nullable()->after('about_description');
            }

            if (!Schema::hasColumn('website_settings', 'about_values_subheading')) {
                $table->string('about_values_subheading')->nullable()->after('about_heading');
            }

            if (!Schema::hasColumn('website_settings', 'about_value_cards')) {
                $table->longText('about_value_cards')->nullable()->after('about_values_subheading');
            }

            // CTA / gallery fields
            if (!Schema::hasColumn('website_settings', 'cta_background_image_path')) {
                $table->string('cta_background_image_path')->nullable()->after('home_background_image_path');
            }

            if (!Schema::hasColumn('website_settings', 'cta_title')) {
                $table->string('cta_title')->nullable()->after('cta_background_image_path');
            }

            if (!Schema::hasColumn('website_settings', 'cta_description')) {
                $table->longText('cta_description')->nullable()->after('cta_title');
            }

            if (!Schema::hasColumn('website_settings', 'gallery_external_url')) {
                $table->string('gallery_external_url')->nullable()->after('threads_url');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('website_settings', function (Blueprint $table) {
            if (Schema::hasColumn('website_settings', 'phone_urgency')) {
                $table->dropColumn('phone_urgency');
            }
            if (Schema::hasColumn('website_settings', 'phone_billing')) {
                $table->dropColumn('phone_billing');
            }
            if (Schema::hasColumn('website_settings', 'phone_restaurant')) {
                $table->dropColumn('phone_restaurant');
            }
            if (Schema::hasColumn('website_settings', 'map_embed_url')) {
                $table->dropColumn('map_embed_url');
            }
            if (Schema::hasColumn('website_settings', 'about_heading')) {
                $table->dropColumn('about_heading');
            }
            if (Schema::hasColumn('website_settings', 'about_values_subheading')) {
                $table->dropColumn('about_values_subheading');
            }
            if (Schema::hasColumn('website_settings', 'about_value_cards')) {
                $table->dropColumn('about_value_cards');
            }
            if (Schema::hasColumn('website_settings', 'cta_background_image_path')) {
                $table->dropColumn('cta_background_image_path');
            }
            if (Schema::hasColumn('website_settings', 'cta_title')) {
                $table->dropColumn('cta_title');
            }
            if (Schema::hasColumn('website_settings', 'cta_description')) {
                $table->dropColumn('cta_description');
            }
            if (Schema::hasColumn('website_settings', 'gallery_external_url')) {
                $table->dropColumn('gallery_external_url');
            }
        });
    }
};

