<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Notification;

class NotificationService
{
    /**
     * إرسال إشعار تأكيد الموعد
     */
    public function sendAppointmentConfirmation(Appointment $appointment): void
    {
        // 1. Notify Admins
        $admins = User::whereIn('role', ['admin', 'receptionist'])->get();

        foreach ($admins as $admin) {
            Notification::make()
                ->title('حجز موعد جديد')
                ->body("قام المريض {$appointment->patient_name} بحجز موعد جديد.")
                ->success()
                ->actions([
                    \Filament\Notifications\Actions\Action::make('view')
                        ->label('عرض الموعد')
                        ->url(route('filament.admin.resources.appointments.edit', $appointment)),
                ])
                ->sendToDatabase($admin);
        }

        // 2. Send Email (Placeholder)
        try {
            if ($appointment->patient_email) {
                Log::info("Sending confirmation email to {$appointment->patient_email}");
            }
        } catch (\Exception $e) {
            Log::error("Failed to send confirmation email: " . $e->getMessage());
        }
    }

    /**
     * إرسال إشعار عند تأكيد الموعد من الإدارة
     */
    public function sendAppointmentConfirmed(Appointment $appointment): void
    {
        // Notify Patient (Simulated)
        try {
            if ($appointment->patient_email) {
                Log::info("Sending approved status email to {$appointment->patient_email}");
            }
        } catch (\Exception $e) {
            Log::error("Failed to send approved status email: " . $e->getMessage());
        }
    }

    /**
     * إرسال إشعار عند إلغاء الموعد
     */
    public function sendAppointmentCancelled(Appointment $appointment): void
    {
        try {
            if ($appointment->patient_email) {
                Log::info("Sending cancellation email to {$appointment->patient_email}");
            }
        } catch (\Exception $e) {
            Log::error("Failed to send cancellation email: " . $e->getMessage());
        }
    }

    /**
     * إرسال إشعار عند إعادة الجدولة
     */
    public function sendAppointmentRescheduled(Appointment $appointment): void
    {
        try {
            if ($appointment->patient_email) {
                Log::info("Sending reschedule email to {$appointment->patient_email}");
            }
        } catch (\Exception $e) {
            Log::error("Failed to send reschedule email: " . $e->getMessage());
        }
    }

    /**
     * إرسال إشعار تحديث الحالة
     */
    public function sendStatusUpdate(Appointment $appointment, string $status): void
    {
        switch ($status) {
            case 'confirmed':
                $this->sendAppointmentConfirmed($appointment);
                break;
            case 'cancelled':
                $this->sendAppointmentCancelled($appointment);
                break;
            default:
                Log::info("Status updated to {$status} for appointment {$appointment->id}");
                break;
        }
    }
}
