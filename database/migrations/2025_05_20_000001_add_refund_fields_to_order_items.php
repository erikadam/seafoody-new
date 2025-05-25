<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->boolean('refund_requested')->default(false)->after('status');
            $table->timestamp('refund_requested_at')->nullable()->after('refund_requested');
            $table->text('refund_reason')->nullable()->after('refund_requested_at');
            $table->string('refund_bank_name')->nullable()->after('refund_reason');
            $table->string('refund_account_name')->nullable()->after('refund_bank_name');
            $table->string('refund_account_number')->nullable()->after('refund_account_name');
            $table->timestamp('refunded_at')->nullable()->after('refund_account_number');
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn([
                'refund_requested',
                'refund_requested_at',
                'refund_reason',
                'refund_bank_name',
                'refund_account_name',
                'refund_account_number',
                'refunded_at',
            ]);
        });
    }
};
