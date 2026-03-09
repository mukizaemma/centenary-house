<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->string('floor', 50)->nullable()->after('title');
            $table->enum('pricing_mode', ['custom', 'per_sqm'])->default('custom')->after('amount');
            $table->decimal('amount_per_sqm', 12, 2)->nullable()->after('pricing_mode');
        });
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn(['floor', 'pricing_mode', 'amount_per_sqm']);
        });
    }
};

