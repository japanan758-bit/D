<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\MedicalRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentReminder;
use App\Mail\FollowUpReminder;
use App\Mail\SystemAlert;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // تنظيف السجلات القديمة (يومياً في الساعة 2:00 صباحاً)
        $schedule->command('log:clean --days=30')
                 ->dailyAt('02:00');

        // تصاريح النظام (يومياً في الساعة 3:00 صباحاً)
        $schedule->command('permission:sync')
                 ->dailyAt('03:00');

        // إشعارات المواعيد (كل 30 دقيقة)
        $schedule->call(function () {
            $this->sendAppointmentReminders();
        })->everyThirtyMinutes();

        // المتابعة اليومية للمرضى (يومياً في الساعة 9:00 صباحاً)
        $schedule->call(function () {
            $this->sendFollowUpReminders();
        })->dailyAt('09:00');

        // تنظيف البيانات المؤقتة (يومياً في الساعة 1:00 صباحاً)
        $schedule->call(function () {
            $this->cleanTemporaryData();
        })->dailyAt('01:00');

        // تقارير النظام (يومياً في الساعة 23:00)
        $schedule->call(function () {
            $this->generateSystemReports();
        })->dailyAt('23:00');

        // تحديث إحصائيات المرضى (كل ساعة)
        $schedule->call(function () {
            $this->updatePatientStatistics();
        })->hourly();

        // فحص المواعيد المنتهية الصلاحية (كل 15 دقيقة)
        $schedule->call(function () {
            $this->checkExpiredAppointments();
        })->everyFifteenMinutes();

        // إشعارات المتابعة الطبية (يومياً في الساعة 8:00)
        $schedule->call(function () {
            $this->sendMedicalFollowUpNotifications();
        })->dailyAt('08:00');

        // نسخ احتياطية لقاعدة البيانات (يومياً في الساعة 4:00)
        $schedule->command('backup:database')
                 ->dailyAt('04:00');

        // إرسال التقارير الأسبوعية (الأحد في الساعة 10:00)
        $schedule->call(function () {
            $this->sendWeeklyReports();
        })->weekly()->sundays()->at('10:00');

        // إحصائيات الأطباء (يومياً في الساعة 6:00)
        $schedule->call(function () {
            $this->updateDoctorStatistics();
        })->dailyAt('06:00');

        // تنظيف الجلسات المنتهية (يومياً في الساعة 5:00)
        $schedule->command('session:gc')
                 ->dailyAt('05:00');

        // تحديث المواعيد المتكررة (يومياً في الساعة 0:00)
        $schedule->call(function () {
            $this->updateRecurringAppointments();
        })->dailyAt('00:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    /**
     * إرسال تذكيرات المواعيد
     */
    private function sendAppointmentReminders(): void
    {
        try {
            $upcomingAppointments = Appointment::with(['patient', 'doctor'])
                ->where('appointment_date', '>=', Carbon::now())
                ->where('appointment_date', '<=', Carbon::now()->addDay())
                ->where('status', 'confirmed')
                ->whereDoesntHave('notifications', function($query) {
                    $query->where('type', 'appointment_reminder')
                          ->where('created_at', '>=', Carbon::now()->subMinutes(60));
                })
                ->get();

            foreach ($upcomingAppointments as $appointment) {
                // إرسال إشعار عبر البريد الإلكتروني
                if ($appointment->patient->email) {
                    Mail::to($appointment->patient->email)
                        ->send(new AppointmentReminder($appointment));
                }

                // إضافة إشعار في قاعدة البيانات
                DB::table('notifications')->insert([
                    'user_id' => $appointment->patient->id,
                    'type' => 'appointment_reminder',
                    'title' => 'تذكير بموعد',
                    'message' => 'لديك موعد مع الدكتور ' . $appointment->doctor->name . ' غداً في تمام ' . $appointment->appointment_time,
                    'data' => json_encode(['appointment_id' => $appointment->id]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            info('تم إرسال ' . $upcomingAppointments->count() . ' تذكير موعد');
        } catch (\Exception $e) {
            error_log('خطأ في إرسال تذكيرات المواعيد: ' . $e->getMessage());
        }
    }

    /**
     * إرسال تذكيرات المتابعة
     */
    private function sendFollowUpReminders(): void
    {
        try {
            $followUpAppointments = Appointment::with(['patient', 'doctor'])
                ->where('follow_up_date', '<=', Carbon::now()->addDays(7))
                ->where('follow_up_date', '>=', Carbon::now())
                ->where('status', 'completed')
                ->get();

            foreach ($followUpAppointments as $appointment) {
                // إرسال تذكير للمتابعة
                if ($appointment->patient->email) {
                    Mail::to($appointment->patient->email)
                        ->send(new FollowUpReminder($appointment));
                }
            }

            info('تم إرسال ' . $followUpAppointments->count() . ' تذكير متابعة');
        } catch (\Exception $e) {
            error_log('خطأ في إرسال تذكيرات المتابعة: ' . $e->getMessage());
        }
    }

    /**
     * تنظيف البيانات المؤقتة
     */
    private function cleanTemporaryData(): void
    {
        try {
            // حذف الملفات المؤقتة
            $tempFiles = storage_path('app/temp');
            if (is_dir($tempFiles)) {
                $files = glob($tempFiles . '/*');
                foreach ($files as $file) {
                    if (filemtime($file) < strtotime('-24 hours')) {
                        unlink($file);
                    }
                }
            }

            // حذف الجلسات المنتهية
            DB::table('sessions')
                ->where('last_activity', '<', time() - (60 * 60 * 24 * 7)) // 7 أيام
                ->delete();

            // حذف الإشعارات القديمة
            DB::table('notifications')
                ->where('created_at', '<', Carbon::now()->subDays(30))
                ->delete();

            info('تم تنظيف البيانات المؤقتة بنجاح');
        } catch (\Exception $e) {
            error_log('خطأ في تنظيف البيانات: ' . $e->getMessage());
        }
    }

    /**
     * إنشاء تقارير النظام
     */
    private function generateSystemReports(): void
    {
        try {
            $today = Carbon::now()->startOfDay();
            $yesterday = Carbon::now()->subDay()->startOfDay();

            $reportData = [
                'date' => $today->toDateString(),
                'total_appointments' => Appointment::whereDate('created_at', $today)->count(),
                'confirmed_appointments' => Appointment::whereDate('created_at', $today)->where('status', 'confirmed')->count(),
                'completed_appointments' => Appointment::whereDate('created_at', $today)->where('status', 'completed')->count(),
                'cancelled_appointments' => Appointment::whereDate('created_at', $today)->where('status', 'cancelled')->count(),
                'new_patients' => Patient::whereDate('created_at', $today)->count(),
                'active_patients' => Patient::where('is_active', true)->count(),
                'total_revenue' => Appointment::whereDate('appointment_date', $today)->sum('amount'),
            ];

            // حفظ التقرير
            DB::table('system_reports')->insert([
                'date' => $today->toDateString(),
                'data' => json_encode($reportData),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            info('تم إنشاء تقرير النظام بنجاح');
        } catch (\Exception $e) {
            error_log('خطأ في إنشاء تقرير النظام: ' . $e->getMessage());
        }
    }

    /**
     * تحديث إحصائيات المرضى
     */
    private function updatePatientStatistics(): void
    {
        try {
            $activePatients = Patient::where('is_active', true)->count();
            $inactivePatients = Patient::where('is_active', false)->count();

            $statistics = [
                'active_patients' => $activePatients,
                'inactive_patients' => $inactivePatients,
                'total_patients' => $activePatients + $inactivePatients,
                'updated_at' => now(),
            ];

            DB::table('patient_statistics')->updateOrInsert(
                ['date' => Carbon::now()->toDateString()],
                $statistics
            );

            info('تم تحديث إحصائيات المرضى');
        } catch (\Exception $e) {
            error_log('خطأ في تحديث إحصائيات المرضى: ' . $e->getMessage());
        }
    }

    /**
     * فحص المواعيد المنتهية الصلاحية
     */
    private function checkExpiredAppointments(): void
    {
        try {
            // تحديث المواعيد المتأخرة إلى حالة منتهية الصلاحية
            $expiredAppointments = Appointment::where('appointment_date', '<', Carbon::now())
                ->where('status', 'confirmed')
                ->update(['status' => 'expired']);

            // إشعار للأطباء
            foreach (Appointment::with('doctor')
                ->where('appointment_date', '<', Carbon::now())
                ->where('status', 'expired')
                ->whereDoesntHave('notifications', function($query) {
                    $query->where('type', 'expired_appointment')
                          ->where('created_at', '>=', Carbon::now()->subHours(24));
                })
                ->get() as $appointment) {
                
                DB::table('notifications')->insert([
                    'user_id' => $appointment->doctor->id,
                    'type' => 'expired_appointment',
                    'title' => 'موعد منتهي الصلاحية',
                    'message' => 'الموعد مع المريض ' . $appointment->patient->full_name . ' قد انتهت صلاحيته',
                    'data' => json_encode(['appointment_id' => $appointment->id]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            info('تم فحص المواعيد المنتهية الصلاحية');
        } catch (\Exception $e) {
            error_log('خطأ في فحص المواعيد المنتهية: ' . $e->getMessage());
        }
    }

    /**
     * إرسال إشعارات المتابعة الطبية
     */
    private function sendMedicalFollowUpNotifications(): void
    {
        try {
            $followUpRecords = MedicalRecord::with(['patient', 'doctor'])
                ->where('follow_up_date', '<=', Carbon::now()->addDays(7))
                ->where('follow_up_date', '>=', Carbon::now())
                ->get();

            foreach ($followUpRecords as $record) {
                // إرسال إشعار للمريض
                if ($record->patient->email) {
                    DB::table('notifications')->insert([
                        'user_id' => $record->patient->id,
                        'type' => 'medical_follow_up',
                        'title' => 'موعد متابعة طبية',
                        'message' => 'لديك موعد متابعة طبية مع الدكتور ' . $record->doctor->name . ' في تاريخ ' . $record->follow_up_date->format('Y-m-d'),
                        'data' => json_encode(['medical_record_id' => $record->id]),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            info('تم إرسال إشعارات المتابعة الطبية');
        } catch (\Exception $e) {
            error_log('خطأ في إرسال إشعارات المتابعة: ' . $e->getMessage());
        }
    }

    /**
     * إرسال التقارير الأسبوعية
     */
    private function sendWeeklyReports(): void
    {
        try {
            $startOfWeek = Carbon::now()->startOfWeek();
            $endOfWeek = Carbon::now()->endOfWeek();

            $weeklyStats = [
                'total_appointments' => Appointment::whereBetween('appointment_date', [$startOfWeek, $endOfWeek])->count(),
                'completed_appointments' => Appointment::whereBetween('appointment_date', [$startOfWeek, $endOfWeek])->where('status', 'completed')->count(),
                'new_patients' => Patient::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count(),
                'total_revenue' => Appointment::whereBetween('appointment_date', [$startOfWeek, $endOfWeek])->sum('amount'),
                'most_active_doctor' => Appointment::selectRaw('doctor_id, COUNT(*) as total')
                    ->whereBetween('appointment_date', [$startOfWeek, $endOfWeek])
                    ->groupBy('doctor_id')
                    ->orderBy('total', 'desc')
                    ->first(),
            ];

            info('تم إنشاء التقرير الأسبوعي: ' . json_encode($weeklyStats));
        } catch (\Exception $e) {
            error_log('خطأ في إنشاء التقرير الأسبوعي: ' . $e->getMessage());
        }
    }

    /**
     * تحديث إحصائيات الأطباء
     */
    private function updateDoctorStatistics(): void
    {
        try {
            $doctors = DB::table('doctors')->get();
            
            foreach ($doctors as $doctor) {
                $stats = [
                    'total_appointments' => Appointment::where('doctor_id', $doctor->id)->count(),
                    'today_appointments' => Appointment::where('doctor_id', $doctor->id)->whereDate('appointment_date', today())->count(),
                    'completed_appointments' => Appointment::where('doctor_id', $doctor->id)->where('status', 'completed')->count(),
                    'pending_appointments' => Appointment::where('doctor_id', $doctor->id)->where('status', 'pending')->count(),
                    'updated_at' => now(),
                ];

                DB::table('doctor_statistics')->updateOrInsert(
                    ['doctor_id' => $doctor->id, 'date' => Carbon::now()->toDateString()],
                    $stats
                );
            }

            info('تم تحديث إحصائيات الأطباء');
        } catch (\Exception $e) {
            error_log('خطأ في تحديث إحصائيات الأطباء: ' . $e->getMessage());
        }
    }

    /**
     * تحديث المواعيد المتكررة
     */
    private function updateRecurringAppointments(): void
    {
        try {
            $recurringAppointments = Appointment::with(['patient', 'doctor'])
                ->where('is_recurring', true)
                ->where('recurring_pattern', 'weekly')
                ->where('next_recurring_date', '<=', Carbon::now())
                ->get();

            foreach ($recurringAppointments as $appointment) {
                // إنشاء موعد جديد
                $newAppointment = Appointment::create([
                    'patient_id' => $appointment->patient_id,
                    'doctor_id' => $appointment->doctor_id,
                    'appointment_date' => $appointment->next_recurring_date,
                    'appointment_time' => $appointment->appointment_time,
                    'status' => 'pending',
                    'is_recurring' => true,
                    'recurring_pattern' => 'weekly',
                    'parent_appointment_id' => $appointment->id,
                ]);

                // تحديث التاريخ المتكرر التالي
                $nextDate = Carbon::parse($appointment->next_recurring_date)->addWeek();
                $appointment->update(['next_recurring_date' => $nextDate]);

                // إرسال إشعار
                if ($appointment->patient->email) {
                    DB::table('notifications')->insert([
                        'user_id' => $appointment->patient->id,
                        'type' => 'recurring_appointment',
                        'title' => 'موعد دوري جديد',
                        'message' => 'تم إنشاء موعد دوري جديد مع الدكتور ' . $appointment->doctor->name . ' في تاريخ ' . $newAppointment->appointment_date,
                        'data' => json_encode(['appointment_id' => $newAppointment->id]),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            info('تم تحديث ' . $recurringAppointments->count() . ' موعد دوري');
        } catch (\Exception $e) {
            error_log('خطأ في تحديث المواعيد المتكررة: ' . $e->getMessage());
        }
    }
}