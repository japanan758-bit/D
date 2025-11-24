<?php

namespace App\Filament\Resources\ApiIntegrationResource\Pages;

use App\Filament\Resources\ApiIntegrationResource;
use App\Services\IntegrationManager;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Model;

class ListApiIntegrations extends ListRecords
{
    protected static string $resource = ApiIntegrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Add New Integration')
                ->mutateFormDataUsing(function (array $data): array {
                    // Set default configuration based on category
                    $data['configuration'] = self::getDefaultConfiguration($data);
                    return $data;
                }),
            
            Actions\Action::make('system_check')
                ->label('System Health Check')
                ->icon('heroicon-m-heart')
                ->color('info')
                ->action(function () {
                    $manager = app(IntegrationManager::class);
                    $health = $manager->getHealthCheck();
                    
                    if ($health['status'] === 'healthy') {
                        \Filament\Notifications\Notification::make()
                            ->title('System Health Check')
                            ->body('All critical systems are working properly')
                            ->success()
                            ->send();
                    } else {
                        $issues = implode(', ', $health['issues']);
                        \Filament\Notifications\Notification::make()
                            ->title('System Health Issues')
                            ->body($issues)
                            ->danger()
                            ->send();
                    }
                }),

            Actions\Action::make('test_all')
                ->label('Test All Integrations')
                ->icon('heroicon-m-play')
                ->color('success')
                ->action(function () {
                    $manager = app(IntegrationManager::class);
                    $results = $manager->testAll();
                    
                    $successCount = collect($results)->where('success', true)->count();
                    $totalCount = count($results);
                    
                    \Filament\Notifications\Notification::make()
                        ->title('Integration Tests Complete')
                        ->body("{$successCount} out of {$totalCount} integrations are working")
                        ->send();
                }),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Resources\ApiIntegrationResource\Widgets\IntegrationStatusWidget::class,
            \App\Filament\Resources\ApiIntegrationResource\Widgets\IntegrationHealthWidget::class,
        ];
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [10, 25, 50, 100];
    }

    protected function getDefaultTableRecordsPerPage(): int
    {
        return 25;
    }

    protected function getTableQuery(): \Illuminate\Database\EloquentBuilder
    {
        return parent::getTableQuery()->orderBy('category')->orderBy('name');
    }

    protected function getTableFiltersFormWidth(): string
    {
        return 'lg';
    }

    protected function getTableFilters(): array
    {
        return [
            // Custom filters are defined in the table() method
        ];
    }

    protected function getTabs(): array
    {
        $manager = app(IntegrationManager::class);
        $statusReport = $manager->getStatusReport();
        
        return [
            'all' => Tab::make('All Integrations')
                ->badge($statusReport['total_integrations'])
                ->badgeColor('gray'),

            Tab::make('Analytics')
                ->badge($statusReport['categories']['analytics']['active'] ?? 0)
                ->badgeColor('info')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('category', 'analytics');
                }),

            Tab::make('Communication')
                ->badge($statusReport['categories']['communication']['active'] ?? 0)
                ->badgeColor('success')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('category', 'communication');
                }),

            Tab::make('Security')
                ->badge($statusReport['categories']['security']['active'] ?? 0)
                ->badgeColor('danger')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('category', 'security');
                }),

            Tab::make('Payment')
                ->badge($statusReport['categories']['payment']['active'] ?? 0)
                ->badgeColor('warning')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('category', 'payment');
                }),

            Tab::make('Storage')
                ->badge($statusReport['categories']['storage']['active'] ?? 0)
                ->badgeColor('primary')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('category', 'storage');
                }),

            'active' => Tab::make('Active')
                ->badgeColor('success')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('is_active', true);
                }),

            'testing' => Tab::make('Testing')
                ->badgeColor('warning')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('is_testing', true);
                }),
        ];
    }

    protected function getTableRecordUrlUsing(): ?\Closure
    {
        return function (Model $record) {
            return static::getResource()::getUrl('edit', ['record' => $record]);
        };
    }

    protected function canCreate(): bool
    {
        return true;
    }

    protected function canEdit(Model $record): bool
    {
        return true;
    }

    protected function canDelete(Model $record): bool
    {
        return true;
    }

    protected function canDeleteAny(): bool
    {
        return true;
    }

    protected function canRestore(Model $record): bool
    {
        return false; // Soft deletes not implemented
    }

    protected function canForceDelete(Model $record): bool
    {
        return false; // Force deletes not implemented
    }

    protected function canReplicate(): bool
    {
        return false;
    }

    protected function canExport(): bool
    {
        return true;
    }

    protected function getExportPageWidth(): string
    {
        return '4xl';
    }

    protected function getExportColumns(): array
    {
        return [
            'name',
            'display_name',
            'category',
            'is_active',
            'is_testing',
            'updated_at',
        ];
    }

    protected function getExportFileName(): string
    {
        return 'api-integrations-' . now()->format('Y-m-d-H-i-s');
    }

    protected function getExportFormats(): array
    {
        return ['csv', 'xlsx'];
    }

    private static function getDefaultConfiguration(array $data): array
    {
        $defaults = [
            'analytics' => [
                'environment' => 'production',
                'tracking_enabled' => true,
                'privacy_compliant' => true,
            ],
            'security' => [
                'environment' => 'production',
                'security_level' => 'high',
                'rate_limiting' => true,
            ],
            'communication' => [
                'environment' => 'production',
                'retry_attempts' => 3,
                'batch_processing' => true,
            ],
            'payment' => [
                'environment' => 'sandbox',
                'currency' => 'SAR',
                'auto_capture' => true,
                'refund_policy' => 'standard',
            ],
            'storage' => [
                'environment' => 'production',
                'compression' => true,
                'cdn_enabled' => true,
                'backup_enabled' => true,
            ],
            'marketing' => [
                'environment' => 'production',
                'tracking_events' => true,
                'conversion_tracking' => true,
            ],
            'monitoring' => [
                'environment' => 'production',
                'alert_thresholds' => 'default',
                'notification_frequency' => 'immediate',
            ],
        ];

        return $defaults[$data['category']] ?? [];
    }
}