<?php

namespace App\Filament\Resources\Issues\Schemas;

use App\Services\AIService;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class IssueForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('asset_id')->relationship('asset', 'name')->searchable()->preload()->required(),
            Select::make('user_id')
                ->relationship('user', 'name') // Assumes User model has 'name'
                ->label('Reported By')
                ->default(auth()->id()) // Auto-select current user
                ->searchable()
                ->preload()
                ->required(),
            Textarea::make('description')
                ->label('Issue Description')
                ->placeholder('e.g., The laptop screen flickers when I open a browser.')
                ->rows(5)
                ->required()
                ->hintAction(
                    Action::make('classify')
                        ->label('Auto-Classify Issue')
                        ->icon('heroicon-m-cpu-chip')
                        ->color('primary')
                        ->action(function (Get $get, Set $set) {
                            $text = $get('description');

                            if (!$text || strlen($text) < 5) {
                                Notification::make()->title('Description too short')->warning()->send();
                                return;
                            }

                            try {
                                // Call AI Service
                                $result = app(AIService::class)->classifyIssue($text);

                                // Fill fields
                                $set('classification', $result['classification']);
                                $set('priority', $result['priority']);

                                Notification::make()
                                    ->title('Issue Classified')
                                    ->body("Detected: {$result['classification']} / Priority: {$result['priority']}")
                                    ->success()
                                    ->send();
                            } catch (\Exception $e) {
                                Notification::make()->title('AI Error')->body('Could not connect to AI service.')->danger()->send();
                            }
                        }),
                ),
            TextInput::make('classification')->label('Type')->placeholder('Auto-filled by AI'),
            Select::make('priority')
                ->options([
                    'LOW' => 'Low',
                    'MEDIUM' => 'Medium',
                    'HIGH' => 'High',
                    'CRITICAL' => 'Critical',
                ])
                ->native(false),
            Select::make('status')
                ->options(['OPEN' => 'Open', 'RESOLVED' => 'Resolved'])
                ->default('OPEN')
                ->required(),
        ]);
    }
}
