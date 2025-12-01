<?php

namespace App\Filament\Resources\Assets\Pages;

use App\Filament\Resources\Assets\AssetResource;
use App\Models\File;
use Filament\Resources\Pages\CreateRecord;

class CreateAsset extends CreateRecord
{
    protected static string $resource = AssetResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
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
