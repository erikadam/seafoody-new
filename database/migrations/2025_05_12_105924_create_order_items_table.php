<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->integer('quantity');
            $table->bigInteger('price');
            $table->enum('status', [
                'waiting_admin_confirmation',
                'accepted_by_admin',
                'rejected_by_admin',
                'in_process_by_customer',
                'shipped_by_customer',
                'received_by_buyer',
                'completed',
                'cancelled_by_buyer'
            ])->default('waiting_admin_confirmation');
            $table->string('admin_transfer_proof')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('admin_transfer_approved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
