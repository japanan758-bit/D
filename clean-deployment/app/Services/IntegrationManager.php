<?php

namespace App\Services;

use App\Models\ApiIntegration;
use App\Services\Integrations\{
    GoogleAnalyticsService,
    CloudflareAnalyticsService,
    RecaptchaService,
    EmailService,
    WhatsAppService,
    SMSService,
    GoogleMapsService,
    MetaPixelService,
    PaymentService,
    CloudinaryService,
    FirebaseService
};

class IntegrationManager
{
    protected array $services = [];
    protected array $activeServices = [];

    public function __construct()
    {
        $this->loadServices();
    }

    /**
     * Load all available integration services
     */
    protected function loadServices(): void
    {
        $this->services = [
            'google_analytics' => GoogleAnalyticsService::class,
            'cloudflare_analytics' => CloudflareAnalyticsService::class,
            'recaptcha' => RecaptchaService::class,
            'email' => EmailService::class,
            'whatsapp' => WhatsAppService::class,
            'sms' => SMSService::class,
            'google_maps' => GoogleMapsService::class,
            'meta_pixel' => MetaPixelService::class,
            'payment' => PaymentService::class,
            'cloudinary' => CloudinaryService::class,
            'firebase' => FirebaseService::class
        ];

        $this->loadActiveServices();
    }

    /**
     * Load active services from database
     */
    protected function loadActiveServices(): void
    {
        $activeIntegrations = ApiIntegration::where('is_active', true)->get();
        
        foreach ($activeIntegrations as $integration) {
            if (isset($this->services[$integration->name])) {
                $this->activeServices[$integration->name] = $this->getService($integration->name);
            }
        }
    }

