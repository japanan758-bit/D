<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatBotController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\MedicalRecordsController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\IntegrationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Set locale
app()->setLocale('ar');

// Simple login route for testing
Route::get('/admin-login', function() {
    $user = User::where('email', 'admin@clinic.com')->first();
    if ($user) {
        Auth::login($user);
        return redirect('/admin/dashboard');
    }
    return 'Admin user not found. Please create admin user first.';
});

// Logout route
Route::post('/admin-logout', function() {
    Auth::logout();
    return redirect('/');
})->name('logout');

// Test route for admin controller
Route::get('/test-admin-direct', function() {
    try {
        $controller = new \App\Http\Controllers\AdminDashboardController();
        $request = new \Illuminate\Http\Request();
        $response = $controller->index($request);
        return $response->getContent();
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
});

// Public Routes - Home Controller
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/testimonials', [HomeController::class, 'testimonials'])->name('testimonials');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/blog', [HomeController::class, 'blog'])->name('blog');
Route::get('/booking', [HomeController::class, 'booking'])->name('booking');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');

// Services Routes - Service Controller
Route::get('/services', [ServiceController::class, 'index'])->name('services');
Route::get('/services/{service}', [ServiceController::class, 'show'])->name('service-detail');

// Articles Routes - Article Controller
Route::get('/articles', [ArticleController::class, 'index'])->name('articles');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('article-detail');
Route::post('/articles/{id}/track-view', [ArticleController::class, 'trackView'])->name('track-article-view');

// Contact Routes
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Sitemap Route - Home Controller
Route::get('/sitemap.xml', [HomeController::class, 'sitemap'])->name('sitemap');

// Appointment Routes
Route::prefix('api/appointments')->group(function () {
    Route::get('/', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::post('/', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/availability', [AppointmentController::class, 'checkAvailability'])->name('appointments.availability');
});

Route::prefix('admin/appointments')->group(function () {
    Route::get('/', [AppointmentController::class, 'index'])->name('admin.appointments.index');
    Route::get('/{appointment}', [AppointmentController::class, 'show'])->name('admin.appointments.show');
    Route::patch('/{appointment}/confirm', [AppointmentController::class, 'confirm'])->name('admin.appointments.confirm');
    Route::patch('/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('admin.appointments.cancel');
    Route::patch('/{appointment}', [AppointmentController::class, 'update'])->name('admin.appointments.update');
    Route::delete('/{appointment}', [AppointmentController::class, 'destroy'])->name('admin.appointments.destroy');
});

// Page Builder Routes
Route::prefix('page-builder')->name('page-builder.')->middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'pageBuilder'])->name('index');
    Route::get('/create', [HomeController::class, 'createPage'])->name('create');
    Route::get('/edit/{pageId?}', [HomeController::class, 'editPage'])->name('edit');
    Route::get('/templates', [HomeController::class, 'pageTemplates'])->name('templates');
    Route::get('/template/{templateId}', [HomeController::class, 'loadTemplate'])->name('load-template');
    Route::get('/preview/{pageId}', [HomeController::class, 'previewPage'])->name('preview');
    Route::post('/save', [HomeController::class, 'savePage'])->name('save');
    Route::post('/save-template', [HomeController::class, 'saveAsTemplate'])->name('save-template');
    Route::get('/export/{pageId}', [HomeController::class, 'exportPage'])->name('export');
    Route::post('/import', [HomeController::class, 'importPage'])->name('import');
    Route::delete('/delete/{pageId}', [HomeController::class, 'deletePage'])->name('delete');
});

// API Routes for Page Builder
Route::prefix('api/page-builder')->name('api.page-builder.')->middleware('auth')->group(function () {
    Route::get('/components', [HomeController::class, 'getComponents'])->name('components');
    Route::get('/components/{type}', [HomeController::class, 'getComponent'])->name('component');
    Route::get('/themes', [HomeController::class, 'getThemes'])->name('themes');
    Route::get('/pages', [HomeController::class, 'getPages'])->name('pages');
    Route::get('/pages/{pageId}', [HomeController::class, 'getPage'])->name('page');
    Route::post('/components/add', [HomeController::class, 'addComponent'])->name('components.add');
    Route::put('/components/{componentId}', [HomeController::class, 'updateComponent'])->name('components.update');
    Route::delete('/components/{componentId}', [HomeController::class, 'deleteComponent'])->name('components.delete');
    Route::post('/components/reorder', [HomeController::class, 'reorderComponents'])->name('components.reorder');
    Route::post('/components/duplicate', [HomeController::class, 'duplicateComponent'])->name('components.duplicate');
});

// Include Theme Builder Routes
require __DIR__.'/theme-builder.php';

