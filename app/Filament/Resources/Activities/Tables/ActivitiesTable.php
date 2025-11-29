<?php

namespace App\Filament\Resources\Activities\Tables;

use App\Models\Asset;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ActivitiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('User')
                    ->sortable(),
                TextColumn::make('entity')
                    ->searchable(),
                TextColumn::make('entity_id')
                    ->label('Entity Data')
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->entity === 'asset') {
                            return Asset::find($state)?->name ?? '—';
                        }

                        return $state;
                    })
                    ->sortable(),
                TextColumn::make('action')
                    ->searchable(),
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
