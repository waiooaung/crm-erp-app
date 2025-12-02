<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Samuel Carter',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'ADMIN',
                'department_id' => null,
            ]
        );

        // Manager
        User::firstOrCreate(
            ['email' => 'alicia.ramirez@example.com'],
            [
                'name' => 'Alicia Ramirez',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'MANAGER',
                'department_id' => 1,
            ]
        );

        // Staff 1
        User::firstOrCreate(
            ['email' => 'david.kim@example.com'],
            [
                'name' => 'David Kim',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'STAFF',
                'department_id' => 2,
            ]
        );

        // Staff 2
        User::firstOrCreate(
            ['email' => 'emma.wilson@example.com'],
            [
                'name' => 'Emma Wilson',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'STAFF',
                'department_id' => 1,
            ]
        );
    }
}
