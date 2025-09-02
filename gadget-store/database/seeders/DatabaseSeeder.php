<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Sales;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Only create test user if it doesn't exist
        if (User::where('email', 'test@example.com')->doesntExist()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        // Only create products if none exist
        if (Product::count() == 0) {
            Product::factory(10)->create();
        }

        // Seed 20 sales
        Sales::factory(20)->create();
    }
}
