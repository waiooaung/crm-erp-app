<?php

namespace App\Filament\Resources\Assets\Schemas;

use App\Models\Department;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Str;

class AssetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required(),
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
            Select::make('assigned_to_user_id')
                ->label('Assigned to User')
                ->searchable()
                ->nullable()
                ->options(User::pluck('name', 'id')->toArray()),
            Select::make('assigned_to_department_id')
                ->label('Assigned to Department')
                ->searchable()
                ->nullable()
                ->options(Department::pluck('name', 'id')->toArray()),
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
                })
        ]);
    }
}
