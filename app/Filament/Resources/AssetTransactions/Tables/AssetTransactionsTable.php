<?php

namespace App\Filament\Resources\AssetTransactions\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AssetTransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('asset.name')
                    ->label('Asset')
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('User')
                    ->sortable(),
                TextColumn::make('department.name')
                    ->label('Department')
                    ->sortable(),
                TextColumn::make('action')
                    ->badge(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ]);
    }
}
