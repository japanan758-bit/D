<?php

namespace App\Filament\Resources\ApiIntegrationResource\Widgets;

use App\Models\ApiIntegration;
use App\Services\IntegrationManager;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class IntegrationStatusWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    protected static bool $isLazy = false;

    protected function getStats(): array
    {
        $manager = app(IntegrationManager::class);
        $statusReport = $manager->getStatusReport();

        return [
            Stat::make('Total Integrations', $statusReport['total_integrations'])
                ->description('All configured integrations')
                ->descriptionIcon('heroicon-m-cog-6-tooth')
                ->color('gray'),

            Stat::make('Active Integrations', $statusReport['active_integrations'])
                ->description('Currently active integrations')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color($statusReport['active_integrations'] > 0 ? 'success' : 'gray'),

            Stat::make('Analytics Services', $statusReport['categories']['analytics']['active'] ?? 0)
                ->description('Google Analytics, Meta Pixel, etc.')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('info'),

            Stat::make('Communication Services', $statusReport['categories']['communication']['active'] ?? 0)
                ->description('Email, SMS, WhatsApp, Push notifications')
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color('success'),

            Stat::make('Security Services', $statusReport['categories']['security']['active'] ?? 0)
                ->description('reCAPTCHA, security APIs')
                ->descriptionIcon('heroicon-m-shield-check')
                ->color('danger'),

            Stat::make('Payment Services', $statusReport['categories']['payment']['active'] ?? 0)
                ->description('Stripe, Paymob, Fawry')
                ->descriptionIcon('heroicon-m-credit-card')
                ->color('warning'),
        ];
    }

    protected function getColumns(): int
    {
        return 3;
    }

    protected static function getColumnSpan(): int|string|array
    {
        return 'full';
    }
}