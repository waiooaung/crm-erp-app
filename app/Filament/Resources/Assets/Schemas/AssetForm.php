<?php

namespace App\Filament\Resources\Assets\Schemas;

use App\Models\Department;
use App\Models\User;
use App\Services\AIService;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Str;

class AssetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required()->live(onBlur: true)
                ->afterStateUpdated(function ($state, Set $set) {
                    $category = (new AIService)->suggestCategory($state);
                    $set('category', $category);
                }),
            TextInput::make('category'),
            TextInput::make('serial_number'),
            Select::make('status')
                ->options([
                    'IN_STOCK' => 'I n  s t o c k',
                    'ASSIGNED' => 'A s s i g n e d',
                    'MAINTENANCE' => 'M a i n t e n a n c e',
                    'LOST' => 'L o s t',
                    'RETIRED' => 'R e t i r e d',
                ])
                ->default('IN_STOCK')
                ->required(),
            Select::make('assigned_to_department_id')
                ->label('Assigned to Department')
                ->options(Department::pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->live()
                ->afterStateUpdated(function (Set $set) {
                    $set('assigned_to_user_id', null);
                }),
            Select::make('assigned_to_user_id')
                ->label('Assigned to User')
                ->searchable()
                ->preload()
                ->live()
                ->options(function (Get $get) {
                    $departmentId = $get('assigned_to_department_id');

                    if ($departmentId) {
                        return User::where('department_id', $departmentId)
                            ->pluck('name', 'id');
                    }

                    return User::pluck('name', 'id');
                })
                ->afterStateUpdated(function ($state, Set $set) {
                    if ($state) {
                        $user = User::find($state);

                        if ($user?->department_id) {
                            $set('assigned_to_department_id', $user->department_id);
                        }
                    }
                }),
            DatePicker::make('purchase_date'),
            DatePicker::make('warranty_expiry'),
            TextInput::make('value')->numeric(),
            FileUpload::make('attachments')
                ->label('Attachments')
                ->multiple()
                ->enableDownload()
                ->acceptedFileTypes(['image/jpeg', 'image/png'])
                ->disk('public')
                ->directory('assets')
                ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                    $extension = $file->getClientOriginalExtension();
                    return 'asset-' . Str::uuid() . '.' . $extension;
                }),
        ]);
    }
}
