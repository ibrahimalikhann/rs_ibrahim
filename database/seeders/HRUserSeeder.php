<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HRUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if HR user already exists
        $existingUser = User::where('email', 'hr@ratnasagar.com')->first();
        
        if (!$existingUser) {
            // HR Manager
            User::factory()->create([
                'name' => 'Anita Desai',
                'email' => 'hr@ratnasagar.com',
                'password' => bcrypt('password'),
                'role' => 'hr',
            ]);
            
            $this->command->info('HR user created successfully!');
        } else {
            $this->command->info('HR user already exists, skipping...');
        }
    }
}
