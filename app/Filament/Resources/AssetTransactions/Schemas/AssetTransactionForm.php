<?php

namespace App\Filament\Resources\AssetTransactions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AssetTransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('asset_id')
                    ->required()
                    ->numeric(),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('department_id')
                    ->numeric(),
                Select::make('action')
                    ->options([
            'ASSIGNED' => 'A s s i g n e d',
            'RETURNED' => 'R e t u r n e d',
            'MAINTENANCE' => 'M a i n t e n a n c e',
        ])
                    ->required(),
                Textarea::make('note')
                    ->columnSpanFull(),
            ]);
    }
}
