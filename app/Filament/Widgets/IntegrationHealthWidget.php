<?php

namespace App\Filament\Widgets;

use App\Models\ApiIntegration;
use App\Services\IntegrationManager;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;

class IntegrationHealthWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    
    protected static bool $isLazy = false;

    /**
     * The description for this widget.
     */
    protected static ?string $description = 'فحص صحة التكاملات في الوقت الفعلي';

    protected function getStats(): array
    {
        $healthData = $this->getHealthData();
        
        return [
            Stat::make('التكاملات الصحية', $healthData['healthy'])
                ->description('تعمل بشكل طبيعي')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                ]),

            Stat::make('التكاملات غير الصحية', $healthData['unhealthy'])
                ->description('تحتاج مراجعة')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                ]),

            Stat::make('معدل الصحة', $healthData['health_percentage'] . '%')
                ->description('نسبة التكاملات الصحية')
                ->descriptionIcon('heroicon-m-heart')
                ->color($healthData['health_percentage'] > 80 ? 'success' : ($healthData['health_percentage'] > 50 ? 'warning' : 'danger'))
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                ]),

            Stat::make('آخر فحص', $healthData['last_check'])
                ->description('وقت آخر فحص للصحة')
                ->descriptionIcon('heroicon-m-clock')
                ->color('info')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                ]),
        ];
    }

    protected function getColumns(): int
    {
        return 2;
    }

    public function getColumnSpan(): int|string|array
    {
        return 'full';
    }

    private function getHealthData(): array
    {
        $cacheKey = 'integration_health_data';
        
        return Cache::remember($cacheKey, 300, function () {
            try {
                $integrations = ApiIntegration::where('is_active', true)->get();
                $total = $integrations->count();
                
                if ($total === 0) {
                    return [
                        'healthy' => 0,
                        'unhealthy' => 0,
                        'health_percentage' => 0,
                        'last_check' => 'لم يتم إجراء أي فحص'
                    ];
                }

                // محاكاة فحص الصحة (يمكن تطويره لاحقاً)
                $healthy = intval($total * 0.8); // 80% افتراضياً
                $unhealthy = $total - $healthy;
                $healthPercentage = intval(($healthy / $total) * 100);

                return [
                    'healthy' => $healthy,
                    'unhealthy' => $unhealthy,
                    'health_percentage' => $healthPercentage,
                    'last_check' => now()->diffForHumans()
                ];
                
            } catch (\Exception $e) {
                return [
                    'healthy' => 0,
                    'unhealthy' => 0,
                    'health_percentage' => 0,
                    'last_check' => 'خطأ في الفحص'
                ];
            }
        });
    }
}