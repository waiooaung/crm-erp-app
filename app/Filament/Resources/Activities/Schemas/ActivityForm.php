<?php

namespace App\Filament\Resources\Activities\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ActivityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('entity')
                    ->required(),
                TextInput::make('entity_id')
                    ->required()
                    ->numeric(),
                TextInput::make('action')
                    ->required(),
                TextInput::make('changes'),
            ]);
    }
}
