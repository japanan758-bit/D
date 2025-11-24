<?php

namespace App\Http\Controllers;

use App\Models\ApiIntegration;
use App\Services\IntegrationManager;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class IntegrationController extends Controller
{
    protected $integrationManager;

    public function __construct(IntegrationManager $integrationManager)
    {
        $this->integrationManager = $integrationManager;
    }

    /**
     * Get integration status for frontend
     */
    public function getStatus(): JsonResponse
    {
        try {
            $status = $this->integrationManager->getStatusReport();
            
            return response()->json([
                'success' => true,
                'data' => $status
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to get integration status', ['error' => $e->getMessage()]);
            
            return response()->json([
                'success' => false,
                'error' => 'Failed to get integration status'
            ], 500);
        }
    }

    /**
     * Test a specific integration
     */
    public function testIntegration(Request $request): JsonResponse
    {
        $request->validate([
            'integration_name' => 'required|string'
        ]);

        try {
            $service = $this->integrationManager->getService($request->integration_name);
            
            if (!$service) {
                return response()->json([
                    'success' => false,
                    'error' => 'Integration not found'
                ], 404);
            }

            if (!$service->validate()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Integration is not properly configured'
                ], 400);
            }

            $result = $service->test();
            
            return response()->json([
                'success' => $result['success'],
                'message' => $result['message'],
                'data' => $result['data'] ?? []
            ]);

        } catch (\Exception $e) {
            Log::error('Integration test failed', [
                'integration' => $request->integration_name,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Test failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get tracking codes for frontend
     */
    public function getTrackingCodes(): JsonResponse
    {
        try {
            $codes = $this->integrationManager->getAllTrackingCodes();
            
            return response()->json([
                'success' => true,
                'data' => $codes
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to get tracking codes', ['error' => $e->getMessage()]);
            
            return response()->json([
                'success' => false,
                'error' => 'Failed to get tracking codes'
            ], 500);
        }
    }

    /**
     * Send appointment confirmation
     */
    public function sendAppointmentConfirmation(Request $request): JsonResponse
    {
        $request->validate([
            'appointment_id' => 'required',
            'patient_name' => 'required|string',
            'patient_email' => 'required|email',
            'patient_phone' => 'required|string',
            'doctor_name' => 'required|string',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|string',
            'clinic_address' => 'required|string',
            'confirmation_number' => 'required|string',
            'amount' => 'numeric'
        ]);

        try {
            $results = $this->integrationManager->sendAppointmentConfirmation($request->all());
            
            return response()->json([
                'success' => true,
                'message' => 'Appointment confirmations sent',
                'data' => $results
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to send appointment confirmation', [
                'appointment_id' => $request->appointment_id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Failed to send appointment confirmation'
            ], 500);
        }
    }

    /**
     * Send appointment reminder
     */
    public function sendAppointmentReminder(Request $request): JsonResponse
    {
        $request->validate([
            'appointment_id' => 'required',
            'patient_name' => 'required|string',
            'patient_phone' => 'required|string',
            'doctor_name' => 'required|string',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|string',
            'clinic_address' => 'required|string',
            'confirmation_number' => 'required|string',
            'user_token' => 'nullable|string' // Firebase token
        ]);

        try {
            $results = $this->integrationManager->sendAppointmentReminder($request->all());
            
            return response()->json([
                'success' => true,
                'message' => 'Appointment reminders sent',
                'data' => $results
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to send appointment reminder', [
                'appointment_id' => $request->appointment_id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Failed to send appointment reminder'
            ], 500);
        }
    }

    /**
     * Send OTP
     */
    public function sendOTP(Request $request): JsonResponse
    {
        $request->validate([
            'phone' => 'required|string',
            'email' => 'required|email',
            'otp' => 'required|string|size:6'
        ]);

        try {
            $results = $this->integrationManager->sendOTP($request->phone, $request->email, $request->otp);
            
            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully',
                'data' => $results
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to send OTP', [
                'phone' => $request->phone,
                'email' => $request->email,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Failed to send OTP'
            ], 500);
        }
    }

    /**
     * Validate form with reCAPTCHA
     */
    public function validateForm(Request $request): JsonResponse
    {
        $formName = $request->input('form_name', 'default');
        
        try {
            $isValid = $this->integrationManager->validateForm($formName);
            
            return response()->json([
                'success' => true,
                'valid' => $isValid,
                'message' => $isValid ? 'Form validation passed' : 'Form validation failed'
            ]);

        } catch (\Exception $e) {
            Log::error('Form validation failed', [
                'form' => $formName,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'valid' => false,
                'error' => 'Validation failed'
            ], 500);
        }
    }

    /**
     * Process payment
     */
    public function processPayment(Request $request): JsonResponse
    {
        $request->validate([
            'amount' => 'required|numeric',
            'appointment_id' => 'required',
            'patient_name' => 'required|string',
            'patient_email' => 'required|email',
            'patient_phone' => 'required|string',
            'description' => 'string'
        ]);

        try {
            $results = $this->integrationManager->processPayment($request->all());
            
            return response()->json([
                'success' => $results['success'],
                'message' => $results['success'] ? 'Payment created successfully' : 'Failed to create payment',
                'data' => $results
            ]);

        } catch (\Exception $e) {
            Log::error('Payment processing failed', [
                'appointment_id' => $request->appointment_id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Payment processing failed'
            ], 500);
        }
    }

    /**
     * Upload image
     */
    public function uploadImage(Request $request): JsonResponse
    {
        $request->validate([
            'image' => 'required|image|max:10240', // 10MB max
            'options' => 'nullable|array'
        ]);

        try {
            $image = $request->file('image');
            $options = $request->input('options', []);
            
            // Store temporarily
            $tempPath = $image->store('temp');
            
            $result = $this->integrationManager->uploadImage(storage_path('app/' . $tempPath), $options);
            
            // Clean up temp file
            unlink(storage_path('app/' . $tempPath));
            
            return response()->json([
                'success' => $result['success'],
                'message' => $result['success'] ? 'Image uploaded successfully' : 'Failed to upload image',
                'data' => $result
            ]);

        } catch (\Exception $e) {
            Log::error('Image upload failed', [
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Image upload failed'
            ], 500);
        }
    }

    /**
     * Get clinic location
     */
    public function getClinicLocation(): JsonResponse
    {
        try {
            $location = $this->integrationManager->getClinicLocation();
            $embedMap = $this->integrationManager->getEmbedMap();
            
            return response()->json([
                'success' => true,
                'data' => [
                    'location' => $location,
                    'embed_map' => $embedMap
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to get clinic location', ['error' => $e->getMessage()]);
            
            return response()->json([
                'success' => false,
                'error' => 'Failed to get clinic location'
            ], 500);
        }
    }

    /**
     * Track event
     */
    public function trackEvent(Request $request): JsonResponse
    {
        $request->validate([
            'event_name' => 'required|string',
            'event_data' => 'nullable|array'
        ]);

        try {
            $this->integrationManager->trackEvent($request->event_name, $request->event_data ?? []);
            
            return response()->json([
                'success' => true,
                'message' => 'Event tracked successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Event tracking failed', [
                'event' => $request->event_name,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Event tracking failed'
            ], 500);
        }
    }

    /**
     * Get system health check
     */
    public function getHealthCheck(): JsonResponse
    {
        try {
            $health = $this->integrationManager->getHealthCheck();
            
            return response()->json([
                'success' => true,
                'data' => $health
            ]);

        } catch (\Exception $e) {
            Log::error('Health check failed', ['error' => $e->getMessage()]);
            
            return response()->json([
                'success' => false,
                'error' => 'Health check failed'
            ], 500);
        }
    }

    /**
     * Initialize all integrations
     */
    public function initializeIntegrations(): JsonResponse
    {
        try {
            $results = $this->integrationManager->initializeAll();
            
            return response()->json([
                'success' => true,
                'message' => 'Integrations initialized',
                'data' => $results
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to initialize integrations', ['error' => $e->getMessage()]);
            
            return response()->json([
                'success' => false,
                'error' => 'Failed to initialize integrations'
            ], 500);
        }
    }
}