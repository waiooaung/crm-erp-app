<?php

namespace App\Filament\Resources\AssetTransactions;

use App\Filament\Resources\AssetTransactions\Pages\CreateAssetTransaction;
use App\Filament\Resources\AssetTransactions\Pages\EditAssetTransaction;
use App\Filament\Resources\AssetTransactions\Pages\ListAssetTransactions;
use App\Filament\Resources\AssetTransactions\Pages\ViewAssetTransaction;
use App\Filament\Resources\AssetTransactions\Schemas\AssetTransactionForm;
use App\Filament\Resources\AssetTransactions\Schemas\AssetTransactionInfolist;
use App\Filament\Resources\AssetTransactions\Tables\AssetTransactionsTable;
use App\Models\AssetTransaction;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AssetTransactionResource extends Resource
{
    protected static ?string $model = AssetTransaction::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static ?string $recordTitleAttribute = 'Asset Transaction';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return AssetTransactionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AssetTransactionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AssetTransactionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAssetTransactions::route('/'),
            'create' => CreateAssetTransaction::route('/create'),
            'view' => ViewAssetTransaction::route('/{record}'),
            'edit' => EditAssetTransaction::route('/{record}/edit'),
        ];
    }
}
