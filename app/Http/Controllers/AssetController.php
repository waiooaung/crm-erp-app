<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Services\AssetAIService;

class AssetController extends Controller
{
    public function aiSummary(Asset $asset)
    {
        $summary = AssetAIService::generateSummary($asset);

        return response()->json([
            'summary' => $summary,
        ]);
    }
}
