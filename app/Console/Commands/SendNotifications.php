<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentReminder;
use App\Mail\FollowUpReminder;
use App\Mail\AppointmentConfirmation;
use App\Mail\AppointmentCancellation;
use App\Mail\MedicalReport;
use App\Mail\SystemNotification;
use Carbon\Carbon;

class SendNotifications extends Command
{
    protected $signature = 'notifications:send {--type=all} {--limit=100} {--dry-run=false}';
    protected $description = 'إرسال الإشعارات والإيميلات';

    public function handle()
    {
        $this->info('📧 بدء عملية إرسال الإشعارات...');

        $type = $this->option('type');
        $limit = $this->option('limit');
        $isDryRun = $this->option('dry-run') === 'true';

        if ($isDryRun) {
            $this->warn('🔍 تشغيل في وضع المعاينة - لن يتم إرسال أي رسائل فعلية');
        }

        $sentCount = 0;
        $failedCount = 0;

        try {
            switch ($type) {
                case 'appointment_reminders':
                    $result = $this->sendAppointmentReminders($limit, $isDryRun);
                    break;
                    
                case 'follow_ups':
                    $result = $this->sendFollowUpReminders($limit, $isDryRun);
                    break;
                    
                case 'confirmations':
                    $result = $this->sendConfirmations($limit, $isDryRun);
                    break;
                    
                case 'medical_reports':
                    $result = $this->sendMedicalReports($limit, $isDryRun);
                    break;
                    
                case 'system_notifications':
                    $result = $this->sendSystemNotifications($limit, $isDryRun);
                    break;
                    
                case 'all':
                default:
                    $result = $this->sendAllNotifications($limit, $isDryRun);
                    break;
            }

            $sentCount = $result['sent'];
            $failedCount = $result['failed'];
            
        } catch (\Exception $e) {
            $this->error('❌ خطأ في إرسال الإشعارات: ' . $e->getMessage());
            return self::FAILURE;
        }

        $this->newLine();
        $this->info("✅ تم إرسال $sentCount إشعار بنجاح");
        if ($failedCount > 0) {
            $this->error("❌ فشل إرسال $failedCount إشعار");
        }

        return self::SUCCESS;
    }

    private function sendAppointmentReminders(int $limit, bool $isDryRun): array
    {
        $this->info('⏰ إرسال تذكيرات المواعيد...');
        
        $appointments = Appointment::with(['patient', 'doctor'])
            ->where('appointment_date', '>=', Carbon::now())
            ->where('appointment_date', '<=', Carbon::now()->addDays(7))
            ->where('status', 'confirmed')
            ->where(function($query) {
                $query->whereNull('reminder_sent_at')
                      ->orWhere('reminder_sent_at', '<', Carbon::now()->subDays(1));
            })
            ->limit($limit)
            ->get();

        $sent = 0;
        $failed = 0;

        foreach ($appointments as $appointment) {
            try {
                if (!$isDryRun) {
                    Mail::to($appointment->patient->email)->send(new AppointmentReminder($appointment));
                    $appointment->update(['reminder_sent_at' => now()]);
                }
                
                $this->line("تذكير موعد: " . $appointment->patient->full_name);
                $sent++;
                
            } catch (\Exception $e) {
                $this->error("فشل إرسال تذكير للموعد: " . $e->getMessage());
                $failed++;
            }
        }

        return ['sent' => $sent, 'failed' => $failed];
    }

    private function sendFollowUpReminders(int $limit, bool $isDryRun): array
    {
        $this->info('🔄 إرسال تذكيرات المتابعة...');
        
        $records = MedicalRecord::with(['patient', 'doctor'])
            ->where('follow_up_date', '<=', Carbon::now()->addDays(14))
            ->where('follow_up_date', '>=', Carbon::now())
            ->where('follow_up_notification_sent', false)
            ->limit($limit)
            ->get();

        $sent = 0;
        $failed = 0;

        foreach ($records as $record) {
            try {
                if (!$isDryRun) {
                    Mail::to($record->patient->email)->send(new FollowUpReminder($record));
                    $record->update(['follow_up_notification_sent' => true]);
                }
                
                $this->line("تذكير متابعة: " . $record->patient->full_name);
                $sent++;
                
            } catch (\Exception $e) {
                $this->error("فشل إرسال تذكير متابعة: " . $e->getMessage());
                $failed++;
            }
        }

        return ['sent' => $sent, 'failed' => $failed];
    }

