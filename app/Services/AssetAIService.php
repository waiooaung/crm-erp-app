<?php

namespace App\Services;

use App\Models\Asset;
use OpenAI\Laravel\Facades\OpenAI;

class AssetAIService
{
    public static function generateSummary(Asset $asset): string
    {
        $assignedUserName = $asset->assignedUser?->name ?? 'None';
        $assignedDeptName = $asset->assignedDepartment?->name ?? 'None';

        $prompt =
            "Generate a short 2–3 sentence summary of this asset:
                Name: {$asset->name}
                Category: {$asset->category}
                Status: {$asset->status}
                Assigned to User: {$assignedUserName}
                Assigned to Department: {$assignedDeptName}
                Warranty Expiry: " .
            ($asset->warranty_expiry?->toDateString() ?? 'N/A');

        $response = OpenAI::responses()->create([
            'model' => 'gpt-4o',
            'input' => $prompt,
        ]);

        return $response->outputText;
    }
}
