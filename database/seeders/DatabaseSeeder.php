<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->admin()->create([
            'name' => 'The Administrator',
            'email' => 'admin@example.com',
        ]);

        User::factory()->manager()->create([
            'name' => 'The Manager',
            'email' => 'manager@example.com',
        ]);

        User::factory()->create([
            'name' => 'The User',
            'email' => 'user@example.com',
        ]);

        User::factory(10)
            ->has(Order::factory()->count(3))
            ->create();

        User::factory(5)->inactive()->create();
    }
}
