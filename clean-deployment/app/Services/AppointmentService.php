<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AppointmentService
{
    /**
     * التحقق من توفر الموعد
     */
    public function checkAvailability($serviceId, $date, $time, $excludeId = null): bool
    {
        $query = Appointment::where('service_id', $serviceId)
            ->whereDate('appointment_date', $date)
            ->where('appointment_time', $time)
            ->whereIn('status', ['pending', 'confirmed']);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return !$query->exists();
    }

    /**
     * إنشاء موعد جديد
     */
    public function createAppointment(array $data): Appointment
    {
        return Appointment::create($data);
    }

    /**
     * تحديث موعد
     */
    public function updateAppointment(Appointment $appointment, array $data): Appointment
    {
        $appointment->update($data);
        return $appointment->fresh();
    }

    /**
     * إحصائيات المواعيد
     */
    public function getStatistics(string $period = 'week'): array
    {
        $dateFrom = match($period) {
            'day' => now()->startOfDay(),
            'week' => now()->startOfWeek(),
            'month' => now()->startOfMonth(),
            'year' => now()->startOfYear(),
            default => now()->startOfWeek()
        };

        return [
            'total' => Appointment::count(),
            'pending' => Appointment::where('status', 'pending')->count(),
            'confirmed' => Appointment::where('status', 'confirmed')->count(),
            'completed' => Appointment::where('status', 'completed')->count(),
            'cancelled' => Appointment::where('status', 'cancelled')->count(),
            'this_period' => Appointment::where('created_at', '>=', $dateFrom)->count(),
            'period' => $period
        ];
    }

    /**
     * المواعيد المتاحة في يوم معين
     */
    public function getAvailableSlots(string $date, int $serviceId): array
    {
        // أوقات العمل الافتراضية (من 9 صباحاً إلى 5 مساءً)
        $startTime = Carbon::parse($date . ' 09:00:00');
        $endTime = Carbon::parse($date . ' 17:00:00');
        
        $availableSlots = [];
        
        while ($startTime->lt($endTime)) {
            $isAvailable = $this->checkAvailability($serviceId, $date, $startTime->format('H:i'));
            
            $availableSlots[] = [
                'time' => $startTime->format('H:i'),
                'available' => $isAvailable
            ];
            
            $startTime->addMinutes(30); // فترة 30 دقيقة لكل موعد
        }
        
        return $availableSlots;
    }

    /**
     * تأكيد الموعد
     */
    public function confirmAppointment(Appointment $appointment): Appointment
    {
        $appointment->update([
            'status' => 'confirmed',
            'confirmed_at' => now()
        ]);

        return $appointment;
    }
}