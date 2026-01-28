<?php

namespace Database\Seeders;

use App\Models\User;
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
        // Admin
        User::factory()->create([
            'name' => 'System Admin',
            'email' => 'admin@ratnasagar.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Vice President
        User::factory()->create([
            'name' => 'Rajesh VP',
            'email' => 'vp@ratnasagar.com',
            'password' => bcrypt('password'),
            'role' => 'vp',
        ]);

        // Geo Head
        User::factory()->create([
            'name' => 'Amit Geo Head',
            'email' => 'geo@ratnasagar.com',
            'password' => bcrypt('password'),
            'role' => 'geo-head',
        ]);

        // Team Leader
        User::factory()->create([
            'name' => 'Suresh TL',
            'email' => 'tl@ratnasagar.com',
            'password' => bcrypt('password'),
            'role' => 'team-leader',
        ]);

        // Executive
        User::factory()->create([
            'name' => 'Rahul Executive',
            'email' => 'exec@ratnasagar.com',
            'password' => bcrypt('password'),
            'role' => 'executive',
        ]);
    }
}
