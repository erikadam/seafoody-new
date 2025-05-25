<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // ✅ Tambahkan ini

class AlterOrderItemsStatusEnumAddReturnRequested extends Migration
{
    public function up()
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

    public function down()
    {
        DB::statement("ALTER TABLE order_items MODIFY COLUMN status ENUM(
            'waiting_admin_confirmation',
            'accepted_by_admin',
            'rejected_by_admin',
            'in_process_by_customer',
            'shipped_by_customer',
            'received_by_buyer',
            'cancelled_by_buyer',
            'refunded'
        ) NOT NULL");
    }
}
