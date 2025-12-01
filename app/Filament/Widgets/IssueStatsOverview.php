<?php

namespace App\Filament\Widgets;

use App\Models\Issue;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class IssueStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 2;

    protected ?string $pollingInterval = '15s';

    protected function getStats(): array
    {
        return [
            Stat::make('Critical Issues', Issue::where('priority', 'CRITICAL')->where('status', 'OPEN')->count())
                ->description('Needs immediate attention')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger') // Red
                ->chart([7, 2, 10, 3, 15, 4, 17]), // Fake trend line for visual effect

            Stat::make('Total Open', Issue::where('status', 'OPEN')->count())
                ->description('Backlog of tickets')
                ->color('primary'), // Blue

            Stat::make('Hardware Faults', Issue::where('classification', 'Hardware')->count())
                ->description('Detected by AI')
                ->icon('heroicon-m-cpu-chip')
                ->color('warning'), // Orange
        ];
    }
}
