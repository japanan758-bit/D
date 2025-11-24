<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApiIntegrationResource\Pages;
use App\Filament\Resources\ApiIntegrationResource\RelationManagers;
use App\Models\ApiIntegration;
use App\Services\IntegrationManager;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class ApiIntegrationResource extends Resource
{
    protected static ?string $model = ApiIntegration::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'API Integrations';

    protected static ?string $pluralModelLabel = 'API Integrations';

    protected static ?string $modelLabel = 'API Integration';

    protected static ?int $navigationSort = 1;

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Tabs::make('Integration Tabs')
                    ->tabs([
                        Tabs\Tab::make('Basic Information')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Integration Name')
                                    ->required()
                                    ->unique('api_integrations', 'name', ignoreRecord: true)
                                    ->disabled(fn (?Model $record) => $record !== null)
                                    ->helperText('Unique identifier for this integration (cannot be changed)'),

                                TextInput::make('display_name')
                                    ->label('Display Name')
                                    ->required()
                                    ->maxLength(255),

                                Select::make('category')
                                    ->label('Category')
                                    ->required()
                                    ->options([
                                        'analytics' => 'Analytics',
                                        'security' => 'Security',
                                        'communication' => 'Communication',
                                        'payment' => 'Payment',
                                        'storage' => 'Storage',
                                        'marketing' => 'Marketing',
                                        'monitoring' => 'Monitoring'
                                    ])
                                    ->helperText('Choose the appropriate category for this integration'),

                                Textarea::make('description')
                                    ->label('Description')
                                    ->rows(3)
                                    ->helperText('Brief description of what this integration does'),

                                Toggle::make('is_active')
                                    ->label('Active')
                                    ->helperText('Enable or disable this integration'),

                                Toggle::make('is_testing')
                                    ->label('Testing Mode')
                                    ->helperText('Enable testing mode for development')
                                    ->default(true),
                            ]),

                        Tabs\Tab::make('Configuration')
                            ->schema([
                                KeyValue::make('configuration')
                                    ->label('Configuration Settings')
                                    ->helperText('Key-value pairs for configuration parameters')
                                    ->addActionLabel('Add Configuration')
                                    ->reorderable()
                                    ->default([
                                        'enabled' => true,
                                        'environment' => 'production'
                                    ])
                            ]),

                        Tabs\Tab::make('API Keys')
                            ->schema([
                                KeyValue::make('api_keys')
                                    ->label('API Keys & Secrets')
                                    ->helperText('Encrypted storage for API keys and sensitive data')
                                    ->addActionLabel('Add API Key')
                                    ->reorderable()
                                    ->password(
                                        field: 'value',
                                        toggle: [
                                            'is_revealable' => true,
                                        ]
                                    )
                            ]),

                        Tabs\Tab::make('Settings')
                            ->schema([
                                KeyValue::make('settings')
                                    ->label('Additional Settings')
                                    ->helperText('Additional settings and metadata')
                                    ->addActionLabel('Add Setting')
                                    ->reorderable()
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('display_name')
                    ->label('Display Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category')
                    ->label('Category')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'analytics' => 'info',
                        'security' => 'danger',
                        'communication' => 'success',
                        'payment' => 'warning',
                        'storage' => 'primary',
                        'marketing' => 'secondary',
                        'monitoring' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucwords($state))
                    ->searchable(),

                IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->sortable(),

                IconColumn::make('is_testing')
                    ->label('Testing')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('M j, Y g:i A')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Active Status'),

                TernaryFilter::make('is_testing')
                    ->label('Testing Mode'),

                Tables\Filters\SelectFilter::make('category')
                    ->label('Category')
                    ->options([
                        'analytics' => 'Analytics',
                        'security' => 'Security',
                        'communication' => 'Communication',
                        'payment' => 'Payment',
                        'storage' => 'Storage',
                        'marketing' => 'Marketing',
                        'monitoring' => 'Monitoring'
                    ]),
            ])
            ->actions([
                ActionGroup::make([
                    Action::make('test')
                        ->label('Test')
                        ->icon('heroicon-m-play')
                        ->color('success')
                        ->action(function (Model $record) {
                            try {
                                $manager = app(IntegrationManager::class);
                                $service = $manager->getService($record->name);
                                
                                if ($service && $service->validate()) {
                                    $result = $service->test();
                                    
                                    if ($result['success']) {
                                        \Filament\Notifications\Notification::make()
                                            ->title('Test Successful')
                                            ->body($result['message'])
                                            ->success()
                                            ->send();
                                    } else {
                                        \Filament\Notifications\Notification::make()
                                            ->title('Test Failed')
                                            ->body($result['message'])
                                            ->danger()
                                            ->send();
                                    }
                                } else {
                                    \Filament\Notifications\Notification::make()
                                        ->title('Service Not Available')
                                        ->body('The service is not properly configured')
                                        ->warning()
                                        ->send();
                                }
                            } catch (\Exception $e) {
                                \Filament\Notifications\Notification::make()
                                    ->title('Test Error')
                                    ->body($e->getMessage())
                                    ->danger()
                                    ->send();
                            }
                        }),

                    Action::make('activate')
                        ->label('Activate')
                        ->icon('heroicon-m-check-circle')
                        ->color('success')
                        ->visible(fn (Model $record) => !$record->is_active)
                        ->action(function (Model $record) {
                            $record->update(['is_active' => true]);
                            \Filament\Notifications\Notification::make()
                                ->title('Integration Activated')
                                ->success()
                                ->send();
                        }),

                    Action::make('deactivate')
                        ->label('Deactivate')
                        ->icon('heroicon-m-x-circle')
                        ->color('danger')
                        ->visible(fn (Model $record) => $record->is_active)
                        ->action(function (Model $record) {
                            $record->update(['is_active' => false]);
                            \Filament\Notifications\Notification::make()
                                ->title('Integration Deactivated')
                                ->warning()
                                ->send();
                        }),

                    Tables\Actions\EditAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    
                    Action::make('activate_selected')
                        ->label('Activate Selected')
                        ->icon('heroicon-m-check-circle')
                        ->color('success')
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $record->update(['is_active' => true]);
                            }
                            \Filament\Notifications\Notification::make()
                                ->title('Selected integrations activated')
                                ->success()
                                ->send();
                        }),

                    Action::make('deactivate_selected')
                        ->label('Deactivate Selected')
                        ->icon('heroicon-m-x-circle')
                        ->color('danger')
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $record->update(['is_active' => false]);
                            }
                            \Filament\Notifications\Notification::make()
                                ->title('Selected integrations deactivated')
                                ->warning()
                                ->send();
                        }),
                ]),
            ])
            ->defaultSort('category')
            ->paginated([10, 25, 50, 100])
            ->poll('30s');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApiIntegrations::route('/'),
            'edit' => Pages\EditApiIntegration::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('is_active', true)->count();
        
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $count = static::getModel()::where('is_active', true)->count();
        
        return $count > 5 ? 'danger' : ($count > 0 ? 'success' : 'gray');
    }

    public static function getGlobalSearchIdentifier(): string
    {
        return 'api_integrations';
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->display_name;
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Category' => ucwords($record->category),
            'Status' => $record->is_active ? 'Active' : 'Inactive',
            'Last Updated' => $record->updated_at->format('M j, Y'),
        ];
    }
}