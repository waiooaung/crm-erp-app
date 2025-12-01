<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\Department;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required(),
            TextInput::make('email')->label('Email address')->email()->required(),
            Select::make('role')
                ->options(['ADMIN' => 'A d m i n', 'MANAGER' => 'M a n a g e r', 'STAFF' => 'S t a f f'])
                ->required(),
            Select::make('department_id')
                ->label('Department')
                ->searchable()
                ->nullable()
                ->options(Department::pluck('name', 'id')->toArray()),
            TextInput::make('password')->password()->revealable()->label('Password')->maxLength(255)->helperText(fn(string $operation): string => $operation === 'create' ? 'Required for new users.' : 'Leave empty to keep current password.')->required(fn(string $operation): bool => $operation === 'create')->dehydrated(filled(...)),
        ]);
    }
}
