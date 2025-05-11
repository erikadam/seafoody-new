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
    Schema::create('store_ratings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // penjual
        $table->foreignId('customer_id')->constrained('users')->onDelete('cascade'); // pembeli
        $table->tinyInteger('rating')->comment('1 to 5');
        $table->text('review')->nullable();
        $table->timestamps();

        $table->unique(['user_id', 'customer_id']); // 1 pembeli hanya bisa menilai 1x
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_ratings');
    }
};