// Admin Dashboard Routes (temp: no auth middleware)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/appointments', [AdminDashboardController::class, 'appointments'])->name('appointments.index');
    Route::get('/analytics', [AdminDashboardController::class, 'analytics'])->name('analytics');
    Route::get('/messages', [AdminDashboardController::class, 'messages'])->name('messages.index');
    Route::patch('/messages/{message}/read', [AdminDashboardController::class, 'markMessageAsRead'])->name('messages.read');
    Route::delete('/messages/{message}', [AdminDashboardController::class, 'deleteMessage'])->name('messages.delete');
    Route::get('/appointments/export', [AdminDashboardController::class, 'exportAppointments'])->name('appointments.export');
    Route::get('/settings', [AdminDashboardController::class, 'settings'])->name('settings');
    Route::patch('/settings', [AdminDashboardController::class, 'updateSettings'])->name('settings.update');
});

// Doctors Management Routes
Route::prefix('admin/doctors')->name('admin.doctors.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DoctorController::class, 'index'])->name('index');
    Route::get('/create', [DoctorController::class, 'create'])->name('create');
    Route::post('/', [DoctorController::class, 'store'])->name('store');
    Route::get('/{doctor}', [DoctorController::class, 'show'])->name('show');
    Route::get('/{doctor}/edit', [DoctorController::class, 'edit'])->name('edit');
    Route::patch('/{doctor}', [DoctorController::class, 'update'])->name('update');
    Route::delete('/{doctor}', [DoctorController::class, 'destroy'])->name('destroy');
    Route::patch('/{doctor}/toggle-availability', [DoctorController::class, 'toggleAvailability'])->name('toggle-availability');
    Route::get('/{doctor}/schedule', [DoctorController::class, 'getSchedule'])->name('schedule');
    Route::get('/{doctor}/statistics', [DoctorController::class, 'statistics'])->name('statistics');
    Route::get('/export', [DoctorController::class, 'export'])->name('export');
});

Route::prefix('doctors')->name('doctors.')->group(function () {
    Route::get('/', [DoctorController::class, 'index'])->name('index');
    Route::get('/{doctor}', [DoctorController::class, 'show'])->name('show');
});

// API Routes for Doctors
Route::prefix('api/doctors')->name('api.doctors.')->group(function () {
    Route::get('/', [DoctorController::class, 'getDoctors'])->name('list');
    Route::get('/by-specialization', [DoctorController::class, 'bySpecialization'])->name('by-specialization');
});

// Patient Portal Routes
Route::prefix('patient')->name('patient.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [PatientController::class, 'dashboard'])->name('dashboard');
    Route::get('/book-appointment', [PatientController::class, 'showBookingForm'])->name('book-appointment');
    Route::post('/book-appointment', [PatientController::class, 'bookAppointment'])->name('book-appointment.submit');
    Route::get('/appointments', [PatientController::class, 'appointments'])->name('appointments');
    Route::get('/appointments/{appointment}', [PatientController::class, 'showAppointment'])->name('appointment-details');
    Route::patch('/appointments/{appointment}/cancel', [PatientController::class, 'cancelAppointment'])->name('appointments.cancel');
    Route::get('/profile', [PatientController::class, 'profile'])->name('profile');
    Route::patch('/profile', [PatientController::class, 'updateProfile'])->name('profile.update');
    Route::get('/change-password', [PatientController::class, 'showChangePasswordForm'])->name('change-password.form');
    Route::patch('/change-password', [PatientController::class, 'changePassword'])->name('change-password');
    Route::get('/appointments/export', [PatientController::class, 'exportAppointments'])->name('appointments.export');
});

// Patient API Routes
Route::prefix('api/patient')->name('api.patient.')->group(function () {
    Route::get('/available-slots', [PatientController::class, 'getAvailableSlots'])->name('available-slots');
});

// Medical Records Routes
Route::prefix('admin/medical-records')->name('admin.medical-records.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [MedicalRecordsController::class, 'index'])->name('index');
    Route::get('/create', [MedicalRecordsController::class, 'create'])->name('create');
    Route::post('/', [MedicalRecordsController::class, 'store'])->name('store');
    Route::get('/{medicalRecord}', [MedicalRecordsController::class, 'show'])->name('show');
    Route::get('/{medicalRecord}/edit', [MedicalRecordsController::class, 'edit'])->name('edit');
    Route::patch('/{medicalRecord}', [MedicalRecordsController::class, 'update'])->name('update');
    Route::delete('/{medicalRecord}', [MedicalRecordsController::class, 'destroy'])->name('destroy');
    Route::get('/{medicalRecord}/attachments/{index}/download', [MedicalRecordsController::class, 'downloadAttachment'])->name('attachments.download');
    Route::get('/{medicalRecord}/report', [MedicalRecordsController::class, 'generateReport'])->name('report');
    Route::get('/{medicalRecord}/pdf', [MedicalRecordsController::class, 'exportPdf'])->name('pdf');
    Route::get('/export', [MedicalRecordsController::class, 'export'])->name('export');
    Route::post('/search-by-patient', [MedicalRecordsController::class, 'searchByPatient'])->name('search-by-patient');
    Route::post('/get-patient-history', [MedicalRecordsController::class, 'getPatientHistory'])->name('get-patient-history');
});

