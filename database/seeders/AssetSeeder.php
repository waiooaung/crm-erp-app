<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Asset;
use App\Models\User;

class AssetSeeder extends Seeder
{
    public function run(): void
    {
        Asset::create([
            'name' => 'Dell Laptop XPS 13',
            'serial_number' => 'DLXPS-001',
            'status' => 'IN_STOCK',
            'assigned_to_user_id' => null,
            'assigned_to_department_id' => 2, // IT Department
        ]);

        Asset::create([
            'name' => 'HP LaserJet Printer',
            'serial_number' => 'HP-PR-101',
            'status' => 'ASSIGNED',
            'assigned_to_user_id' => 3, // David Kim
            'assigned_to_department_id' => 4, // Operations
        ]);

        Asset::create([
            'name' => 'iPhone 14 Pro',
            'serial_number' => 'IP14-2023-01',
            'status' => 'MAINTENANCE',
            'assigned_to_user_id' => 2, // Alicia Ramirez
            'assigned_to_department_id' => 1, // HR
        ]);
    }
}
