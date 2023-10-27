<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Test Manager',
            'email' => 'test@example.com',
            'is_manager' => true,
            'image_link' => 'https://placehold.co/200x200',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'is_manager' => false,
            'image_link' => 'https://placehold.co/200x200',
        ]);

        \App\Models\Customer::factory(20)->create();
        \App\Models\Product::factory(20)->create();

        $this->call([
            OrdersSeeder::class
        ]);
    }
}
