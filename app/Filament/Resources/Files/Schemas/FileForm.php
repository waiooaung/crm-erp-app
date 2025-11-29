<?php

namespace App\Filament\Resources\Files\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('asset_id')
                    ->required()
                    ->numeric(),
                TextInput::make('file_name')
                    ->required(),
                TextInput::make('file_path')
                    ->required(),
            ]);
    }
}
