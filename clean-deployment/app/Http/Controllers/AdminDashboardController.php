<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Service;
use App\Models\Appointment;
use App\Models\Article;
use App\Models\Testimonial;
use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(Request $request)
    {
        // Dashboard Statistics
        $stats = [
            'total_appointments' => Appointment::count(),
            'pending_appointments' => Appointment::where('status', 'pending')->count(),
            'confirmed_appointments' => Appointment::where('status', 'confirmed')->count(),
            'completed_appointments' => Appointment::where('status', 'completed')->count(),
            'cancelled_appointments' => Appointment::where('status', 'cancelled')->count(),
            'total_doctors' => Doctor::count(),
            'total_services' => Service::where('is_active', true)->count(),
            'total_articles' => Article::where('is_published', true)->count(),
            'total_testimonials' => Testimonial::count(),
            'pending_testimonials' => Testimonial::where('is_approved', false)->count(),
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
        ];

        // Recent appointments (last 10)
        $recentAppointments = Appointment::with(['service', 'doctor'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Recent messages (last 5)
        $recentMessages = ContactMessage::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Pending testimonials
        $pendingTestimonials = Testimonial::where('is_approved', false)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Monthly appointments data (last 6 months)
        $monthlyAppointments = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $count = Appointment::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            
            $monthlyAppointments[] = (object) [
                'year' => $date->year,
                'month' => $date->month,
                'count' => $count,
                'month_name' => $date->format('F'),
                'year_name' => $date->format('Y'),
            ];
        }

        // Services popularity
        $popularServices = Service::leftJoin('appointments', 'services.id', '=', 'appointments.service_id')
            ->where('appointments.created_at', '>=', Carbon::now()->subMonths(3))
            ->selectRaw('services.*')
            ->selectRaw('COUNT(appointments.id) as appointment_count')
            ->groupBy('services.id')
            ->orderBy('appointment_count', 'desc')
            ->limit(5)
            ->get();

        // Doctors performance
        $doctorsPerformance = Doctor::leftJoin('appointments', 'doctors.id', '=', 'appointments.doctor_id')
            ->where('appointments.created_at', '>=', Carbon::now()->subMonths(3))
            ->selectRaw('doctors.*')
            ->selectRaw('COUNT(appointments.id) as total_appointments')
            ->selectRaw('SUM(CASE WHEN appointments.status = "completed" THEN 1 ELSE 0 END) as completed_appointments')
            ->groupBy('doctors.id')
            ->orderBy('total_appointments', 'desc')
            ->get();

        // Today's appointments
        $todayAppointments = Appointment::with(['service', 'doctor'])
            ->whereDate('appointment_date', Carbon::today())
            ->orderBy('appointment_time')
            ->get();

        // Upcoming appointments (next 7 days)
        $upcomingAppointments = Appointment::with(['service', 'doctor'])
            ->whereDate('appointment_date', '>=', Carbon::today())
            ->whereDate('appointment_date', '<=', Carbon::now()->addDays(7))
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->limit(20)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentAppointments',
            'recentMessages',
            'pendingTestimonials',
            'monthlyAppointments',
            'popularServices',
            'doctorsPerformance',
            'todayAppointments',
            'upcomingAppointments'
        ));
    }

    /**
     * Display appointments management page.
     */
    public function appointments(Request $request)
    {
        $query = Appointment::with(['service', 'doctor']);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('appointment_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('appointment_date', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('patient_name', 'like', "%{$search}%")
                  ->orWhere('patient_phone', 'like', "%{$search}%")
                  ->orWhere('patient_email', 'like', "%{$search}%");
            });
        }

        $appointments = $query->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->paginate(15);

        $services = Service::where('is_active', true)->get();
        $doctors = Doctor::get();

        return view('admin.appointments.index', compact(
            'appointments',
            'services',
            'doctors'
        ));
    }

    /**
     * Display analytics page.
     */
    public function analytics(Request $request)
    {
        $timeframe = $request->get('timeframe', '30_days');
        
        $startDate = match($timeframe) {
            '7_days' => Carbon::now()->subDays(7),
            '30_days' => Carbon::now()->subDays(30),
            '90_days' => Carbon::now()->subDays(90),
            '1_year' => Carbon::now()->subYear(),
            default => Carbon::now()->subDays(30),
        };

        // Appointments analytics
        $appointmentsByStatus = Appointment::where('created_at', '>=', $startDate)
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        // Daily appointments
        $dailyAppointments = [];
        $currentDate = $startDate->copy();
        $endDate = Carbon::now();
        
        while ($currentDate->lte($endDate)) {
            $count = Appointment::whereDate('created_at', $currentDate->toDateString())->count();
            $dailyAppointments[] = (object) [
                'date' => $currentDate->toDateString(),
                'count' => $count,
            ];
            $currentDate->addDay();
        }

        // Services analytics
        $servicesAnalytics = Service::leftJoin('appointments', 'services.id', '=', 'appointments.service_id')
            ->where('appointments.created_at', '>=', $startDate)
            ->selectRaw('services.*')
            ->selectRaw('COUNT(appointments.id) as total_appointments')
            ->selectRaw('AVG(CASE WHEN appointments.status = "completed" THEN 1 ELSE 0 END) * 100 as completion_rate')
            ->groupBy('services.id')
            ->orderBy('total_appointments', 'desc')
            ->get();

        // Monthly trends
        $monthlyTrends = [];
        $startDate = Carbon::now()->subYear();
        
        for ($i = 0; $i < 12; $i++) {
            $date = $startDate->copy()->addMonths($i);
            $totalAppointments = Appointment::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
                
            $completedAppointments = Appointment::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->where('status', 'completed')
                ->count();
                
            $cancelledAppointments = Appointment::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->where('status', 'cancelled')
                ->count();
            
            $monthlyTrends[] = (object) [
                'year' => $date->year,
                'month' => $date->month,
                'total_appointments' => $totalAppointments,
                'completed_appointments' => $completedAppointments,
                'cancelled_appointments' => $cancelledAppointments,
                'month_name' => $date->format('F'),
                'year_name' => $date->format('Y'),
            ];
        }

        return view('admin.analytics', compact(
            'timeframe',
            'startDate',
            'appointmentsByStatus',
            'dailyAppointments',
            'servicesAnalytics',
            'monthlyTrends'
        ));
    }

    /**
     * Display messages page.
     */
    public function messages(Request $request)
    {
        $query = ContactMessage::query();

        if ($request->filled('is_read')) {
            $query->where('is_read', $request->is_read);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $messages = $query->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.messages.index', compact('messages'));
    }

    /**
     * Mark message as read.
     */
    public function markMessageAsRead($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * Delete message.
     */
    public function deleteMessage($id)
    {
        ContactMessage::destroy($id);
        
        return response()->json(['success' => true]);
    }

    /**
     * Export appointments data.
     */
    public function exportAppointments(Request $request)
    {
        $query = Appointment::with(['service', 'doctor']);

        if ($request->filled('date_from')) {
            $query->whereDate('appointment_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('appointment_date', '<=', $request->date_to);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $appointments = $query->orderBy('appointment_date', 'desc')->get();

        $filename = 'appointments_' . date('Y-m-d_H-i-s') . '.csv';
        $filePath = storage_path('app/exports/' . $filename);

        // Create exports directory if it doesn't exist
        if (!file_exists(dirname($filePath))) {
            mkdir(dirname($filePath), 0755, true);
        }

        $handle = fopen($filePath, 'w');
        
        // CSV headers
        fputcsv($handle, [
            'ID',
            'Patient Name',
            'Patient Phone',
            'Patient Email',
            'Service',
            'Doctor',
            'Appointment Date',
            'Appointment Time',
            'Status',
            'Notes',
            'Created At'
        ]);

        foreach ($appointments as $appointment) {
            fputcsv($handle, [
                $appointment->id,
                $appointment->patient_name,
                $appointment->patient_phone,
                $appointment->patient_email,
                $appointment->service->name ?? 'N/A',
                $appointment->doctor->name ?? 'N/A',
                $appointment->appointment_date,
                $appointment->appointment_time,
                $appointment->status,
                $appointment->notes ?? '',
                $appointment->created_at
            ]);
        }

        fclose($handle);

        return response()->download($filePath, $filename);
    }

    /**
     * System settings page.
     */
    public function settings()
    {
        $settings = Setting::first();
        $doctors = Doctor::get();
        $services = Service::get();

        return view('admin.settings', compact('settings', 'doctors', 'services'));
    }

    /**
     * Update system settings.
     */
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'clinic_name' => 'required|string|max:255',
            'clinic_phone' => 'required|string|max:255',
            'clinic_email' => 'required|email',
            'clinic_address' => 'required|string',
            'working_hours' => 'nullable|array',
            'appointment_duration' => 'required|integer|min:15|max:120',
            'max_appointments_per_day' => 'required|integer|min:1',
            'whatsapp_number' => 'nullable|string',
            'facebook_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'google_maps_url' => 'nullable|url',
            'google_analytics_id' => 'nullable|string',
        ]);

        $settings = Setting::firstOrCreate([]);
        $settings->update($validated);

        return redirect()->route('admin.settings')
            ->with('success', 'تم تحديث إعدادات النظام بنجاح');
    }
}