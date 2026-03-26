<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('space_to_let_enquiries', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('company')->nullable();
            $table->string('email');
            $table->string('phone')->nullable();

            $table->string('space_needed')->nullable(); // kept for backward compatibility (older code)
            $table->string('budget_range')->nullable();
            $table->string('move_in_timeline')->nullable();

            $table->longText('message')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('space_to_let_enquiries');
    }
};

