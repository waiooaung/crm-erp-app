<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Issue;

class IssueSeeder extends Seeder
{
    public function run(): void
    {
        Issue::create([
            'asset_id' => 3, // iPhone 14 Pro
            'user_id' => 2, // Alicia Ramirez
            'description' => 'Screen cracked during handling',
            'priority' => 'CRITICAL',
            'status' => 'Open',
        ]);

        Issue::create([
            'asset_id' => 2, // HP Printer
            'user_id' => 3, // David Kim
            'description' => 'Paper jam frequently',
            'priority' => 'MEDIUM',
            'status' => 'IN_PROGRESS',
        ]);

        Issue::create([
            'asset_id' => 1, // Dell Laptop
            'user_id' => 1, // Samuel Carter (Admin)
            'description' => 'Battery draining quickly',
            'priority' => 'MEDIUM',
            'status' => 'RESOLVED',
        ]);
    }
}
