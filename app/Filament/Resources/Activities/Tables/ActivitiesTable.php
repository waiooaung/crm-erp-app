<?php

namespace App\Filament\Resources\Activities\Tables;

use App\Models\Asset;
use App\Models\Issue;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Str;

class ActivitiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
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
                        if ($record->entity === 'issue') {
                            return Issue::find($state)?->description ?? '—';
                        }

                        return $state;
                    })
                    ->sortable(),
                TextColumn::make('changes')
                    ->label('Changes')
                    ->wrap()
                    ->html()
                    ->state(function ($record) {
                        if ($record->action === 'CREATED') return 'New Record Created';
                        if (empty($record->changes)) return '—';

                        $changes = \is_array($record->changes) ? $record->changes : json_decode($record->changes, true);
                        if (!$changes) return '—';

                        $lines = [];
                        foreach ($changes as $field => $values) {
                            if ($field === 'updated_at') continue;

                            $fieldName = \Illuminate\Support\Str::of($field)->replace('_', ' ')->title();
                            $from = $values['from'] ?? '—';
                            $to = $values['to'] ?? '—';

                            $lines[] = "{$fieldName}: {$from} &rarr; {$to}";
                        }

                        return implode('<br>', $lines);
                    }),
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
