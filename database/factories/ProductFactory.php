<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2, true),
            'price' => $this->faker->numberBetween(10000, 100000),
            'status' => 'pending', // default pending untuk seeder
            'user_id' => 1, // sesuaikan dengan user yang sudah ada
        ];
    }
}
