<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), 
            'product_name' => $this->faker->word(),
            'amount' => $this->faker->numberBetween(10000, 500000),
        ];
    }
}