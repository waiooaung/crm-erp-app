<?php

namespace App\Filament\Resources\Files\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

class FilesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([TextColumn::make('asset.name')->label('Asset')->sortable()->searchable(), ImageColumn::make('file_path')->label('File')->disk('public')->height(50)->width(50)->toggleable(), TextColumn::make('file_name')->searchable(), TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true), TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true)])
            ->filters([
                //
            ])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
