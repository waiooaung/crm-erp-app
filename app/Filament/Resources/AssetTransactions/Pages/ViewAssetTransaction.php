<?php

namespace App\Filament\Resources\AssetTransactions\Pages;

use App\Filament\Resources\AssetTransactions\AssetTransactionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAssetTransaction extends ViewRecord
{
    protected static string $resource = AssetTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