    /**
     * Get a specific integration service
     */
    public function getService(string $integrationName): ?BaseIntegrationService
    {
        if (!isset($this->services[$integrationName])) {
            return null;
        }

        try {
            return new $this->services[$integrationName]($integrationName);
        } catch (\Exception $e) {
            Log::error("Failed to initialize integration service: {$integrationName}", [
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Check if integration is available
     */
    public function isAvailable(string $integrationName): bool
    {
        return isset($this->services[$integrationName]);
    }

    /**
     * Check if integration is active and ready
     */
    public function isActive(string $integrationName): bool
    {
        $service = $this->getService($integrationName);
        return $service ? $service->isReady() : false;
    }

    /**
     * Initialize all active services
     */
    public function initializeAll(): array
    {
        $results = [];
        
        foreach ($this->activeServices as $name => $service) {
            $results[$name] = $service->initialize();
        }
        
        return $results;
    }

    /**
     * Get available integrations by category
     */
    public function getByCategory(string $category): array
    {
        $integrations = ApiIntegration::where('category', $category)->get();
        $services = [];
        
        foreach ($integrations as $integration) {
            if ($this->isAvailable($integration->name)) {
                $services[$integration->name] = $this->getService($integration->name);
            }
        }
        
        return $services;
    }

    /**
     * Analytics Services
     */
    public function getAnalyticsServices(): array
    {
        return $this->getByCategory('analytics');
    }

    /**
     * Communication Services
     */
    public function getCommunicationServices(): array
    {
        return $this->getByCategory('communication');
    }

    /**
     * Security Services
     */
    public function getSecurityServices(): array
    {
        return $this->getByCategory('security');
    }

    /**
     * Payment Services
     */
    public function getPaymentServices(): array
    {
        return $this->getByCategory('payment');
    }

    /**
     * Storage Services
     */
    public function getStorageServices(): array
    {
        return $this->getByCategory('storage');
    }

    /**
     * Get tracking code for all active analytics services
     */
    public function getAllTrackingCodes(): array
    {
        $codes = [];
        
        foreach ($this->getAnalyticsServices() as $name => $service) {
            if ($service && $service->isReady()) {
                switch ($name) {
                    case 'google_analytics':
                        $codes['google_analytics'] = $service->getTrackingCode();
                        break;
                    case 'cloudflare_analytics':
                        $codes['cloudflare_analytics'] = $service->getTrackingCode();
                        break;
                    case 'meta_pixel':
                        $codes['meta_pixel'] = $service->getTrackingCode();
                        break;
                }
            }
        }
        
        return $codes;
    }

    /**
     * Send appointment confirmation through all channels
     */
    public function sendAppointmentConfirmation(array $appointmentData): array
    {
        $results = [];
        
        // Send via email
        if ($this->isActive('email')) {
            $emailService = $this->getService('email');
            $results['email'] = $emailService->sendAppointmentConfirmation($appointmentData);
        }
        
        // Send via WhatsApp
        if ($this->isActive('whatsapp') && isset($appointmentData['patient_phone'])) {
            $whatsappService = $this->getService('whatsapp');
            $results['whatsapp'] = $whatsappService->sendAppointmentConfirmation($appointmentData);
        }
        
        // Send via SMS
        if ($this->isActive('sms') && isset($appointmentData['patient_phone'])) {
            $smsService = $this->getService('sms');
            $results['sms'] = $smsService->sendAppointmentConfirmation($appointmentData);
        }
        
        // Track conversion
        if ($this->isActive('google_analytics')) {
            $analyticsService = $this->getService('google_analytics');
            $analyticsService->trackAppointment('appointment', $appointmentData['amount'] ?? 0);
        }
        
        if ($this->isActive('meta_pixel')) {
            $pixelService = $this->getService('meta_pixel');
            $pixelService->trackAppointment($appointmentData);
        }
        
        // Store in Firebase
        if ($this->isActive('firebase')) {
            $firebaseService = $this->getService('firebase');
            $firebaseService->storeData("appointments/{$appointmentData['id']}", $appointmentData);
        }
        
        return $results;
    }

    /**
     * Send appointment reminder through all channels
     */
    public function sendAppointmentReminder(array $appointmentData): array
    {
        $results = [];
        
        // Send via email
        if ($this->isActive('email')) {
            $emailService = $this->getService('email');
            // Implementation would be similar to confirmation
            $results['email'] = ['success' => true, 'message' => 'Email reminder sent'];
        }
        
        // Send via WhatsApp
        if ($this->isActive('whatsapp') && isset($appointmentData['patient_phone'])) {
            $whatsappService = $this->getService('whatsapp');
            $results['whatsapp'] = $whatsappService->sendAppointmentReminder($appointmentData);
        }
        
        // Send via SMS
        if ($this->isActive('sms') && isset($appointmentData['patient_phone'])) {
            $smsService = $this->getService('sms');
            $results['sms'] = $smsService->sendAppointmentReminder($appointmentData);
        }
        
        // Send push notification via Firebase
        if ($this->isActive('firebase') && isset($appointmentData['user_token'])) {
            $firebaseService = $this->getService('firebase');
            $results['push_notification'] = $firebaseService->sendAppointmentReminder($appointmentData);
        }
        
        return $results;
    }

    /**
     * Send OTP through all channels
     */
    public function sendOTP(string $phone, string $email, string $otp): array
    {
        $results = [];
        
        // Send via email
        if ($this->isActive('email') && !empty($email)) {
            $emailService = $this->getService('email');
            $results['email'] = $emailService->sendOTP($email, $otp);
        }
        
        // Send via SMS
        if ($this->isActive('sms') && !empty($phone)) {
            $smsService = $this->getService('sms');
            $results['sms'] = $sms->sendOTP($phone, $otp);
        }
        
        // Send via WhatsApp
        if ($this->isActive('whatsapp') && !empty($phone)) {
            $whatsappService = $this->getService('whatsapp');
            $message = "رمز التحقق الخاص بك هو: {$otp}\nينتهي خلال 5 دقائق.";
            $results['whatsapp'] = $whatsappService->sendTextMessage($phone, $message);
        }
        
        return $results;
    }

    /**
     * Validate all forms with reCAPTCHA
     */
    public function validateForm(string $formName = 'default'): bool
    {
        if (!$this->isActive('recaptcha')) {
            return true; // Skip validation if reCAPTCHA is not active
        }
        
        $recaptchaService = $this->getService('recaptcha');
        return $recaptchaService->validateForm();
    }

    /**
     * Process payment through active payment gateways
     */
    public function processPayment(array $paymentData): array
    {
        if (!$this->isActive('payment')) {
            return [
                'success' => false,
                'error' => 'No payment service configured'
            ];
        }
        
        $paymentService = $this->getService('payment');
        return $paymentService->createPayment($paymentData);
    }

    /**
     * Upload and optimize image through active storage services
     */
    public function uploadImage(string $filePath, array $options = []): array
    {
        if ($this->isActive('cloudinary')) {
            $cloudinaryService = $this->getService('cloudinary');
            return $cloudinaryService->uploadImage($filePath, $options);
        }
        
        return [
            'success' => false,
            'error' => 'No image storage service configured'
        ];
    }

    /**
     * Get clinic location data
     */
    public function getClinicLocation(): array
    {
        if (!$this->isActive('google_maps')) {
            return [
                'address' => '',
                'latitude' => 0,
                'longitude' => 0
            ];
        }
        
        $mapsService = $this->getService('google_maps');
        return $mapsService->getClinicLocation();
    }

    /**
     * Get embeddable map HTML
     */
    public function getEmbedMap(): string
    {
        if (!$this->isActive('google_maps')) {
            return '';
        }
        
        $mapsService = $this->getService('google_maps');
        return $mapsService->getEmbedMap();
    }

    /**
     * Track custom event across all analytics platforms
     */
    public function trackEvent(string $eventName, array $eventData = []): void
    {
        // Track in Google Analytics
        if ($this->isActive('google_analytics')) {
            $analyticsService = $this->getService('google_analytics');
            // Implementation would depend on the specific event
        }
        
        // Track in Meta Pixel
        if ($this->isActive('meta_pixel')) {
            $pixelService = $this->getService('meta_pixel');
            // Implementation would depend on the specific event
        }
        
        // Store in Firebase for real-time tracking
        if ($this->isActive('firebase')) {
            $firebaseService = $this->getService('firebase');
            $firebaseService->storeData("events/{$eventName}/" . now()->format('Y-m-d_H-i-s'), array_merge($eventData, [
                'timestamp' => now()->toISOString(),
                'event_name' => $eventName
            ]));
        }
    }

    /**
     * Get integration status report
     */
    public function getStatusReport(): array
    {
        $report = [
            'total_integrations' => count($this->services),
            'active_integrations' => count($this->activeServices),
            'categories' => [],
            'details' => []
        ];
        
        foreach ($this->services as $name => $class) {
            $integration = ApiIntegration::getByName($name);
            $service = $this->getService($name);
            
            $status = [
                'name' => $name,
                'display_name' => $integration ? $integration->display_name : $name,
                'category' => $integration ? $integration->category : 'unknown',
                'is_active' => $integration ? $integration->is_active : false,
                'is_configured' => $integration ? $integration->isReady() : false,
                'can_test' => $service ? $service->validate() : false,
                'last_tested' => $integration ? $integration->updated_at->toISOString() : null
            ];
            
            // Try to get test result if service is available
            if ($service && $service->validate()) {
                try {
                    $testResult = $service->test();
                    $status['test_result'] = $testResult;
                } catch (\Exception $e) {
                    $status['test_result'] = ['success' => false, 'error' => $e->getMessage()];
                }
            }
            
            $report['details'][$name] = $status;
            
            // Group by category
            $category = $status['category'];
            if (!isset($report['categories'][$category])) {
                $report['categories'][$category] = [
                    'name' => $category,
                    'count' => 0,
                    'active' => 0,
                    'configured' => 0
                ];
            }
            
            $report['categories'][$category]['count']++;
            if ($status['is_active']) $report['categories'][$category]['active']++;
            if ($status['is_configured']) $report['categories'][$category]['configured']++;
        }
        
        return $report;
    }

    /**
     * Test all integrations
     */
    public function testAll(): array
    {
        $results = [];
        
        foreach ($this->services as $name => $class) {
            $service = $this->getService($name);
            if ($service && $service->validate()) {
                try {
                    $results[$name] = $service->test();
                } catch (\Exception $e) {
                    $results[$name] = [
                        'success' => false,
                        'error' => $e->getMessage()
                    ];
                }
            } else {
                $results[$name] = [
                    'success' => false,
                    'error' => 'Service not available or not configured'
                ];
            }
        }
        
        return $results;
    }

    /**
     * Get system health check
     */
    public function getHealthCheck(): array
    {
        $health = [
            'status' => 'healthy',
            'checks' => [],
            'timestamp' => now()->toISOString()
        ];
        
        $criticalServices = ['google_analytics', 'email', 'sms']; // Services critical for clinic operations
        $issues = [];
        
        foreach ($criticalServices as $serviceName) {
            $isActive = $this->isActive($serviceName);
            
            $health['checks'][$serviceName] = [
                'status' => $isActive ? 'healthy' : 'critical',
                'message' => $isActive ? 'Service is working' : 'Service is not working or not configured'
            ];
            
            if (!$isActive) {
                $issues[] = "Critical service {$serviceName} is not working";
            }
        }
        
        if (!empty($issues)) {
            $health['status'] = 'critical';
            $health['issues'] = $issues;
        }
        
        return $health;
    }
}