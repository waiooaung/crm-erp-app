<?php

namespace App\Filament\Resources\Issues\RelationManagers;

use App\Filament\Resources\Activities\ActivityResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\KeyValue;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ActivitiesRelationManager extends RelationManager
{
    protected static string $relationship = 'activities';

    protected static ?string $relatedResource = ActivityResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('User')->icon('heroicon-m-user'),

                TextColumn::make('entity')
                    ->badge()
                    ->colors([
                        'success' => 'created',
                        'warning' => 'updated',
                        'danger' => 'deleted',
                    ])
                    ->formatStateUsing(fn(string $state): string => ucfirst($state)),

                TextColumn::make('changes')
                    ->label('Changes')
                    ->wrap()
                    ->html()
                    ->state(function ($record) {
                        if ($record->action === 'CREATED') {
                            return 'New Record Created';
                        }
                        if (empty($record->changes)) {
                            return '—';
                        }

                        $changes = \is_array($record->changes) ? $record->changes : json_decode($record->changes, true);
                        if (!$changes) {
                            return '—';
                        }

                        $lines = [];
                        foreach ($changes as $field => $values) {
                            if ($field === 'updated_at') {
                                continue;
                            }

                            $fieldName = \Illuminate\Support\Str::of($field)->replace('_', ' ')->title();
                            $from = $values['from'] ?? '—';
                            $to = $values['to'] ?? '—';

                            $lines[] = "{$fieldName}: {$from} &rarr; {$to}";
                        }

                        return implode('<br>', $lines);
                    }),

                TextColumn::make('created_at')->label('Occurred')->dateTime()->sortable(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
