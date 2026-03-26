<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('space_types', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // private_office, multiple_units, full_floor, custom
            $table->string('title');
            $table->string('starting_price')->nullable();
            $table->longText('description')->nullable(); // Summernote
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('space_types');
    }
};

