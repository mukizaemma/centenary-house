<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('space_types', function (Blueprint $table) {
            if (Schema::hasColumn('space_types', 'key')) {
                $table->dropUnique(['key']);
                $table->dropColumn('key');
            }
        });
    }

    public function down(): void
    {
        Schema::table('space_types', function (Blueprint $table) {
            if (!Schema::hasColumn('space_types', 'key')) {
                $table->string('key')->unique()->after('id');
            }
        });
    }
};

