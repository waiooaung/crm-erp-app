<?php

namespace App\Filament\Resources\Assets\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class TransactionsRelationManager extends RelationManager
{
    protected static string $relationship = 'assetTransactions';
    protected static ?string $recordTitleAttribute = 'action';

    public function table(Table $table): Table
    {
        return $table->columns([TextColumn::make('action')->label('Action'), TextColumn::make('user.name')->label('Performed By'), TextColumn::make('department.name')->label('Department'), TextColumn::make('created_at')->dateTime()->label('Date')])->defaultSort('created_at', 'desc');
    }
}
