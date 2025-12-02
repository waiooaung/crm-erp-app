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
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are an Asset Classifier. Analyze the asset name.
                    Return ONLY a precise hierarchical category string in the format: "Parent Category > Child Category".

                    Examples:
                    - Input: "MacBook Pro" -> Output: "Electronics > Laptop"
                    - Input: "Nespresso Machine" -> Output: "Kitchen > Appliance"
                    - Input: "Herman Miller Chair" -> Output: "Furniture > Seating"
                    - Input: "Daikin AC Unit" -> Output: "HVAC > Air Conditioner"
                    ',
                ],
                ['role' => 'user', 'content' => "Asset Name: $assetName"]],
            ]
        );
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
                'content' => 'You are an expert General Asset & Operations Manager.
                You manage a diverse inventory ranging from IT Electronics (Laptops, Servers) to Facility Equipment (Kitchen Appliances, HVAC, Furniture).

                Analyze the asset details provided. Write a concise, professional 2-sentence summary.

                Guidelines:
                1. Identify the Main Category (e.g., "Electronics > Laptop" or "Kitchen > Appliance").
                2. Adapt the summary based on the type:
                - IT Assets: Focus on specs, user assignment, and warranty.
                - Facility/Kitchen (e.g., Coffee Maker, AC): Focus on operational status (Functional/Broken) and maintenance needs.
                - Furniture: Focus on condition and location.

                Example Output: "Industrial-grade coffee maker located in the Main Pantry; currently operational but requires descaling maintenance."',
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
                    'content' => 'You are an intelligent Facility & IT Operations Manager. Analyze the reported issue description.
                    The issue could come from any department and involve any type of asset (e.g., Laptops, Air Conditioners, Plumbing, Vehicles, Furniture).

                    Return a STRICT JSON object with two keys:
                    1. "classification" (Choose the best fit:
                    - "IT Hardware" (Computers, Printers)
                    - "Software/Network" (Internet, Apps)
                    - "HVAC" (Air Conditioning, Heating, Ventilation)
                    - "Electrical" (Lights, Power Sockets)
                    - "Plumbing/Water" (Leaks, Taps)
                    - "General Maintenance" (Broken Furniture, Doors, Paint)
                    - "Other")

                    2. "priority" (One of: LOW, MEDIUM, HIGH, CRITICAL).

                    Priority Logic:
                    - CRITICAL: Immediate safety hazard (Fire, Sparks, Gas Leak) or Security breach.
                    - HIGH: Asset is completely dead or causing work stoppage (e.g., Server down, AC broken in server room/heatwave).
                    - MEDIUM: Asset is working but performance is degraded (e.g., AC not cooling well, noisy fan, slow computer).
                    - LOW: Cosmetic issues, general inquiries, or minor discomfort.',
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
