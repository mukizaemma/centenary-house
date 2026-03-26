<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('space_to_let_enquiries', function (Blueprint $table) {
            if (!Schema::hasColumn('space_to_let_enquiries', 'space_type_id')) {
                $table->unsignedBigInteger('space_type_id')->nullable()->after('phone');
            }
        });
    }

    public function down(): void
    {
        Schema::table('space_to_let_enquiries', function (Blueprint $table) {
            if (Schema::hasColumn('space_to_let_enquiries', 'space_type_id')) {
                $table->dropColumn('space_type_id');
            }
        });
    }
};

