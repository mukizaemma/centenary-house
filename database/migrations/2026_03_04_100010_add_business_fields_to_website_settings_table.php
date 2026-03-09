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
            if (!Schema::hasColumn('website_settings', 'home_quote')) {
                $table->longText('home_quote')->nullable()->after('home_background_text');
            }

            if (!Schema::hasColumn('website_settings', 'about_history')) {
                $table->longText('about_history')->nullable()->after('about_description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('website_settings', function (Blueprint $table) {
            if (Schema::hasColumn('website_settings', 'home_quote')) {
                $table->dropColumn('home_quote');
            }

            if (Schema::hasColumn('website_settings', 'about_history')) {
                $table->dropColumn('about_history');
            }
        });
    }
};

