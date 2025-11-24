<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Service;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DoctorController extends Controller
{
    /**
     * Display a listing of doctors.
     */
    public function index(Request $request)
    {
        $query = Doctor::with(['appointments']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('specialization', 'like', "%{$search}%");
            });
        }

        // Filter by specialization
        if ($request->filled('specialization')) {
            $query->where('specialization', $request->specialization);
        }

        $doctors = $query->orderBy('name')
            ->paginate(15);

        // Get unique specializations for filter
        $specializations = Doctor::distinct()
            ->pluck('specialization')
            ->filter()
            ->sort();

        return view('doctors.index', compact('doctors', 'specializations'));
    }

    /**
     * Show the form for creating a new doctor.
     */
    public function create()
    {
        return view('doctors.create');
    }

    /**
     * Store a newly created doctor in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email',
            'phone' => 'required|string|max:20',
            'specialization' => 'required|string|max:255',
            'qualification' => 'nullable|string',
            'experience_years' => 'required|integer|min:0',
            'bio' => 'nullable|string',
            'consultation_fee' => 'required|numeric|min:0',
            'working_hours' => 'nullable|array',
            'working_days' => 'nullable|array',
            'is_available' => 'boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle working hours JSON
        if (isset($validated['working_hours'])) {
            $validated['working_hours'] = json_encode($validated['working_hours']);
        }

        // Handle working days JSON
        if (isset($validated['working_days'])) {
            $validated['working_days'] = json_encode($validated['working_days']);
        }

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = 'doctor_' . time() . '_' . Str::random(10) . '.' . $photo->getClientOriginalExtension();
            $path = $photo->storeAs('doctors', $filename, 'public');
            $validated['photo_path'] = $path;
        }

        // Set default values
        $validated['is_active'] = true;
        $validated['is_available'] = $validated['is_available'] ?? false;

        Doctor::create($validated);

        return redirect()->route('doctors.index')
            ->with('success', 'تم إضافة الطبيب بنجاح');
    }

    /**
     * Display the specified doctor.
     */
    public function show(Doctor $doctor)
    {
        $doctor->load(['appointments' => function ($query) {
            $query->where('appointment_date', '>=', Carbon::today())
                ->orderBy('appointment_date')
                ->orderBy('appointment_time');
        }]);

        // Get doctor statistics
        $stats = [
            'total_appointments' => $doctor->appointments->count(),
            'pending_appointments' => $doctor->appointments->where('status', 'pending')->count(),
            'confirmed_appointments' => $doctor->appointments->where('status', 'confirmed')->count(),
            'completed_appointments' => $doctor->appointments->where('status', 'completed')->count(),
            'cancelled_appointments' => $doctor->appointments->where('status', 'cancelled')->count(),
        ];

        // Upcoming appointments
        $upcomingAppointments = $doctor->appointments()
            ->where('appointment_date', '>=', Carbon::today())
            ->whereIn('status', ['confirmed', 'pending'])
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->limit(10)
            ->get();

        return view('doctors.show', compact('doctor', 'stats', 'upcomingAppointments'));
    }

    /**
     * Show the form for editing the specified doctor.
     */
    public function edit(Doctor $doctor)
    {
        // Decode JSON fields
        if ($doctor->working_hours) {
            $doctor->working_hours = json_decode($doctor->working_hours, true);
        }

        if ($doctor->working_days) {
            $doctor->working_days = json_decode($doctor->working_days, true);
        }

        return view('doctors.edit', compact('doctor'));
    }

    /**
     * Update the specified doctor in storage.
     */
    public function update(Request $request, Doctor $doctor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email,' . $doctor->id,
            'phone' => 'required|string|max:20',
            'specialization' => 'required|string|max:255',
            'qualification' => 'nullable|string',
            'experience_years' => 'required|integer|min:0',
            'bio' => 'nullable|string',
            'consultation_fee' => 'required|numeric|min:0',
            'working_hours' => 'nullable|array',
            'working_days' => 'nullable|array',
            'is_available' => 'boolean',
            'is_active' => 'boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle working hours JSON
        if (isset($validated['working_hours'])) {
            $validated['working_hours'] = json_encode($validated['working_hours']);
        }

        // Handle working days JSON
        if (isset($validated['working_days'])) {
            $validated['working_days'] = json_encode($validated['working_days']);
        }

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($doctor->photo_path) {
                Storage::disk('public')->delete($doctor->photo_path);
            }

            $photo = $request->file('photo');
            $filename = 'doctor_' . time() . '_' . Str::random(10) . '.' . $photo->getClientOriginalExtension();
            $path = $photo->storeAs('doctors', $filename, 'public');
            $validated['photo_path'] = $path;
        }

        $doctor->update($validated);

        return redirect()->route('doctors.show', $doctor)
            ->with('success', 'تم تحديث بيانات الطبيب بنجاح');
    }

    /**
     * Remove the specified doctor from storage.
     */
    public function destroy(Doctor $doctor)
    {
        // Check if doctor has appointments
        if ($doctor->appointments()->exists()) {
            return back()->with('error', 'لا يمكن حذف الطبيب لوجود مواعيد مرتبطة به');
        }

        // Delete photo
        if ($doctor->photo_path) {
            Storage::disk('public')->delete($doctor->photo_path);
        }

        $doctor->delete();

        return redirect()->route('doctors.index')
            ->with('success', 'تم حذف الطبيب بنجاح');
    }

    /**
     * Get doctor's schedule for a specific date.
     */
    public function getSchedule(Request $request, Doctor $doctor)
    {
        $request->validate([
            'date' => 'required|date'
        ]);

        $date = Carbon::parse($request->date);

        // Get all appointments for the doctor on this date
        $appointments = $doctor->appointments()
            ->whereDate('appointment_date', $date)
            ->orderBy('appointment_time')
            ->get();

        // Parse working hours
        $workingHours = json_decode($doctor->working_hours, true) ?? [];
        $workingDays = json_decode($doctor->working_days, true) ?? [];

        // Check if doctor works on this day
        $dayOfWeek = $date->dayOfWeek; // 0 = Sunday, 6 = Saturday
        $isWorkingDay = false;
        $dayName = $date->format('l');

        foreach ($workingDays as $day) {
            if (strtolower($day) === strtolower($dayName)) {
                $isWorkingDay = true;
                break;
            }
        }

        $schedule = [
            'is_working_day' => $isWorkingDay,
            'working_hours' => $workingHours,
            'appointments' => $appointments,
            'available_slots' => []
        ];

        // Generate available time slots
        if ($isWorkingDay && isset($workingHours['start']) && isset($workingHours['end'])) {
            $startTime = Carbon::parse($date->format('Y-m-d') . ' ' . $workingHours['start']);
            $endTime = Carbon::parse($date->format('Y-m-d') . ' ' . $workingHours['end']);

            $slotDuration = 60; // 1 hour slots
            $currentTime = $startTime->copy();

            while ($currentTime < $endTime) {
                $slotEnd = $currentTime->copy()->addMinutes($slotDuration);

                // Check if this slot is available
                $isBooked = $appointments->contains(function ($appointment) use ($currentTime, $slotEnd) {
                    $appointmentStart = Carbon::parse($appointment->appointment_date . ' ' . $appointment->appointment_time);
                    $appointmentEnd = $appointmentStart->copy()->addMinutes(60); // Assuming 1 hour appointments

                    return ($currentTime < $appointmentEnd) && ($slotEnd > $appointmentStart);
                });

                if (!$isBooked && $currentTime > Carbon::now()) {
                    $schedule['available_slots'][] = [
                        'time' => $currentTime->format('H:i'),
                        'end_time' => $slotEnd->format('H:i'),
                        'available' => true
                    ];
                }

                $currentTime->addMinutes($slotDuration);
            }
        }

        return response()->json($schedule);
    }

    /**
     * Get doctors by specialization.
     */
    public function bySpecialization(Request $request)
    {
        $request->validate([
            'specialization' => 'required|string'
        ]);

        $doctors = Doctor::where('specialization', $request->specialization)
            ->where('is_active', true)
            ->where('is_available', true)
            ->get();

        return response()->json($doctors);
    }

    /**
     * Get all doctors with basic info.
     */
    public function getDoctors()
    {
        $doctors = Doctor::where('is_active', true)
            ->select('id', 'name', 'specialization', 'photo_url', 'consultation_fee')
            ->get();

        return response()->json($doctors);
    }

    /**
     * Toggle doctor availability status.
     */
    public function toggleAvailability(Doctor $doctor)
    {
        $doctor->is_available = !$doctor->is_available;
        $doctor->save();

        return back()->with('success', 
            $doctor->is_available ? 'تم تفعيل توفر الطبيب' : 'تم إيقاف تفعيل توفر الطبيب'
        );
    }

    /**
     * Get doctor statistics.
     */
    public function statistics(Doctor $doctor)
    {
        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();

        $stats = [
            'total_appointments' => $doctor->appointments()->count(),
            'this_month_appointments' => $doctor->appointments()->where('created_at', '>=', $thisMonth)->count(),
            'last_month_appointments' => $doctor->appointments()->whereBetween('created_at', [$lastMonth, $thisMonth])->count(),
            'pending_appointments' => $doctor->appointments()->where('status', 'pending')->count(),
            'completed_appointments' => $doctor->appointments()->where('status', 'completed')->count(),
            'cancelled_appointments' => $doctor->appointments()->where('status', 'cancelled')->count(),
            'total_revenue' => $doctor->appointments()
                ->where('status', 'completed')
                ->sum('service_fee'),
        ];

        return response()->json($stats);
    }

    /**
     * Export doctors data.
     */
    public function export()
    {
        $doctors = Doctor::orderBy('name')->get();

        $filename = 'doctors_' . date('Y-m-d_H-i-s') . '.csv';
        $filePath = storage_path('app/exports/' . $filename);

        if (!file_exists(dirname($filePath))) {
            mkdir(dirname($filePath), 0755, true);
        }

        $handle = fopen($filePath, 'w');

        // CSV headers
        fputcsv($handle, [
            'ID',
            'Name',
            'Email',
            'Phone',
            'Specialization',
            'Qualification',
            'Experience (Years)',
            'Consultation Fee',
            'Available',
            'Active',
            'Created At'
        ]);

        foreach ($doctors as $doctor) {
            fputcsv($handle, [
                $doctor->id,
                $doctor->name,
                $doctor->email,
                $doctor->phone,
                $doctor->specialization,
                $doctor->qualification ?? 'N/A',
                $doctor->experience_years,
                $doctor->consultation_fee,
                $doctor->is_available ? 'Yes' : 'No',
                $doctor->is_active ? 'Yes' : 'No',
                $doctor->created_at
            ]);
        }

        fclose($handle);

        return response()->download($filePath, $filename);
    }
}