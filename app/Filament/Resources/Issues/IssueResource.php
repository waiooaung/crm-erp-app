<?php

namespace App\Filament\Resources\Issues;

use App\Filament\Resources\Issues\Pages\CreateIssue;
use App\Filament\Resources\Issues\Pages\EditIssue;
use App\Filament\Resources\Issues\Pages\ListIssues;
use App\Filament\Resources\Issues\RelationManagers\ActivitiesRelationManager;
use App\Filament\Resources\Issues\Schemas\IssueForm;
use App\Filament\Resources\Issues\Tables\IssuesTable;
use App\Models\Issue;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class IssueResource extends Resource
{
    protected static ?string $model = Issue::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedExclamationTriangle;

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'description';

    public static function getGloballySearchableAttributes(): array
    {
        return [
            'description',
            'priority',
            'classification',
            'asset.name', // ✨ Search by the name of the broken asset
        ];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        /** @var Issue $record */
        return [
            'Priority' => $record->priority,
            'Status' => $record->status,
            'Asset' => $record->asset?->name,
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return IssueForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return IssuesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [ActivitiesRelationManager::class];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListIssues::route('/'),
            'create' => CreateIssue::route('/create'),
            'edit' => EditIssue::route('/{record}/edit'),
        ];
    }
}
