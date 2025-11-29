<?php

namespace App\Filament\Resources\Assets\Pages;

use App\Filament\Resources\Assets\AssetResource;
use App\Models\File;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAsset extends EditRecord
{
    protected static string $resource = AssetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $attachments = $this->data['attachments'] ?? [];

        foreach ($attachments as $filePath) {
            File::create([
                'asset_id' => $this->record->getKey(),
                'file_name' => basename($filePath),
                'file_path' => $filePath,
            ]);
        }
    }
}
