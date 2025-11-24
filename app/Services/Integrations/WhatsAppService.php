<?php

namespace App\Services\Integrations;

use App\Services\BaseIntegrationService;

class WhatsAppService extends BaseIntegrationService
{
    public function initialize(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $this->log('initialized', [
            'phone_number_id' => $this->getConfig('phone_number_id'),
            'business_account_id' => $this->getConfig('business_account_id')
        ]);
        
        return true;
    }

    public function validate(): bool
    {
        $token = $this->getApiKey('access_token');
        $phoneNumberId = $this->getConfig('phone_number_id');

        return !empty($token) && !empty($phoneNumberId);
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
            $token = $this->getApiKey('access_token');
            $phoneNumberId = $this->getConfig('phone_number_id');

            $response = $this->makeRequest('GET', "https://graph.facebook.com/v17.0/{$phoneNumberId}", [], [
                'Authorization' => 'Bearer ' . $token
            ]);

            return [
                'success' => $response['success'],
                'message' => $response['success'] ? 'WhatsApp API connection successful' : 'Failed to connect to WhatsApp API',
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
     * Send text message
     */
    public function sendTextMessage(string $to, string $message): array
    {
        $token = $this->getApiKey('access_token');
        $phoneNumberId = $this->getConfig('phone_number_id');

        $data = [
            'messaging_product' => 'whatsapp',
            'to' => $to,
            'type' => 'text',
            'text' => [
                'body' => $message
            ]
        ];

        $result = $this->makeRequest('POST', "https://graph.facebook.com/v17.0/{$phoneNumberId}/messages", $data, [
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json'
        ]);

        if ($result['success']) {
            $this->log('message_sent', ['to' => $to, 'type' => 'text']);
        }

        return $result;
    }

    /**
     * Send appointment confirmation message
     */
    public function sendAppointmentConfirmation(array $appointmentData): array
    {
        $message = $this->formatAppointmentMessage($appointmentData);
        
        return $this->sendTextMessage($appointmentData['patient_phone'], $message);
    }

    /**
     * Send appointment reminder
     */
    public function sendAppointmentReminder(array $appointmentData): array
    {
        $message = $this->formatReminderMessage($appointmentData);
        
        return $this->sendTextMessage($appointmentData['patient_phone'], $message);
    }

    /**
     * Send media message (image, document, etc.)
     */
    public function sendMediaMessage(string $to, string $mediaUrl, string $mediaType = 'image'): array
    {
        $token = $this->getApiKey('access_token');
        $phoneNumberId = $this->getConfig('phone_number_id');

        $data = [
            'messaging_product' => 'whatsapp',
            'to' => $to,
            'type' => $mediaType,
            $mediaType => [
                'link' => $mediaUrl
            ]
        ];

        $result = $this->makeRequest('POST', "https://graph.facebook.com/v17.0/{$phoneNumberId}/messages", $data, [
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json'
        ]);

        if ($result['success']) {
            $this->log('media_message_sent', ['to' => $to, 'media_type' => $mediaType]);
        }

        return $result;
    }

    /**
     * Format appointment confirmation message
     */
    private function formatAppointmentMessage(array $appointmentData): string
    {
        return "تم تأكيد موعدك بنجاح! 🎉\n\n" .
               "👨‍⚕️ Doctor: " . $appointmentData['doctor_name'] . "\n" .
               "📅 التاريخ: " . $appointmentData['appointment_date'] . "\n" .
               "⏰ الوقت: " . $appointmentData['appointment_time'] . "\n" .
               "📍 العنوان: " . $appointmentData['clinic_address'] . "\n" .
               "🔢 رقم التأكيد: " . $appointmentData['confirmation_number'] . "\n\n" .
               "يرجى الحضور قبل الموعد بـ 15 دقيقة.\n" .
               "في حالة التأجيل أو الإلغاء، يرجى التواصل معنا.";
    }

    /**
     * Format reminder message
     */
    private function formatReminderMessage(array $appointmentData): string
    {
        return "تذكير بموعدك غداً! ⏰\n\n" .
               "👨‍⚕️ Doctor: " . $appointmentData['doctor_name'] . "\n" .
               "📅 التاريخ: " . $appointmentData['appointment_date'] . "\n" .
               "⏰ الوقت: " . $appointmentData['appointment_time'] . "\n" .
               "🔢 رقم التأكيد: " . $appointmentData['confirmation_number'] . "\n\n" .
               "تذكر أن تحضر معك:\n" .
               "- الهوية الشخصية\n" .
               "- التقارير الطبية السابقة\n\n" .
               "شكراً لثقتكم بنا! 🏥";
    }

    /**
     * Check if phone number is subscribed to WhatsApp
     */
    public function isSubscribed(string $phoneNumber): bool
    {
        // This would require the WhatsApp Business API to check subscription status
        // For now, we'll assume all numbers can receive messages
        return true;
    }
}