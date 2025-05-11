<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // pemilik produk
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('image')->nullable();
            $table->enum('status', ['pending', 'approved'])->default('pending');

            // Field tambahan
            $table->enum('category', ['bahan', 'makanan'])->nullable();
            $table->unsignedInteger('stock')->default(0);
            $table->string('shipping_zone')->nullable(); // Gresik Utara, Selatan, dst
            $table->timestamp('uploaded_at')->nullable();
            $table->unsignedInteger('sold_count')->default(0);
            $table->enum('availability', ['ready', 'habis', 'preorder'])->default('ready');
            $table->date('available_date')->nullable(); // hanya untuk preorder

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
