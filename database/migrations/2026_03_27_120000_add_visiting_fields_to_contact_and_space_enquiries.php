<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('contact_messages')) {
            Schema::table('contact_messages', function (Blueprint $table) {
                if (! Schema::hasColumn('contact_messages', 'visiting_space')) {
                    $table->boolean('visiting_space')->default(false)->after('message');
                }
                if (! Schema::hasColumn('contact_messages', 'visit_time_preference')) {
                    $table->string('visit_time_preference')->nullable()->after('visiting_space');
                }
            });
        }

        if (Schema::hasTable('space_to_let_enquiries')) {
            Schema::table('space_to_let_enquiries', function (Blueprint $table) {
                if (! Schema::hasColumn('space_to_let_enquiries', 'visiting_space')) {
                    $table->boolean('visiting_space')->default(false)->after('message');
                }
                if (! Schema::hasColumn('space_to_let_enquiries', 'visit_time_preference')) {
                    $table->string('visit_time_preference')->nullable()->after('visiting_space');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('contact_messages')) {
            Schema::table('contact_messages', function (Blueprint $table) {
                if (Schema::hasColumn('contact_messages', 'visit_time_preference')) {
                    $table->dropColumn('visit_time_preference');
                }
                if (Schema::hasColumn('contact_messages', 'visiting_space')) {
                    $table->dropColumn('visiting_space');
                }
            });
        }

        if (Schema::hasTable('space_to_let_enquiries')) {
            Schema::table('space_to_let_enquiries', function (Blueprint $table) {
                if (Schema::hasColumn('space_to_let_enquiries', 'visit_time_preference')) {
                    $table->dropColumn('visit_time_preference');
                }
                if (Schema::hasColumn('space_to_let_enquiries', 'visiting_space')) {
                    $table->dropColumn('visiting_space');
                }
            });
        }
    }
};
