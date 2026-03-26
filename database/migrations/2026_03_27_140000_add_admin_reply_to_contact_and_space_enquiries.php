<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('contact_messages')) {
            $afterContact = Schema::hasColumn('contact_messages', 'visit_time_preference')
                ? 'visit_time_preference'
                : 'message';
            Schema::table('contact_messages', function (Blueprint $table) use ($afterContact) {
                if (! Schema::hasColumn('contact_messages', 'status')) {
                    $table->string('status', 20)->default('pending')->after($afterContact);
                }
                if (! Schema::hasColumn('contact_messages', 'admin_response')) {
                    $table->text('admin_response')->nullable()->after('status');
                }
                if (! Schema::hasColumn('contact_messages', 'responded_at')) {
                    $table->timestamp('responded_at')->nullable()->after('admin_response');
                }
                if (! Schema::hasColumn('contact_messages', 'responded_by')) {
                    $table->foreignId('responded_by')->nullable()->after('responded_at')->constrained('users')->nullOnDelete();
                }
            });
        }

        if (Schema::hasTable('space_to_let_enquiries')) {
            $afterSpace = Schema::hasColumn('space_to_let_enquiries', 'visit_time_preference')
                ? 'visit_time_preference'
                : 'message';
            Schema::table('space_to_let_enquiries', function (Blueprint $table) use ($afterSpace) {
                if (! Schema::hasColumn('space_to_let_enquiries', 'status')) {
                    $table->string('status', 20)->default('pending')->after($afterSpace);
                }
                if (! Schema::hasColumn('space_to_let_enquiries', 'admin_response')) {
                    $table->text('admin_response')->nullable()->after('status');
                }
                if (! Schema::hasColumn('space_to_let_enquiries', 'responded_at')) {
                    $table->timestamp('responded_at')->nullable()->after('admin_response');
                }
                if (! Schema::hasColumn('space_to_let_enquiries', 'responded_by')) {
                    $table->foreignId('responded_by')->nullable()->after('responded_at')->constrained('users')->nullOnDelete();
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('contact_messages')) {
            Schema::table('contact_messages', function (Blueprint $table) {
                if (Schema::hasColumn('contact_messages', 'responded_by')) {
                    $table->dropForeign(['responded_by']);
                }
                foreach (['responded_by', 'responded_at', 'admin_response', 'status'] as $col) {
                    if (Schema::hasColumn('contact_messages', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }

        if (Schema::hasTable('space_to_let_enquiries')) {
            Schema::table('space_to_let_enquiries', function (Blueprint $table) {
                if (Schema::hasColumn('space_to_let_enquiries', 'responded_by')) {
                    $table->dropForeign(['responded_by']);
                }
                foreach (['responded_by', 'responded_at', 'admin_response', 'status'] as $col) {
                    if (Schema::hasColumn('space_to_let_enquiries', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }
    }
};
