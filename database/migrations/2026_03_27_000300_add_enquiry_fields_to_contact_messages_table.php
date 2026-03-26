<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('contact_messages')) {
            Schema::create('contact_messages', function (Blueprint $table) {
                $table->id();
                $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete();
                $table->string('first_name');
                $table->string('last_name');
                $table->string('company')->nullable();
                $table->string('phone')->nullable();
                $table->string('email');
                $table->string('subject')->nullable();
                $table->string('budget_range')->nullable();
                $table->string('move_in_timeline')->nullable();
                $table->text('message');
                $table->timestamps();
            });

            return;
        }

        Schema::table('contact_messages', function (Blueprint $table) {
            if (! Schema::hasColumn('contact_messages', 'service_id')) {
                $table->foreignId('service_id')->nullable()->after('id')->constrained('services')->nullOnDelete();
            }
            if (! Schema::hasColumn('contact_messages', 'company')) {
                $table->string('company')->nullable()->after('last_name');
            }
            if (! Schema::hasColumn('contact_messages', 'budget_range')) {
                $table->string('budget_range')->nullable()->after('subject');
            }
            if (! Schema::hasColumn('contact_messages', 'move_in_timeline')) {
                $table->string('move_in_timeline')->nullable()->after('budget_range');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('contact_messages')) {
            return;
        }

        Schema::table('contact_messages', function (Blueprint $table) {
            if (Schema::hasColumn('contact_messages', 'service_id')) {
                $table->dropForeign(['service_id']);
            }
        });

        Schema::table('contact_messages', function (Blueprint $table) {
            foreach (['move_in_timeline', 'budget_range', 'company', 'service_id'] as $col) {
                if (Schema::hasColumn('contact_messages', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
