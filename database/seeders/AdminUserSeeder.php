<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@tourism.com'],
            [
                'name' => 'Super Admin',
                'email' => 'admin@tourism.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'manager@tourism.com'],
            [
                'name' => 'Transportation Manager',
                'email' => 'manager@tourism.com',
                'password' => Hash::make('password'),
                'role' => 'manager',
            ]
        );
    }
}
