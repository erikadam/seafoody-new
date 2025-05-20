<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('buyer_name');
            $table->string('buyer_phone');
            $table->text('buyer_address');
            $table->enum('payment_method', ['cash', 'transfer']);
            $table->string('transfer_proof')->nullable(); // bukti transfer (jika transfer)
            $table->enum('status', [
                'waiting_admin_confirmation', // admin mengecek pesanan / bukti transfer
                'accepted_by_admin',
                'rejected_by_admin',
                'in_process_by_customer',
                'shipped_by_customer',
                'received_by_buyer',
                'completed',
                'cancelled_by_buyer',
            ])->default('waiting_admin_confirmation');
            $table->text('product_list')->nullable();
            $table->bigInteger('total_price')->default(0);
            $table->string('token')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
