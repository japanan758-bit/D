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


// Quick Medical Records for Appointments - Note: Filament Resource handles creation now, this legacy route is kept if needed but controller was deleted.
// Route::prefix('appointments/{appointment}')->middleware(['auth', 'admin'])->group(function () {
//     Route::get('/medical-record', [MedicalRecordsController::class, 'quickRecord'])->name('appointments.quick-record');
// });

// Medical Records API Routes - Disabled as MedicalRecordsController is removed.
// Use Filament API or recreate dedicated API controller if needed.
// Route::prefix('api/medical-records')->name('api.medical-records.')->group(function () {
//     Route::get('/', [MedicalRecordsController::class, 'index'])->name('index');
//     Route::get('/search-by-patient', [MedicalRecordsController::class, 'searchByPatient'])->name('search-by-patient');
// });

// Prescription Printing Route
Route::get('/admin/medical-records/{record}/prescription', function (\App\Models\MedicalRecord $record) {
    // Ensure user is authorized (admin/doctor)
    if (!Auth::check() || !Auth::user()->canAccessPanel(Filament\Facades\Filament::getPanel('admin'))) {
        abort(403);
    }

    $settings = \App\Models\Setting::first();
    return view('pdf.prescription', compact('record', 'settings'));
})->name('medical-records.prescription');


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
