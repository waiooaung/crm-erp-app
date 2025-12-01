<?php

namespace App\Filament\Widgets;

use App\Models\Asset;
use Filament\Widgets\ChartWidget;

class AssetStatusChart extends ChartWidget
{
    protected ?string $heading = 'Asset Status Overview';

    protected static ?int $sort = 3;

    protected ?string $maxHeight = '300px';

    protected ?string $pollingInterval = '30s';

    protected function getData(): array
    {
        $data = Asset::query()->selectRaw('status, count(*) as count')->groupBy('status')->pluck('count', 'status')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Assets',
                    'data' => array_values($data),
                    'backgroundColor' => [
                        '#10b981', // In Stock (Green)
                        '#3b82f6', // Assigned (Blue)
                        '#f59e0b', // Maintenance (Orange)
                        '#ef4444', // Lost (Red)
                        '#6b7280', // Retired (Gray)
                    ],
                ],
            ],
            'labels' => array_keys($data),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
