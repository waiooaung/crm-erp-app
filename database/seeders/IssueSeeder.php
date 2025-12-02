<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Issue;

class IssueSeeder extends Seeder
{
    public function run(): void
    {
        // Issue 1
        Issue::firstOrCreate(
            [
                'asset_id' => 3,
                'description' => 'Screen cracked during handling'
            ],
            [
                'user_id' => 2, // Alicia Ramirez
                'priority' => 'CRITICAL',
                'status' => 'Open',
            ]
        );

        // Issue 2
        Issue::firstOrCreate(
            [
                'asset_id' => 2,
                'description' => 'Paper jam frequently'
            ],
            [
                'user_id' => 3, // David Kim
                'priority' => 'MEDIUM',
                'status' => 'IN_PROGRESS',
            ]
        );

        // Issue 3
        Issue::firstOrCreate(
            [
                'asset_id' => 1,
                'description' => 'Battery draining quickly'
            ],
            [
                'user_id' => 1, // Samuel Carter (Admin)
                'priority' => 'MEDIUM',
                'status' => 'RESOLVED',
            ]
        );
    }
}
