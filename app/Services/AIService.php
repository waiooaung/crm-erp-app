<?php

namespace App\Services;

use App\Models\Asset;
use OpenAI\Laravel\Facades\OpenAI;

class AIService
{
    public function suggestCategory(string $assetName)
    {
        $result = OpenAI::chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => [['role' => 'system', 'content' => 'Return only the category name (e.g., "Electronics", "Furniture", "Vehicle") for this asset.'], ['role' => 'user', 'content' => "Asset Name: $assetName"]],
        ]);
        return $result->choices[0]->message->content;
    }

    public function generateAssetSummary(Asset $asset): string
    {
        $asset->load(['assignedUser', 'assignedDepartment', 'assetTransactions']);

        $dataContext = [
            'Name' => $asset->name,
            'Category' => $asset->category,
            'Status' => $asset->status,
            'Value' => $asset->value,
            'Assigned User' => $asset->assignedUser?->name ?? 'Unassigned',
            'Department' => $asset->assignedDepartment?->name ?? 'None',
            'Warranty Expiry' => $asset->warranty_expiry?->format('Y-m-d'),
            'Recent Activity' => $asset->assetTransactions->take(3)->map(fn($t) => "{$t->action} on {$t->created_at->format('Y-m-d')}")->implode(', '),
        ];

        $promptData = json_encode($dataContext);

        $response = OpenAI::chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are an IT Asset Manager. Write a concise, professional 2-sentence summary of this asset. Focus on its current availability, who has it, and its financial/warranty status.',
                ],
                [
                    'role' => 'user',
                    'content' => "Analyze this asset data: $promptData",
                ],
            ],
            'temperature' => 0.5,
        ]);

        return $response->choices[0]->message->content;
    }

    public function classifyIssue(string $description): array
    {
        $response = OpenAI::chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are an IT Support Manager or Admin Manager. Analyze the issue description.
                    Return a JSON object with two keys:
                    1. "classification" (One of: Hardware, Software, Network, User Error, Other)
                    2. "priority" (One of: LOW, MEDIUM, HIGH, CRITICAL).

                    Rules:
                    - Fire/Safety/Security = CRITICAL
                    - Total device failure = HIGH
                    - Glitches/Slowness = MEDIUM
                    - Cosmetic/Questions = LOW',
                ],
                [
                    'role' => 'user',
                    'content' => $description,
                ],
            ],
            'response_format' => ['type' => 'json_object'],
        ]);

        return json_decode($response->choices[0]->message->content, true);
    }
}
