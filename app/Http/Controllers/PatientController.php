<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PatientController extends Controller
{
    /**
     * Display the patient dashboard.
     */
    public function dashboard(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أولاً');
        }

        $user = Auth::user();

        // Get user appointments
        $appointments = Appointment::where('patient_email', $user->email)
            ->orWhere('patient_name', $user->name)
            ->with(['service', 'doctor'])
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->limit(10)
            ->get();

        // Get upcoming appointments
        $upcomingAppointments = Appointment::where('patient_email', $user->email)
            ->orWhere('patient_name', $user->name)
            ->where('appointment_date', '>=', Carbon::today())
            ->whereIn('status', ['confirmed', 'pending'])
            ->with(['service', 'doctor'])
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->limit(5)
            ->get();

        // Get past appointments
        $pastAppointments = Appointment::where('patient_email', $user->email)
            ->orWhere('patient_name', $user->name)
            ->where('appointment_date', '<', Carbon::today())
            ->where('status', 'completed')
            ->with(['service', 'doctor'])
            ->orderBy('appointment_date', 'desc')
            ->limit(5)
            ->get();

        // Statistics
        $stats = [
            'total_appointments' => $appointments->count(),
            'upcoming_appointments' => $upcomingAppointments->count(),
            'completed_appointments' => $appointments->where('status', 'completed')->count(),
            'pending_appointments' => $appointments->where('status', 'pending')->count(),
            'cancelled_appointments' => $appointments->where('status', 'cancelled')->count(),
        ];

        // Book new appointment
        $services = Service::where('is_active', true)->get();
        $doctors = Doctor::where('is_active', true)
            ->where('is_available', true)
            ->get();

        return view('patient.dashboard', compact(
            'user',
            'appointments',
            'upcomingAppointments',
            'pastAppointments',
            'stats',
            'services',
            'doctors'
        ));
    }

    /**
     * Show the appointment booking form.
     */
    public function showBookingForm()
    {
        $services = Service::where('is_active', true)->get();
        $doctors = Doctor::where('is_active', true)
            ->where('is_available', true)
            ->get();

        return view('patient.book-appointment', compact('services', 'doctors'));
    }

    /**
     * Get available time slots for a specific service and date.
     */
    public function getAvailableSlots(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date|after_or_equal:today'
        ]);

        $service = Service::findOrFail($request->service_id);
        $doctor = Doctor::findOrFail($request->doctor_id);
        $date = Carbon::parse($request->date);

        // Check if the doctor works on this day
        $workingDays = json_decode($doctor->working_days, true) ?? [];
        $dayName = $date->format('l'); // Sunday, Monday, etc.

        $isWorkingDay = false;
        foreach ($workingDays as $day) {
            if (strtolower($day) === strtolower($dayName)) {
                $isWorkingDay = true;
                break;
            }
        }

        if (!$isWorkingDay) {
            return response()->json([
                'available' => false,
                'message' => 'الطبيب لا يعمل في هذا اليوم',
                'slots' => []
            ]);
        }

        // Get working hours
        $workingHours = json_decode($doctor->working_hours, true) ?? [];
        
        if (!isset($workingHours['start']) || !isset($workingHours['end'])) {
            return response()->json([
                'available' => false,
                'message' => 'لم يتم تحديد ساعات العمل',
                'slots' => []
            ]);
        }

        // Get existing appointments for this date
        $existingAppointments = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->get();

        // Generate time slots
        $startTime = Carbon::parse($date->format('Y-m-d') . ' ' . $workingHours['start']);
        $endTime = Carbon::parse($date->format('Y-m-d') . ' ' . $workingHours['end']);
        $slotDuration = 60; // 1 hour slots

        $availableSlots = [];
        $currentTime = $startTime->copy();

        while ($currentTime < $endTime) {
            $slotEnd = $currentTime->copy()->addMinutes($slotDuration);

            // Check if this slot conflicts with existing appointments
            $isBooked = $existingAppointments->contains(function ($appointment) use ($currentTime, $slotEnd) {
                $appointmentStart = Carbon::parse($appointment->appointment_date . ' ' . $appointment->appointment_time);
                $appointmentEnd = $appointmentStart->copy()->addMinutes(60);

                return ($currentTime < $appointmentEnd) && ($slotEnd > $appointmentStart);
            });

            // Don't show past time slots
            if (!$isBooked && $currentTime > Carbon::now()) {
                $availableSlots[] = [
                    'time' => $currentTime->format('H:i'),
                    'formatted_time' => $currentTime->format('h:i A'),
                    'end_time' => $slotEnd->format('H:i')
                ];
            }

            $currentTime->addMinutes($slotDuration);
        }

        return response()->json([
            'available' => true,
            'slots' => $availableSlots
        ]);
    }

    /**
     * Book a new appointment.
     */
    public function bookAppointment(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
            'patient_name' => 'required|string|max:255',
            'patient_phone' => 'required|string|max:20',
            'patient_email' => 'required|email',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Verify the time slot is still available
        $appointmentTime = Carbon::parse($validated['appointment_date'] . ' ' . $validated['appointment_time']);
        $appointmentEnd = $appointmentTime->copy()->addMinutes(60);

        $conflictingAppointment = Appointment::where('doctor_id', $validated['doctor_id'])
            ->whereDate('appointment_date', $validated['appointment_date'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($query) use ($appointmentTime, $appointmentEnd) {
                $query->where(function ($q) use ($appointmentTime, $appointmentEnd) {
                    // Check if new appointment conflicts with existing ones
                    $existingStart = Carbon::parse($q->appointment_date . ' ' . $q->appointment_time);
                    $existingEnd = $existingStart->copy()->addMinutes(60);
                    
                    return function ($timeQuery) use ($appointmentTime, $appointmentEnd, $existingStart, $existingEnd) {
                        $timeQuery->where('appointment_date', $validated['appointment_date'])
                            ->where('appointment_time', $validated['appointment_time'])
                            ->where(function ($innerQuery) use ($appointmentTime, $appointmentEnd, $existingStart, $existingEnd) {
                                $innerQuery->where('appointment_time', $validated['appointment_time'])
                                    ->orWhere(function ($conflictQuery) use ($appointmentTime, $appointmentEnd, $existingStart, $existingEnd) {
                                        return $conflictQuery->where('appointment_time', '<=', $appointmentTime)
                                            ->whereRaw("datetime(appointment_time) < datetime(?)", [$appointmentEnd->format('Y-m-d H:i:s')]);
                                    });
                            });
                    };
                });
            })
            ->first();

        if ($conflictingAppointment) {
            return back()
                ->withInput()
                ->with('error', 'هذا الوقت غير متاح، يرجى اختيار وقت آخر');
        }

        // Get service and doctor info
        $service = Service::findOrFail($validated['service_id']);
        $doctor = Doctor::findOrFail($validated['doctor_id']);

        // Create appointment
        $appointment = Appointment::create([
            'patient_name' => $validated['patient_name'],
            'patient_phone' => $validated['patient_phone'],
            'patient_email' => $validated['patient_email'],
            'service_id' => $validated['service_id'],
            'doctor_id' => $validated['doctor_id'],
            'appointment_date' => $validated['appointment_date'],
            'appointment_time' => $validated['appointment_time'],
            'service_fee' => $service->price,
            'notes' => $validated['notes'] ?? null,
            'status' => 'pending'
        ]);

        // Send confirmation email (if email is configured)
        try {
            if (config('mail.default') !== 'log') {
                Mail::to($appointment->patient_email)->send(
                    new \App\Mail\AppointmentConfirmation($appointment)
                );
            }
        } catch (\Exception $e) {
            // Log error but don't fail the booking
            \Log::error('Failed to send confirmation email: ' . $e->getMessage());
        }

        return redirect()->route('patient.appointments')
            ->with('success', 'تم حجز الموعد بنجاح! سيتم إرسال تأكيد إلى إيميلك');
    }

    /**
     * Show patient appointments.
     */
    public function appointments(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أولاً');
        }

        $user = Auth::user();

        $query = Appointment::where('patient_email', $user->email)
            ->orWhere('patient_name', $user->name)
            ->with(['service', 'doctor']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('appointment_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('appointment_date', '<=', $request->date_to);
        }

        $appointments = $query->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->paginate(10);

        return view('patient.appointments', compact('appointments'));
    }

    /**
     * Show appointment details.
     */
    public function showAppointment(Appointment $appointment)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أولاً');
        }

        $user = Auth::user();

        // Check if user owns this appointment
        if ($appointment->patient_email !== $user->email && $appointment->patient_name !== $user->name) {
            abort(403, 'غير مخول للوصول إلى هذا الموعد');
        }

        $appointment->load(['service', 'doctor']);

        return view('patient.appointment-details', compact('appointment'));
    }

    /**
     * Cancel appointment.
     */
    public function cancelAppointment(Appointment $appointment, Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أولاً');
        }

        $user = Auth::user();

        // Check if user owns this appointment
        if ($appointment->patient_email !== $user->email && $appointment->patient_name !== $user->name) {
            abort(403, 'غير مخول لإلغاء هذا الموعد');
        }

        // Check if appointment can be cancelled
        if ($appointment->status === 'completed') {
            return back()->with('error', 'لا يمكن إلغاء الموعد المكتمل');
        }

        if ($appointment->status === 'cancelled') {
            return back()->with('error', 'الموعد ملغي بالفعل');
        }

        // Cancel the appointment
        $appointment->update([
            'status' => 'cancelled',
            'cancelled_at' => Carbon::now(),
            'cancel_reason' => $request->cancel_reason ?? 'ملغي من المريض'
        ]);

        // Send cancellation email
        try {
            if (config('mail.default') !== 'log') {
                Mail::to($appointment->patient_email)->send(
                    new \App\Mail\AppointmentCancelled($appointment)
                );
            }
        } catch (\Exception $e) {
            \Log::error('Failed to send cancellation email: ' . $e->getMessage());
        }

        return redirect()->route('patient.appointments')
            ->with('success', 'تم إلغاء الموعد بنجاح');
    }

    /**
     * Show patient profile.
     */
    public function profile(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أولاً');
        }

        $user = Auth::user();

        return view('patient.profile', compact('user'));
    }

    /**
     * Update patient profile.
     */
    public function updateProfile(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أولاً');
        }

        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'birth_date' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female',
            'blood_type' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'allergies' => 'nullable|string|max:1000',
            'current_medications' => 'nullable|string|max:1000',
        ]);

        $user->update($validated);

        return back()->with('success', 'تم تحديث الملف الشخصي بنجاح');
    }

    /**
     * Show change password form.
     */
    public function showChangePasswordForm()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أولاً');
        }

        return view('patient.change-password');
    }

    /**
     * Change patient password.
     */
    public function changePassword(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أولاً');
        }

        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'كلمة المرور الحالية غير صحيحة');
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'تم تغيير كلمة المرور بنجاح');
    }

    /**
     * Export patient appointments.
     */
    public function exportAppointments()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أولاً');
        }

        $user = Auth::user();

        $appointments = Appointment::where('patient_email', $user->email)
            ->orWhere('patient_name', $user->name)
            ->with(['service', 'doctor'])
            ->orderBy('appointment_date', 'desc')
            ->get();

        $filename = 'my_appointments_' . date('Y-m-d_H-i-s') . '.csv';
        $filePath = storage_path('app/exports/' . $filename);

        if (!file_exists(dirname($filePath))) {
            mkdir(dirname($filePath), 0755, true);
        }

        $handle = fopen($filePath, 'w');

        // CSV headers
        fputcsv($handle, [
            'Date',
            'Time',
            'Service',
            'Doctor',
            'Status',
            'Fee',
            'Notes'
        ]);

        foreach ($appointments as $appointment) {
            fputcsv($handle, [
                $appointment->appointment_date,
                $appointment->appointment_time,
                $appointment->service->name ?? 'N/A',
                $appointment->doctor->name ?? 'N/A',
                $appointment->status,
                $appointment->service_fee ?? 0,
                $appointment->notes ?? ''
            ]);
        }

        fclose($handle);

        return response()->download($filePath, $filename);
    }
}