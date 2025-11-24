<?php

namespace App\Filament\Widgets;

use App\Models\ApiIntegration;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class IntegrationStatusWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    
    protected static bool $isLazy = false;

    /**
     * The description for this widget.
     */
    protected static ?string $description = 'عرض سريع لحالة جميع التكاملات';

    protected function getStats(): array
    {
        $totalIntegrations = ApiIntegration::count();
        $activeIntegrations = ApiIntegration::where('is_active', true)->count();
        $inactiveIntegrations = $totalIntegrations - $activeIntegrations;
        $testingIntegrations = ApiIntegration::where('is_testing', true)->count();
        
        // إحصائيات الفئات
        $categories = ApiIntegration::selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->pluck('count', 'category')
            ->toArray();

        return [
            Stat::make('إجمالي التكاملات', $totalIntegrations)
                ->description('جميع التكاملات المُعدة')
                ->descriptionIcon('heroicon-m-cog-6-tooth')
                ->color('primary')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                ]),

            Stat::make('التكاملات النشطة', $activeIntegrations)
                ->description('فعّالة حالياً')
                ->descriptionIcon($activeIntegrations > 0 ? 'heroicon-m-check-circle' : 'heroicon-m-x-circle')
                ->color($activeIntegrations > 0 ? 'success' : 'danger')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                ]),

            Stat::make('التكاملات غير النشطة', $inactiveIntegrations)
                ->description('غير مُفعّلة')
                ->descriptionIcon('heroicon-m-pause-circle')
                ->color('warning')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                ]),

            Stat::make('وضع الاختبار', $testingIntegrations)
                ->description('في وضع التجربة')
                ->descriptionIcon('heroicon-m-beaker')
                ->color('info')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                ]),

            // إحصائيات الفئات
            ...array_map(function ($category, $count) {
                return Stat::make(ucfirst($category), $count)
                    ->description("تكامل" . ($count > 1 ? "ات" : ""))
                    ->descriptionIcon('heroicon-m-folder')
                    ->color('gray');
            }, array_keys($categories), $categories),
        ];
    }

    protected function getColumns(): int
    {
        return 3;
    }

    public function getColumnSpan(): int|string|array
    {
        return 'full';
    }
}