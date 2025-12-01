<?php

namespace App\Filament\Widgets;

use App\Models\Issue;
use Filament\Widgets\ChartWidget;

class IssuePriorityChart extends ChartWidget
{
    protected ?string $heading = 'Issue Priority Chart';

    protected static ?int $sort = 4;

    protected ?string $maxHeight = '300px';

    protected ?string $pollingInterval = '30s';

    protected function getData(): array
    {
        $data = Issue::query()->selectRaw('priority, count(*) as count')->groupBy('priority')->pluck('count', 'priority')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Issues',
                    'data' => array_values($data),
                    'backgroundColor' => [
                        '#22c55e', // Green (Low)
                        '#eab308', // Yellow (Medium)
                        '#f97316', // Orange (High)
                        '#ef4444', // Red (Critical)
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
