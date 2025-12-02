<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Asset;

class AssetSeeder extends Seeder
{
    public function run(): void
    {
        Asset::firstOrCreate(
            ['serial_number' => 'DLXPS-001'],
            [
                'name' => 'Dell Laptop XPS 13',
                'status' => 'IN_STOCK',
                'assigned_to_user_id' => null,
                'assigned_to_department_id' => 2, // IT Department
            ]
        );

        Asset::firstOrCreate(
            ['serial_number' => 'HP-PR-101'],
            [
                'name' => 'HP LaserJet Printer',
                'status' => 'ASSIGNED',
                'assigned_to_user_id' => 3, // David Kim
                'assigned_to_department_id' => 4, // Operations
            ]
        );

        Asset::firstOrCreate(
            ['serial_number' => 'IP14-2023-01'],
            [
                'name' => 'iPhone 14 Pro',
                'status' => 'MAINTENANCE',
                'assigned_to_user_id' => 2, // Alicia Ramirez
                'assigned_to_department_id' => 1, // HR
            ]
        );
    }
}
