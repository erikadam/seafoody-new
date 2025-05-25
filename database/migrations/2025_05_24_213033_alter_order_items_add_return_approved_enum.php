<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("ALTER TABLE order_items MODIFY COLUMN status ENUM(
            'waiting_admin_confirmation',
            'accepted_by_admin',
            'rejected_by_admin',
            'in_process_by_customer',
            'shipped_by_customer',
            'received_by_buyer',
            'cancelled_by_buyer',
            'return_requested',
            'return_approved',
            'refunded'
        ) NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE order_items MODIFY COLUMN status ENUM(
            'waiting_admin_confirmation',
            'accepted_by_admin',
            'rejected_by_admin',
            'in_process_by_customer',
            'shipped_by_customer',
            'received_by_buyer',
            'cancelled_by_buyer',
            'return_requested',
            'refunded'
        ) NOT NULL");
    }
};
