<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Tambah kolom bukti foto pengiriman
        Schema::table('order_items', function (Blueprint $table) {
            $table->string('admin_delivery_proof')->nullable()->after('admin_transfer_proof');
        });

        // Tambah status enum baru
        DB::statement("
            ALTER TABLE order_items
            MODIFY status ENUM(
                'waiting_admin_confirmation',
                'accepted_by_admin',
                'rejected_by_admin',
                'in_process_by_customer',
                'shipped_by_customer',
                'shipped_by_admin',
                'delivering',
                'received_by_buyer',
                'cancelled_by_buyer',
                'return_requested',
                'return_approved',
                'refunded'
            ) NOT NULL
        ");
    }

    public function down(): void
    {
        // Hapus kolom
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('admin_delivery_proof');
        });

        // Rollback enum ke versi sebelumnya
        DB::statement("
            ALTER TABLE order_items
            MODIFY status ENUM(
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
            ) NOT NULL
        ");
    }
};
