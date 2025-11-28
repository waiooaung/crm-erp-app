<?php

namespace App\Filament\Widgets;

use App\Models\Asset;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AssetStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [Stat::make('Total Assets', Asset::count()), Stat::make('Available Assets', Asset::where('status', 'AVAILABLE')->count()), Stat::make('Assigned Assets', Asset::where('status', 'ASSIGNED')->count()), Stat::make('Expiring Warranty', Asset::whereDate('warranty_expiry', '<=', now()->addMonth())->count())];
    }
}
