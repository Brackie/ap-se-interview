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
        \App\Models\User::factory(100)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        \App\Models\SubscriptionPlan::create([
            "name" => "Monthly",
            "price" => 1000,
            "validity" => 30,
            "description" => "This is a monthly subscription!"
        ]);

        \App\Models\SubscriptionPlan::create([
            "name" => "Yearly",
            "price" => 10000,
            "validity" => 365,
            "description" => "This is an yearly subscription!"
        ]);

    }
}
