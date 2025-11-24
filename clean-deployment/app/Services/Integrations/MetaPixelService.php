<?php

namespace App\Services\Integrations;

use App\Services\BaseIntegrationService;

class MetaPixelService extends BaseIntegrationService
{
    public function initialize(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $this->log('initialized', [
            'pixel_id' => $this->getConfig('pixel_id')
        ]);
        
        return true;
    }

    public function validate(): bool
    {
        $pixelId = $this->getConfig('pixel_id');
        $accessToken = $this->getApiKey('access_token');

        return !empty($pixelId) && !empty($accessToken);
    }

    public function test(): array
    {
        if (!$this->isReady()) {
            return [
                'success' => false,
                'message' => 'Integration is not ready. Check configuration.'
            ];
        }

        try {
            $pixelId = $this->getConfig('pixel_id');
            $accessToken = $this->getApiKey('access_token');
            
            // Test by retrieving pixel info
            $response = $this->makeRequest('GET', "https://graph.facebook.com/v17.0/{$pixelId}", [
                'access_token' => $accessToken,
                'fields' => 'name,pixel_id'
            ]);

            return [
                'success' => $response['success'] && isset($response['data']['pixel_id']),
                'message' => $response['success'] ? 'Meta Pixel connection successful' : 'Failed to connect to Meta Pixel',
                'data' => $response['data'] ?? []
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Test failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get the JavaScript code for Meta Pixel
     */
    public function getTrackingCode(): string
    {
        $pixelId = $this->getConfig('pixel_id');
        
        return <<<HTML
<!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '{$pixelId}');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id={$pixelId}&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->
HTML;
    }

    /**
     * Track page view
     */
    public function trackPageView(): void
    {
        // This would typically be handled client-side with the JavaScript SDK
        // But we can also send server-side events for better tracking
        $this->sendEvent('PageView', [
            'page_title' => request()->path(),
            'page_url' => url()->current()
        ]);
    }

    /**
     * Track appointment booking
     */
    public function trackAppointment(array $appointmentData): array
    {
        $eventData = [
            'content_name' => 'Appointment Booking',
            'content_category' => 'Healthcare',
            'currency' => 'SAR',
            'value' => $appointmentData['amount'] ?? 0,
            'content_type' => 'appointment',
            'content_ids' => [$appointmentData['appointment_id'] ?? 'unknown']
        ];

        return $this->sendEvent('Schedule', $eventData);
    }

    /**
     * Track form submission
     */
    public function trackFormSubmission(string $formName, array $formData = []): array
    {
        return $this->sendEvent('Lead', [
            'content_name' => $formName,
            'content_category' => 'Form Submission',
            'custom_data' => $formData
        ]);
    }

    /**
     * Track contact form
     */
    public function trackContactForm(array $contactData): array
    {
        return $this->sendEvent('Contact', [
            'content_name' => 'Contact Form',
            'content_category' => 'Communication',
            'custom_data' => $contactData
        ]);
    }

    /**
     * Track phone call
     */
    public function trackPhoneCall(string $phoneNumber, string $context = 'website'): array
    {
        return $this->sendEvent('Contact', [
            'content_name' => 'Phone Call',
            'content_category' => 'Communication',
            'phone_number' => $phoneNumber,
            'context' => $context,
            'value' => 1
        ]);
    }

    /**
     * Track WhatsApp click
     */
    public function trackWhatsAppClick(string $phoneNumber): array
    {
        return $this->sendEvent('Contact', [
            'content_name' => 'WhatsApp Click',
            'content_category' => 'Communication',
            'phone_number' => $phoneNumber,
            'platform' => 'WhatsApp'
        ]);
    }

    /**
     * Send server-side event
     */
    private function sendEvent(string $eventName, array $eventData = []): array
    {
        $pixelId = $this->getConfig('pixel_id');
        $accessToken = $this->getApiKey('access_token');

        // Add user data if available
        $userData = [];
        if (auth()->check()) {
            $user = auth()->user();
            $userData = [
                'client_ip_address' => request()->ip(),
                'client_user_agent' => request()->userAgent(),
                'email' => hash('sha256', strtolower($user->email ?? '')),
            ];
        }

        $payload = [
            'data' => [
                [
                    'event_name' => $eventName,
                    'event_time' => time(),
                    'action_source' => 'website',
                    'event_source_url' => url()->current(),
                    'user_data' => $userData,
                    'custom_data' => array_merge([
                        'page_title' => config('app.name'),
                        'page_url' => url()->current()
                    ], $eventData)
                ]
            ],
            'access_token' => $accessToken
        ];

        $result = $this->makeRequest('POST', 'https://graph.facebook.com/v17.0/' . $pixelId . '/events', $payload);

        if ($result['success']) {
            $this->log('event_tracked', [
                'event_name' => $eventName,
                'event_data' => $eventData
            ]);
        }

        return $result;
    }

    /**
     * Get pixel statistics
     */
    public function getPixelStats(int $days = 30): array
    {
        $pixelId = $this->getConfig('pixel_id');
        $accessToken = $this->getApiKey('access_token');

        $endDate = date('Y-m-d');
        $startDate = date('Y-m-d', strtotime("-{$days} days"));

        $response = $this->makeRequest('GET', "https://graph.facebook.com/v17.0/{$pixelId}/insights", [
            'access_token' => $accessToken,
            'time_range' => json_encode([
                'since' => $startDate,
                'until' => $endDate
            ]),
            'fields' => 'impressions,clicks,spend,cpm,cpp,ctr'
        ]);

        return $response;
    }

    /**
     * Create custom conversion
     */
    public function createCustomConversion(array $conversionData): array
    {
        $accessToken = $this->getApiKey('access_token');
        $adAccountId = $this->getConfig('ad_account_id');

        $payload = [
            'name' => $conversionData['name'],
            'event_source_id' => $this->getConfig('pixel_id'),
            'rule' => json_encode([
                'and' => [
                    [
                        'operator' => 'CONTAINS',
                        'field' => 'event_name',
                        'value' => $conversionData['event_name']
                    ]
                ]
            ]),
            'default_conversion_value' => $conversionData['default_value'] ?? 0,
            'optimization_goal' => $conversionData['optimization_goal'] ?? 'REACH',
            'access_token' => $accessToken
        ];

        return $this->makeRequest('POST', "https://graph.facebook.com/v17.0/act_{$adAccountId}/customconversions", $payload);
    }
}