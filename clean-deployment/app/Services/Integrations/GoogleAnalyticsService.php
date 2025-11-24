<?php

namespace App\Services\Integrations;

use App\Services\BaseIntegrationService;

class GoogleAnalyticsService extends BaseIntegrationService
{
    public function initialize(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        // Set up GA4 tracking
        $this->log('initialized', ['measurement_id' => $this->getConfig('measurement_id')]);
        
        return true;
    }

    public function validate(): bool
    {
        $measurementId = $this->getConfig('measurement_id');
        $apiSecret = $this->getApiKey('api_secret');

        return !empty($measurementId) && !empty($apiSecret);
    }

    public function test(): array
    {
        if (!$this->isReady()) {
            return [
                'success' => false,
                'message' => 'Integration is not ready. Check configuration.'
            ];
        }

        // Test with a simple event
        $testEvent = [
            'client_id' => 'test_client_' . time(),
            'events' => [
                [
                    'name' => 'test_event',
                    'parameters' => [
                        'test_parameter' => 'test_value'
                    ]
                ]
            ]
        ];

        $result = $this->sendEvent($testEvent);
        
        return [
            'success' => $result['success'],
            'message' => $result['success'] ? 'Test event sent successfully' : 'Failed to send test event',
            'data' => $result
        ];
    }

    /**
     * Send GA4 event
     */
    public function sendEvent(array $eventData): array
    {
        $measurementId = $this->getConfig('measurement_id');
        $apiSecret = $this->getApiKey('api_secret');
        
        $url = "https://www.google-analytics.com/mp/collect?measurement_id={$measurementId}&api_secret={$apiSecret}";
        
        return $this->makeRequest('POST', $url, $eventData, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * Send page view event
     */
    public function sendPageView(string $pageTitle, string $pagePath, string $pageLocation): array
    {
        $eventData = [
            'client_id' => session()->getId(),
            'events' => [
                [
                    'name' => 'page_view',
                    'parameters' => [
                        'page_title' => $pageTitle,
                        'page_location' => $pageLocation,
                        'page_path' => $pagePath
                    ]
                ]
            ]
        ];

        return $this->sendEvent($eventData);
    }

    /**
     * Track appointment booking
     */
    public function trackAppointment(string $appointmentType, float $value): array
    {
        $eventData = [
            'client_id' => session()->getId(),
            'events' => [
                [
                    'name' => 'appointment_booked',
                    'parameters' => [
                        'appointment_type' => $appointmentType,
                        'value' => $value,
                        'currency' => 'SAR'
                    ]
                ]
            ]
        ];

        return $this->sendEvent($eventData);
    }
}