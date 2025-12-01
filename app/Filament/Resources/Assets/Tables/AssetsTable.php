<?php

namespace App\Filament\Resources\Assets\Tables;

use App\Models\Asset;
use App\Models\AssetTransaction;
use App\Models\Department;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use App\Services\AIService;

class AssetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('category')->searchable(),
                TextColumn::make('serial_number')->searchable(),
                TextColumn::make('status')
                    ->colors([
                        'success' => 'IN_STOCK',
                        'primary' => 'ASSIGNED',
                        'warning' => 'MAINTENANCE',
                        'danger' => 'LOST',
                        'secondary' => 'RETIRED',
                    ])
                    ->badge()
                    ->sortable(),
                TextColumn::make('assignedUser.name')->label('User')->sortable()->searchable(),
                TextColumn::make('assignedDepartment.name')->label('Department')->sortable()->searchable(),
                TextColumn::make('purchase_date')->date()->sortable(),
                TextColumn::make('warranty_expiry')->date()->sortable(),
                TextColumn::make('value')->numeric()->sortable(),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')->options([
                    'IN_STOCK' => 'In Stock',
                    'ASSIGNED' => 'Assigned',
                    'MAINTENANCE' => 'Maintenance',
                    'LOST' => 'Lost/Damaged',
                    'RETIRED' => 'Retired',
                ]),
                SelectFilter::make('assigned_to_department_id')
                    ->label('Department')
                    ->options(Department::all()->pluck('name', 'id')),
            ])
            ->actions([
                EditAction::make(),

                Action::make('assign')
                    ->form([
                        Select::make('assigned_to_user_id')
                            ->label('Assign to User')
                            ->options(User::all()->pluck('name', 'id'))
                            ->required(),
                        Select::make('assigned_to_department_id')
                            ->label('Assign to Department')
                            ->options(Department::all()->pluck('name', 'id'))
                            ->nullable(),
                    ])
                    ->action(function (Asset $record, array $data) {
                        $record->update([
                            'assigned_to_user_id' => $data['assigned_to_user_id'],
                            'assigned_to_department_id' => $data['assigned_to_department_id'] ?? null,
                            'status' => 'ASSIGNED',
                        ]);

                        AssetTransaction::create([
                            'asset_id' => $record->getKey(),
                            'user_id' => $data['assigned_to_user_id'],
                            'department_id' => $data['assigned_to_department_id'] ?? null,
                            'action' => 'ASSIGNED',
                        ]);
                    }),
                Action::make('generate_summary')
                    ->label('AI Summary')
                    ->icon('heroicon-m-sparkles')
                    ->color('info')
                    ->requiresConfirmation()
                    ->modalHeading('Generate AI Summary')
                    ->modalDescription('This will analyze the asset history and overwrite the existing summary. Continue?')
                    ->action(function (Asset $record) {
                        try {
                            $summary = (new AIService())->generateAssetSummary($record);

                            $record->update(['ai_summary' => $summary]);

                            Notification::make()
                                        ->title('Asset Insight')
                                        ->body($summary)
                                        ->info()
                                        ->persistent()
                                        ->send();

                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Generation Failed')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),
            ])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
