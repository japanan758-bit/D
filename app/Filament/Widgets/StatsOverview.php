<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Service;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('إجمالي المواعيد', Appointment::count())
                ->description('جميع المواعيد المسجلة')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('primary'),

            Stat::make('مواعيد اليوم', Appointment::whereDate('appointment_date', now())->count())
                ->description('المواعيد المجدولة لليوم')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('الأطباء', Doctor::count())
                ->description('عدد الأطباء المسجلين')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),

            Stat::make('الخدمات', Service::where('is_active', true)->count())
                ->description('الخدمات النشطة')
                ->descriptionIcon('heroicon-m-heart')
                ->color('info'),
        ];
    }
}
