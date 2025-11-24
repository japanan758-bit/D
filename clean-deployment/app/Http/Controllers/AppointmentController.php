<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Models\Service;
use App\Services\AppointmentService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AppointmentController extends Controller
{
    protected $appointmentService;
    protected $notificationService;

    public function __construct(
        AppointmentService $appointmentService,
        NotificationService $notificationService
    ) {
        $this->appointmentService = $appointmentService;
        $this->notificationService = $notificationService;
        
        // تطبيق Middleware للحماية
        $this->middleware('auth')->except(['index', 'show', 'store', 'checkAvailability']);
    }

    /**
     * عرض قائمة المواعيد
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Appointment::with(['service', 'doctor'])
                ->when($request->status, function ($query, $status) {
                    return $query->where('status', $status);
                })
                ->when($request->date_from, function ($query, $date) {
                    return $query->whereDate('appointment_date', '>=', $date);
                })
                ->when($request->date_to, function ($query, $date) {
                    return $query->whereDate('appointment_date', '<=', $date);
                })
                ->when($request->search, function ($query, $search) {
                    return $query->where(function ($q) use ($search) {
                        $q->where('patient_name', 'like', "%{$search}%")
                          ->orWhere('patient_phone', 'like', "%{$search}%")
                          ->orWhere('patient_email', 'like', "%{$search}%");
                    });
                })
                ->orderBy('appointment_date', 'desc')
                ->orderBy('appointment_time', 'asc');

            $appointments = $query->paginate($request->get('per_page', 15));

            return response()->json([
                'success' => true,
                'data' => AppointmentResource::collection($appointments),
                'pagination' => [
                    'current_page' => $appointments->currentPage(),
                    'total_pages' => $appointments->lastPage(),
                    'total_count' => $appointments->total(),
                    'per_page' => $appointments->perPage()
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching appointments: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في جلب المواعيد'
            ], 500);
        }
    }

    /**
     * عرض موعد محدد
     */
    public function show(Appointment $appointment): JsonResponse
    {
        try {
            $appointment->load(['service', 'doctor']);

            return response()->json([
                'success' => true,
                'data' => new AppointmentResource($appointment)
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching appointment: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في جلب بيانات الموعد'
            ], 500);
        }
    }

    /**
     * إنشاء موعد جديد
     */
    public function store(StoreAppointmentRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            // التحقق من توفر الموعد
            $isAvailable = $this->appointmentService->checkAvailability(
                $request->service_id,
                $request->appointment_date,
                $request->appointment_time
            );

            if (!$isAvailable) {
                return response()->json([
                    'success' => false,
                    'message' => 'الوقت المحدد غير متاح، يرجى اختيار وقت آخر'
                ], 422);
            }

            // إنشاء الموعد
            $appointment = $this->appointmentService->createAppointment([
                'patient_name' => $request->patient_name,
                'patient_phone' => $request->patient_phone,
                'patient_email' => $request->patient_email,
                'service_id' => $request->service_id,
                'appointment_date' => $request->appointment_date,
                'appointment_time' => $request->appointment_time,
                'notes' => $request->notes,
                'status' => 'pending',
                'confirmation_code' => Str::random(6),
                'is_confirmed' => false
            ]);

            // إرسال إشعار التأكيد
            $this->notificationService->sendAppointmentConfirmation($appointment);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'تم إنشاء الموعد بنجاح',
                'data' => new AppointmentResource($appointment)
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating appointment: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في إنشاء الموعد'
            ], 500);
        }
    }

    /**
     * تحديث موعد
     */
    public function update(UpdateAppointmentRequest $request, Appointment $appointment): JsonResponse
    {
        try {
            DB::beginTransaction();

            // التحقق من إمكانية التحديث
            if (!in_array($appointment->status, ['pending', 'confirmed'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'لا يمكن تعديل موعد تم إلغاؤه أو انتهاؤه'
                ], 422);
            }

            // التحقق من توفر الوقت الجديد إذا تم تغييره
            if ($request->appointment_date !== $appointment->appointment_date->format('Y-m-d') ||
                $request->appointment_time !== $appointment->appointment_time->format('H:i')) {
                
                $isAvailable = $this->appointmentService->checkAvailability(
                    $request->service_id ?? $appointment->service_id,
                    $request->appointment_date ?? $appointment->appointment_date->format('Y-m-d'),
                    $request->appointment_time ?? $appointment->appointment_time->format('H:i'),
                    $appointment->id
                );

                if (!$isAvailable) {
                    return response()->json([
                        'success' => false,
                        'message' => 'الوقت المحدد غير متاح'
                    ], 422);
                }
            }

            // تحديث الموعد
            $updatedAppointment = $this->appointmentService->updateAppointment(
                $appointment,
                $request->validated()
            );

            // إرسال إشعار التحديث إذا لزم الأمر
            if ($request->status && $request->status !== $appointment->status) {
                $this->notificationService->sendStatusUpdate($updatedAppointment, $request->status);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'تم تحديث الموعد بنجاح',
                'data' => new AppointmentResource($updatedAppointment)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating appointment: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في تحديث الموعد'
            ], 500);
        }
    }

    /**
     * حذف موعد
     */
    public function destroy(Appointment $appointment): JsonResponse
    {
        try {
            // التحقق من إمكانية الحذف
            if (in_array($appointment->status, ['completed'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'لا يمكن حذف موعد مكتمل'
                ], 422);
            }

            // حذف الموعد
            $appointment->delete();

            return response()->json([
                'success' => true,
                'message' => 'تم حذف الموعد بنجاح'
            ]);

        } catch (\Exception $e) {
            Log::error('Error deleting appointment: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في حذف الموعد'
            ], 500);
        }
    }

    /**
     * تأكيد موعد
     */
    public function confirm(Appointment $appointment): JsonResponse
    {
        try {
            if ($appointment->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'يمكن فقط تأكيد المواعيد المعلقة'
                ], 422);
            }

            $appointment->update([
                'status' => 'confirmed',
                'is_confirmed' => true
            ]);

            // إرسال إشعار التأكيد
            $this->notificationService->sendAppointmentConfirmed($appointment);

            return response()->json([
                'success' => true,
                'message' => 'تم تأكيد الموعد بنجاح',
                'data' => new AppointmentResource($appointment->fresh())
            ]);

        } catch (\Exception $e) {
            Log::error('Error confirming appointment: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في تأكيد الموعد'
            ], 500);
        }
    }

    /**
     * إلغاء موعد
     */
    public function cancel(Request $request, Appointment $appointment): JsonResponse
    {
        try {
            if (!in_array($appointment->status, ['pending', 'confirmed'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'لا يمكن إلغاء هذا الموعد'
                ], 422);
            }

            $appointment->update([
                'status' => 'cancelled',
                'cancel_reason' => $request->reason,
                'cancelled_at' => now()
            ]);

            // إرسال إشعار الإلغاء
            $this->notificationService->sendAppointmentCancelled($appointment);

            return response()->json([
                'success' => true,
                'message' => 'تم إلغاء الموعد بنجاح',
                'data' => new AppointmentResource($appointment->fresh())
            ]);

        } catch (\Exception $e) {
            Log::error('Error cancelling appointment: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في إلغاء الموعد'
            ], 500);
        }
    }

    /**
     * إعادة جدولة موعد
     */
    public function reschedule(Request $request, Appointment $appointment): JsonResponse
    {
        $request->validate([
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required|date_format:H:i'
        ]);

        try {
            DB::beginTransaction();

            // التحقق من توفر الوقت الجديد
            $isAvailable = $this->appointmentService->checkAvailability(
                $appointment->service_id,
                $request->appointment_date,
                $request->appointment_time,
                $appointment->id
            );

            if (!$isAvailable) {
                return response()->json([
                    'success' => false,
                    'message' => 'الوقت المحدد غير متاح'
                ], 422);
            }

            $appointment->update([
                'appointment_date' => $request->appointment_date,
                'appointment_time' => $request->appointment_time,
                'status' => 'pending',
                'rescheduled_at' => now()
            ]);

            // إرسال إشعار إعادة الجدولة
            $this->notificationService->sendAppointmentRescheduled($appointment);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'تم إعادة جدولة الموعد بنجاح',
                'data' => new AppointmentResource($appointment->fresh())
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error rescheduling appointment: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في إعادة جدولة الموعد'
            ], 500);
        }
    }

    /**
     * التحقق من توفر المواعيد
     */
    public function checkAvailability(Request $request): JsonResponse
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required|date_format:H:i'
        ]);

        try {
            $available = $this->appointmentService->checkAvailability(
                $request->service_id,
                $request->appointment_date,
                $request->appointment_time
            );

            return response()->json([
                'success' => true,
                'available' => $available,
                'message' => $available ? 'الوقت متاح' : 'الوقت غير متاح'
            ]);

        } catch (\Exception $e) {
            Log::error('Error checking availability: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في فحص التوفر'
            ], 500);
        }
    }

    /**
     * إحصائيات المواعيد
     */
    public function statistics(Request $request): JsonResponse
    {
        try {
            $period = $request->get('period', 'week'); // day, week, month, year
            
            $statistics = $this->appointmentService->getStatistics($period);

            return response()->json([
                'success' => true,
                'data' => $statistics
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching appointment statistics: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في جلب الإحصائيات'
            ], 500);
        }
    }

    /**
     * الحصول على المواعيد لليوم المحدد
     */
    public function getDayAppointments(Request $request, string $date): JsonResponse
    {
        try {
            $appointments = Appointment::with(['service', 'doctor'])
                ->whereDate('appointment_date', $date)
                ->orderBy('appointment_time')
                ->get();

            return response()->json([
                'success' => true,
                'data' => AppointmentResource::collection($appointments),
                'date' => $date
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching day appointments: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في جلب مواعيد اليوم'
            ], 500);
        }
    }

    /**
     * تصدير المواعيد
     */
    public function export(Request $request): JsonResponse
    {
        try {
            $format = $request->get('format', 'csv'); // csv, excel, pdf
            
            $appointments = Appointment::with(['service', 'doctor'])
                ->when($request->status, function ($query, $status) {
                    return $query->where('status', $status);
                })
                ->when($request->date_from, function ($query, $date) {
                    return $query->whereDate('appointment_date', '>=', $date);
                })
                ->when($request->date_to, function ($query, $date) {
                    return $query->whereDate('appointment_date', '<=', $date);
                })
                ->get();

            // هنا يمكن إضافة منطق التصدير الفعلي
            // سيتم تنفيذه لاحقاً

            return response()->json([
                'success' => true,
                'message' => 'تم تصدير المواعيد بنجاح',
                'data' => [
                    'appointments_count' => $appointments->count(),
                    'format' => $format
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error exporting appointments: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في تصدير المواعيد'
            ], 500);
        }
    }

    /**
     * فحص توفر المواعيد
     */
    public function availability(Request $request, $doctorId = null): JsonResponse
    {
        try {
            $request->validate([
                'doctor_id' => 'required_if:doctorId,null|integer|exists:doctors,id',
                'date' => 'required|date|after_or_equal:today',
                'time' => 'required_if:check_specific_time|date_format:H:i'
            ]);

            $doctorId = $doctorId ?: $request->doctor_id;
            $date = $request->date;
            $time = $request->time;

            $availability = $this->appointmentService->checkAvailability($doctorId, $date, $time);

            return response()->json([
                'success' => true,
                'data' => $availability
            ]);

        } catch (\Exception $e) {
            Log::error('Error checking availability: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في فحص التوفر'
            ], 500);
        }
    }
}