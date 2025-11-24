<?php

namespace App\Filament\Resources\ApiIntegrationResource\Widgets;

use App\Services\IntegrationManager;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class IntegrationHealthWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected static bool $isLazy = false;

    protected function getStats(): array
    {
        $manager = app(IntegrationManager::class);
        $health = $manager->getHealthCheck();
        
        // Get specific service statuses
        $analyticsStatus = $manager->isActive('google_analytics') || $manager->isActive('meta_pixel');
        $communicationStatus = $manager->isActive('email') || $manager->isActive('sms') || $manager->isActive('whatsapp');
        $securityStatus = $manager->isActive('recaptcha');
        $storageStatus = $manager->isActive('cloudinary');
        $paymentStatus = $manager->isActive('payment');

        return [
            Stat::make('System Health', ucfirst($health['status']))
                ->description($health['status'] === 'healthy' ? 'All critical systems operational' : 'Critical issues detected')
                ->descriptionIcon($health['status'] === 'healthy' ? 'heroicon-m-heart' : 'heroicon-m-exclamation-triangle')
                ->color($health['status'] === 'healthy' ? 'success' : 'danger'),

            Stat::make('Analytics', $analyticsStatus ? 'Connected' : 'Disconnected')
                ->description('Google Analytics & Meta Pixel')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color($analyticsStatus ? 'success' : 'gray'),

            Stat::make('Communication', $communicationStatus ? 'Connected' : 'Disconnected')
                ->description('Email, SMS, WhatsApp')
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color($communicationStatus ? 'success' : 'gray'),

            Stat::make('Security', $securityStatus ? 'Protected' : 'Unprotected')
                ->description('reCAPTCHA & Security APIs')
                ->descriptionIcon('heroicon-m-shield-check')
                ->color($securityStatus ? 'success' : 'gray'),

            Stat::make('Storage', $storageStatus ? 'Active' : 'Inactive')
                ->description('Image & File Management')
                ->descriptionIcon('heroicon-m-cloud')
                ->color($storageStatus ? 'success' : 'gray'),

            Stat::make('Payments', $paymentStatus ? 'Available' : 'Unavailable')
                ->description('Payment Processing')
                ->descriptionIcon('heroicon-m-credit-card')
                ->color($paymentStatus ? 'success' : 'gray'),
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