// Quick Medical Records for Appointments
Route::prefix('appointments/{appointment}')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/medical-record', [MedicalRecordsController::class, 'quickRecord'])->name('appointments.quick-record');
});

// Medical Records API Routes
Route::prefix('api/medical-records')->name('api.medical-records.')->group(function () {
    Route::get('/', [MedicalRecordsController::class, 'index'])->name('index');
    Route::get('/search-by-patient', [MedicalRecordsController::class, 'searchByPatient'])->name('search-by-patient');
});

// Notifications Routes
Route::prefix('notifications')->name('notifications.')->middleware('auth')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'notifications'])->name('index');
    Route::get('/{notification}/mark-read', [AdminDashboardController::class, 'markNotificationAsRead'])->name('mark-read');
    Route::post('/mark-all-read', [AdminDashboardController::class, 'markAllNotificationsAsRead'])->name('mark-all-read');
    Route::delete('/{notification}', [AdminDashboardController::class, 'deleteNotification'])->name('delete');
});

// Reports Routes
Route::prefix('admin/reports')->name('admin.reports.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'reports'])->name('index');
    Route::get('/daily', [AdminDashboardController::class, 'dailyReport'])->name('daily');
    Route::get('/weekly', [AdminDashboardController::class, 'weeklyReport'])->name('weekly');
    Route::get('/monthly', [AdminDashboardController::class, 'monthlyReport'])->name('monthly');
    Route::get('/patients', [AdminDashboardController::class, 'patientReport'])->name('patients');
    Route::get('/doctors', [AdminDashboardController::class, 'doctorReport'])->name('doctors');
    Route::get('/revenue', [AdminDashboardController::class, 'revenueReport'])->name('revenue');
    Route::post('/export', [AdminDashboardController::class, 'exportReport'])->name('export');
});

// System Management Routes
Route::prefix('admin/system')->name('admin.system.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/health', [AdminDashboardController::class, 'systemHealth'])->name('health');
    Route::get('/backup', [AdminDashboardController::class, 'backupManager'])->name('backup');
    Route::post('/backup/create', [AdminDashboardController::class, 'createBackup'])->name('backup.create');
    Route::post('/backup/restore', [AdminDashboardController::class, 'restoreBackup'])->name('backup.restore');
    Route::get('/settings', [AdminDashboardController::class, 'systemSettings'])->name('settings');
    Route::post('/settings', [AdminDashboardController::class, 'updateSystemSettings'])->name('settings.update');
    Route::post('/logs/clear', [AdminDashboardController::class, 'clearLogs'])->name('logs.clear');
});

// ChatBot API Routes - Advanced Multi-API Chatbot
Route::prefix('api/chatbot')->name('chatbot.')->group(function () {
    Route::post('/message', [ChatBotController::class, 'handleMessage'])->name('message');
    Route::get('/statistics', [ChatBotController::class, 'getStatistics'])->name('statistics');
});

// Integration API Routes
Route::prefix('api/integrations')->name('integrations.')->group(function () {
    Route::get('/status', [IntegrationController::class, 'getStatus'])->name('status');
    Route::post('/test', [IntegrationController::class, 'testIntegration'])->name('test');
    Route::get('/tracking-codes', [IntegrationController::class, 'getTrackingCodes'])->name('tracking-codes');
    Route::post('/appointment/confirm', [IntegrationController::class, 'sendAppointmentConfirmation'])->name('appointment.confirm');
    Route::post('/appointment/reminder', [IntegrationController::class, 'sendAppointmentReminder'])->name('appointment.reminder');
    Route::post('/send-otp', [IntegrationController::class, 'sendOTP'])->name('send-otp');
    Route::post('/validate-form', [IntegrationController::class, 'validateForm'])->name('validate-form');
    Route::post('/process-payment', [IntegrationController::class, 'processPayment'])->name('process-payment');
    Route::post('/upload-image', [IntegrationController::class, 'uploadImage'])->name('upload-image');
    Route::get('/clinic-location', [IntegrationController::class, 'getClinicLocation'])->name('clinic-location');
    Route::post('/track-event', [IntegrationController::class, 'trackEvent'])->name('track-event');
    Route::get('/health-check', [IntegrationController::class, 'getHealthCheck'])->name('health-check');
    Route::post('/initialize', [IntegrationController::class, 'initializeIntegrations'])->name('initialize');
});
