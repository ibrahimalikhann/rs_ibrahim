<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ClientDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the demo users for each role
        $users = [
            [
                'name' => 'Owner Admin',
                'email' => 'owner@gmail.com',
                'password' => 'password',
                'role' => 'admin',
            ],
            [
                'name' => 'Rajesh VP',
                'email' => 'vp@gmail.com',
                'password' => 'password',
                'role' => 'vp',
            ],
            [
                'name' => 'Vikram Head GEO',
                'email' => 'geo@gmail.com',
                'password' => 'password',
                'role' => 'geo-head',
            ],
            [
                'name' => 'Suresh TL',
                'email' => 'tl@gmail.com',
                'password' => 'password',
                'role' => 'team-leader',
            ],
            [
                'name' => 'Amit Executive',
                'email' => 'executive@gmail.com',
                'password' => 'password',
                'role' => 'executive',
            ],
        ];

        foreach ($users as $userData) {
            // Check if user exists to avoid duplicates
            $user = User::where('email', $userData['email'])->first();
            
            if (!$user) {
                User::create([
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'password' => Hash::make($userData['password']),
                    'role' => $userData['role'],
                ]);
            } else {
                // Update role just in case
                $user->update(['role' => $userData['role']]);
            }
        }
    }
}
