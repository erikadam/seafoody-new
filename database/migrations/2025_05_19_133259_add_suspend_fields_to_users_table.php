<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_suspended')->default(false)->after('remember_token'); // [GPT] Status akun
            $table->text('suspend_reason')->nullable()->after('is_suspended');       // [GPT] Alasan suspend
            $table->text('deleted_reason')->nullable()->after('suspend_reason');     // [GPT] Alasan penghapusan
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_suspended', 'suspend_reason', 'deleted_reason']);
        });
    }
};
