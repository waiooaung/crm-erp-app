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
        User::create([
            'name' => 'Samuel Carter',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'ADMIN',
            'department_id' => null,
        ]);

        // Manager
        User::create([
            'name' => 'Alicia Ramirez',
            'email' => 'alicia.ramirez@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'MANAGER',
            'department_id' => 1,
        ]);

        // Staff
        User::create([
            'name' => 'David Kim',
            'email' => 'david.kim@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'STAFF',
            'department_id' => 2,
        ]);

        // Staff
        User::create([
            'name' => 'Emma Wilson',
            'email' => 'emma.wilson@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'STAFF',
            'department_id' => 1,
        ]);
    }
}
