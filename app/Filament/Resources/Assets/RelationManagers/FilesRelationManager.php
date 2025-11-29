<?php

namespace App\Filament\Resources\Assets\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FilesRelationManager extends RelationManager
{
    protected static string $relationship = 'files';
    protected static ?string $recordTitleAttribute = 'file_name';

    public function table(Table $table): Table
    {
        return $table->columns([TextColumn::make('file_name')->label('File Name'), ImageColumn::make('file_path')->disk('public')->label('Preview'), TextColumn::make('created_at')->dateTime()->label('Uploaded At')])->bulkActions([DeleteBulkAction::make()]);
    }
}
