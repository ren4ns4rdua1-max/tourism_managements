<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create default admin if doesn't exist
        if (!User::where('email', 'admin@toureasepro.com')->exists()) {
            User::create([
                'name' => 'Super Admin',
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'email' => 'admin@toureasepro.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);
        }

        // Create default manager if doesn't exist
        if (!User::where('email', 'manager@toureasepro.com')->exists()) {
            User::create([
                'name' => 'Site Manager',
                'first_name' => 'Site',
                'last_name' => 'Manager',
                'email' => 'manager@toureasepro.com',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'email_verified_at' => now(),
            ]);
        }
    }
}

