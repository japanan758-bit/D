<?php

namespace App\Services;

use App\Models\Appointment;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * إرسال تأكيد الموعد
     */
    public function sendAppointmentConfirmation(Appointment $appointment): void
    {
        try {
            // إرسال إيميل تأكيد
            Mail::to($appointment->patient_email)->send(new \App\Mail\AppointmentConfirmation($appointment));
            
            Log::info('Appointment confirmation sent', [
                'appointment_id' => $appointment->id,
                'patient_email' => $appointment->patient_email
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send appointment confirmation', [
                'appointment_id' => $appointment->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * إرسال إشعار تأكيد الموعد
     */
    public function sendAppointmentConfirmed(Appointment $appointment): void
    {
        try {
            Mail::to($appointment->patient_email)->send(new \App\Mail\AppointmentConfirmed($appointment));
            
            Log::info('Appointment confirmed notification sent', [
                'appointment_id' => $appointment->id,
                'patient_email' => $appointment->patient_email
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send appointment confirmation', [
                'appointment_id' => $appointment->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * إرسال إشعار إلغاء الموعد
     */
    public function sendAppointmentCancelled(Appointment $appointment): void
    {
        try {
            Mail::to($appointment->patient_email)->send(new \App\Mail\AppointmentCancelled($appointment));
            
            Log::info('Appointment cancelled notification sent', [
                'appointment_id' => $appointment->id,
                'patient_email' => $appointment->patient_email
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send appointment cancellation', [
                'appointment_id' => $appointment->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * إرسال إشعار إعادة الجدولة
     */
    public function sendAppointmentRescheduled(Appointment $appointment): void
    {
        try {
            Mail::to($appointment->patient_email)->send(new \App\Mail\AppointmentRescheduled($appointment));
            
            Log::info('Appointment rescheduled notification sent', [
                'appointment_id' => $appointment->id,
                'patient_email' => $appointment->patient_email
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send appointment reschedule', [
                'appointment_id' => $appointment->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * إرسال تحديث الحالة
     */
    public function sendStatusUpdate(Appointment $appointment, string $status): void
    {
        try {
            $mailable = match($status) {
                'confirmed' => new \App\Mail\AppointmentConfirmed($appointment),
                'cancelled' => new \App\Mail\AppointmentCancelled($appointment),
                'completed' => new \App\Mail\AppointmentCompleted($appointment),
                default => null
            };

            if ($mailable) {
                Mail::to($appointment->patient_email)->send($mailable);
            }
            
        } catch (\Exception $e) {
            Log::error('Failed to send status update', [
                'appointment_id' => $appointment->id,
                'status' => $status,
                'error' => $e->getMessage()
            ]);
        }
    }
}