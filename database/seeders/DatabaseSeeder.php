<?php

namespace Database\Seeders;

use Database\Seeders\PendingProductsSeeder;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat 1 user
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'), // wajib isi password jika membuat baru
                'email_verified_at' => now(),
            ]
        );

        // Jalankan seeder produk pending
        $this->call([
            PendingProductsSeeder::class,
        ]);
    }
}
