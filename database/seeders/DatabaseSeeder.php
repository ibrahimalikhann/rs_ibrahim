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
            'name' => 'Suresh Kumar',
            'email' => 'admin@ratnasagar.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // HR Manager
        User::factory()->create([
            'name' => 'Anita Desai',
            'email' => 'hr@ratnasagar.com',
            'password' => bcrypt('password'),
            'role' => 'hr',
        ]);

        // Vice President
        User::factory()->create([
            'name' => 'Rajesh Choudhary',
            'email' => 'vp@ratnasagar.com',
            'password' => bcrypt('password'),
            'role' => 'vp',
        ]);

        // Geo Head
        User::factory()->create([
            'name' => 'Amit Shah',
            'email' => 'geo@ratnasagar.com',
            'password' => bcrypt('password'),
            'role' => 'geo-head',
        ]);

        // Team Leader
        User::factory()->create([
            'name' => 'Suresh Mithun',
            'email' => 'tl@ratnasagar.com',
            'password' => bcrypt('password'),
            'role' => 'team-leader',
        ]);

        // Executive
        User::factory()->create([
            'name' => 'Rahul Sharma',
            'email' => 'exec@ratnasagar.com',
            'password' => bcrypt('password'),
            'role' => 'executive',
        ]);
    }
}