    private function sendConfirmations(int $limit, bool $isDryRun): array
    {
        $this->info('✅ إرسال تأكيدات المواعيد...');
        
        $appointments = Appointment::with(['patient', 'doctor'])
            ->where('status', 'confirmed')
            ->where('confirmation_sent_at', '<', Carbon::now()->subHours(24))
            ->whereDoesntHave('notifications', function($query) {
                $query->where('type', 'appointment_confirmation')
                      ->where('created_at', '>=', Carbon::now()->subHours(24));
            })
            ->limit($limit)
            ->get();

        $sent = 0;
        $failed = 0;

        foreach ($appointments as $appointment) {
            try {
                if (!$isDryRun) {
                    Mail::to($appointment->patient->email)->send(new AppointmentConfirmation($appointment));
                    $appointment->update(['confirmation_sent_at' => now()]);
                }
                
                $this->line("تأكيد موعد: " . $appointment->patient->full_name);
                $sent++;
                
            } catch (\Exception $e) {
                $this->error("فشل إرسال تأكيد: " . $e->getMessage());
                $failed++;
            }
        }

        return ['sent' => $sent, 'failed' => $failed];
    }

    private function sendMedicalReports(int $limit, bool $isDryRun): array
    {
        $this->info('📋 إرسال التقارير الطبية...');
        
        $records = MedicalRecord::with(['patient', 'doctor'])
            ->where('report_sent', false)
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->limit($limit)
            ->get();

        $sent = 0;
        $failed = 0;

        foreach ($records as $record) {
            try {
                if (!$isDryRun) {
                    Mail::to($record->patient->email)->send(new MedicalReport($record));
                    $record->update(['report_sent' => true]);
                }
                
                $this->line("تقرير طبي: " . $record->patient->full_name);
                $sent++;
                
            } catch (\Exception $e) {
                $this->error("فشل إرسال تقرير: " . $e->getMessage());
                $failed++;
            }
        }

        return ['sent' => $sent, 'failed' => $failed];
    }

    private function sendSystemNotifications(int $limit, bool $isDryRun): array
    {
        $this->info('🔔 إرسال إشعارات النظام...');
        
        // إرسال إشعار للأطباء عن المواعيد اليومية
        $todayAppointments = Appointment::with('doctor')
            ->whereDate('appointment_date', Carbon::now())
            ->where('status', 'confirmed')
            ->get()
            ->groupBy('doctor_id');

        $sent = 0;
        $failed = 0;

        foreach ($todayAppointments as $doctorId => $appointments) {
            try {
                $doctor = Doctor::find($doctorId);
                if ($doctor && $doctor->email) {
                    
                    if (!$isDryRun) {
                        $data = [
                            'doctor' => $doctor,
                            'appointments' => $appointments,
                            'appointment_count' => $appointments->count(),
                            'date' => Carbon::now()->toDateString(),
                        ];
                        
                        Mail::to($doctor->email)->send(new SystemNotification($data, 'daily_schedule'));
                    }
                    
                    $this->line("إشعار يومي: " . $doctor->name);
                    $sent++;
                }
                
            } catch (\Exception $e) {
                $this->error("فشل إرسال إشعار: " . $e->getMessage());
                $failed++;
            }
        }

        return ['sent' => $sent, 'failed' => $failed];
    }

    private function sendAllNotifications(int $limit, bool $isDryRun): array
    {
        $totalSent = 0;
        $totalFailed = 0;

        $types = [
            'appointment_reminders',
            'follow_ups', 
            'confirmations',
            'medical_reports',
            'system_notifications'
        ];

        foreach ($types as $type) {
            $this->newLine();
            $this->info("معالجة: $type");
            
            $result = match($type) {
                'appointment_reminders' => $this->sendAppointmentReminders($limit, $isDryRun),
                'follow_ups' => $this->sendFollowUpReminders($limit, $isDryRun),
                'confirmations' => $this->sendConfirmations($limit, $isDryRun),
                'medical_reports' => $this->sendMedicalReports($limit, $isDryRun),
                'system_notifications' => $this->sendSystemNotifications($limit, $isDryRun),
            };

            $totalSent += $result['sent'];
            $totalFailed += $result['failed'];
        }

        return ['sent' => $totalSent, 'failed' => $totalFailed];
    }
}