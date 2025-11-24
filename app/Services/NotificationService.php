<?php

namespace App\Services;

use App\Models\Appointment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    /**
     * إرسال إشعار تأكيد الموعد
     */
    public function sendAppointmentConfirmation(Appointment $appointment): void
    {
        // 1. Send Email
        try {
            if ($appointment->patient_email) {
                // We would use a Mailable here, e.g., new AppointmentCreated($appointment)
                // Mail::to($appointment->patient_email)->send(...);
                Log::info("Sending confirmation email to {$appointment->patient_email}");
            }
        } catch (\Exception $e) {
            Log::error("Failed to send confirmation email: " . $e->getMessage());
        }

        // 2. Send SMS / WhatsApp (Placeholder)
        if ($appointment->patient_phone) {
            // SMS API logic would go here
            Log::info("Sending confirmation SMS to {$appointment->patient_phone}");
        }
    }

    /**
     * إرسال إشعار عند تأكيد الموعد من الإدارة
     */
    public function sendAppointmentConfirmed(Appointment $appointment): void
    {
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
