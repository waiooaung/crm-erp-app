<?php

namespace App\Filament\Resources\Assets\RelationManagers;

use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms; // Keep this for the ViewAction inside the table
use Illuminate\Database\Eloquent\Model;

class ActivitiesRelationManager extends RelationManager
{
    protected static string $relationship = 'activities';

    protected static ?string $recordTitleAttribute = 'action';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('User')->icon('heroicon-m-user'),

                TextColumn::make('action')
                    ->badge()
                    ->colors([
                        'success' => 'created',
                        'warning' => 'updated',
                        'danger' => 'deleted',
                    ])
                    ->formatStateUsing(fn(string $state): string => ucfirst($state)),

                TextColumn::make('changes')->limit(50)->tooltip(fn(Model $record) => json_encode($record->changes)),

                TextColumn::make('created_at')->label('Occurred')->dateTime()->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                // The View Action allows us to see details in a modal
                // without needing the main form() method.
                ViewAction::make()->form([Forms\Components\KeyValue::make('changes')->label('Changed Attributes')]),
            ]);
    }
}
