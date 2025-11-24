<?php

namespace App\Services\Integrations;

use App\Services\BaseIntegrationService;

class SMSService extends BaseIntegrationService
{
    public function initialize(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $this->log('initialized', [
            'provider' => $this->getConfig('provider'),
            'sender_name' => $this->getConfig('sender_name')
        ]);
        
        return true;
    }

    public function validate(): bool
    {
        $provider = $this->getConfig('provider');
        
        switch ($provider) {
            case 'vodafone':
                return !empty($this->getApiKey('vodafone_api_key')) && 
                       !empty($this->getConfig('vodafone_sender_id'));
            case 'infobip':
                return !empty($this->getApiKey('infobip_api_key')) && 
                       !empty($this->getConfig('infobip_base_url'));
            case 'twilio':
                return !empty($this->getApiKey('twilio_sid')) && 
                       !empty($this->getApiKey('twilio_token')) &&
                       !empty($this->getConfig('twilio_from_number'));
            default:
                return false;
        }
    }

    public function test(): array
    {
        if (!$this->isReady()) {
            return [
                'success' => false,
                'message' => 'Integration is not ready. Check configuration.'
            ];
        }

        $testNumber = $this->getConfig('test_phone_number');
        
        if (empty($testNumber)) {
            return [
                'success' => false,
                'message' => 'No test phone number configured'
            ];
        }

        $result = $this->sendSMS($testNumber, 'Test SMS from Clinic Management System');
        
        return [
            'success' => $result['success'],
            'message' => $result['success'] ? 'Test SMS sent successfully' : 'Failed to send test SMS',
            'data' => $result
        ];
    }

    /**
     * Send SMS message
     */
    public function sendSMS(string $to, string $message): array
    {
        $provider = $this->getConfig('provider');
        
        switch ($provider) {
            case 'vodafone':
                return $this->sendVodafoneSMS($to, $message);
            case 'infobip':
                return $this->sendInfobipSMS($to, $message);
            case 'twilio':
                return $this->sendTwilioSMS($to, $message);
            default:
                return [
                    'success' => false,
                    'error' => 'Unknown SMS provider'
                ];
        }
    }

    /**
     * Send OTP via SMS
     */
    public function sendOTP(string $phone, string $otp, int $expiresIn = 300): bool
    {
        $message = "رمز التحقق الخاص بك هو: {$otp}\nينتهي خلال " . ($expiresIn / 60) . " دقيقة.\nلا تشارك هذا الرمز مع أحد.";
        
        $result = $this->sendSMS($phone, $message);
        
        if ($result['success']) {
            $this->log('otp_sent', ['phone' => $phone, 'expires_in' => $expiresIn]);
        }
        
        return $result['success'];
    }

    /**
     * Send appointment reminder SMS
     */
    public function sendAppointmentReminder(array $appointmentData): bool
    {
        $message = "تذكير: موعدك غداً مع د. {$appointmentData['doctor_name']}\n" .
                  "التاريخ: {$appointmentData['appointment_date']}\n" .
                  "الوقت: {$appointmentData['appointment_time']}\n" .
                  "رقم التأكيد: {$appointmentData['confirmation_number']}\n" .
                  "عنوان العيادة: {$appointmentData['clinic_address']}";
        
        $result = $this->sendSMS($appointmentData['patient_phone'], $message);
        
        if ($result['success']) {
            $this->log('appointment_reminder_sent', [
                'phone' => $appointmentData['patient_phone'],
                'appointment_id' => $appointmentData['id'] ?? null
            ]);
        }
        
        return $result['success'];
    }

    /**
     * Send appointment confirmation SMS
     */
    public function sendAppointmentConfirmation(array $appointmentData): bool
    {
        $message = "تم تأكيد موعدك بنجاح! ✅\n" .
                  "د. {$appointmentData['doctor_name']}\n" .
                  "التاريخ: {$appointmentData['appointment_date']}\n" .
                  "الوقت: {$appointmentData['appointment_time']}\n" .
                  "رقم التأكيد: {$appointmentData['confirmation_number']}\n" .
                  "يرجى الحضور قبل الموعد بـ 15 دقيقة.";
        
        $result = $this->sendSMS($appointmentData['patient_phone'], $message);
        
        if ($result['success']) {
            $this->log('appointment_confirmation_sent', [
                'phone' => $appointmentData['patient_phone'],
                'appointment_id' => $appointmentData['id'] ?? null
            ]);
        }
        
        return $result['success'];
    }

    /**
     * Send Vodafone SMS
     */
    private function sendVodafoneSMS(string $to, string $message): array
    {
        $apiKey = $this->getApiKey('vodafone_api_key');
        $senderId = $this->getConfig('vodafone_sender_id');
        
        $data = [
            'ApiKey' => $apiKey,
            'SenderId' => $senderId,
            'MsgType' => 'text',
            'Recipient' => $to,
            'VarData' => $message
        ];
        
        return $this->makeRequest('POST', 'https://api.vodafone.com.qa/sms/api', $data, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * Send Infobip SMS
     */
    private function sendInfobipSMS(string $to, string $message): array
    {
        $apiKey = $this->getApiKey('infobip_api_key');
        $baseUrl = $this->getConfig('infobip_base_url');
        
        $data = [
            'from' => $this->getConfig('infobip_sender_name'),
            'to' => $to,
            'message' => $message
        ];
        
        return $this->makeRequest('POST', "{$baseUrl}/sms/1/text/single", $data, [
            'Authorization' => 'App ' . $apiKey,
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * Send Twilio SMS
     */
    private function sendTwilioSMS(string $to, string $message): array
    {
        $sid = $this->getApiKey('twilio_sid');
        $token = $this->getApiKey('twilio_token');
        $fromNumber = $this->getConfig('twilio_from_number');
        
        // Use Twilio REST API
        $url = "https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json";
        $data = [
            'To' => $to,
            'From' => $fromNumber,
            'Body' => $message
        ];
        
        return $this->makeRequest('POST', $url, $data, [
            'Authorization' => 'Basic ' . base64_encode($sid . ':' . $token)
        ]);
    }

    /**
     * Validate phone number format
     */
    public function validatePhoneNumber(string $phone): bool
    {
        // Remove any non-digit characters except +
        $cleanedPhone = preg_replace('/[^0-9+]/', '', $phone);
        
        // Check for valid Saudi phone number formats
        $patterns = [
            '/^(\+966|0)?[5-9][0-9]{8}$/', // Mobile: +9665xxxxxxxx or 05xxxxxxxx
            '/^(\+966|0)?[1-4][0-9]{7}$/', // Landline: +9661xxxxxxxx or 01xxxxxxxx
        ];
        
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $cleanedPhone)) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Format phone number for SMS sending
     */
    public function formatPhoneNumber(string $phone): string
    {
        $cleanedPhone = preg_replace('/[^0-9+]/', '', $phone);
        
        // If starts with +, keep as is
        if (str_starts_with($cleanedPhone, '+')) {
            return $cleanedPhone;
        }
        
        // If starts with 0, replace with +966
        if (str_starts_with($cleanedPhone, '0')) {
            return '+966' . substr($cleanedPhone, 1);
        }
        
        // Add Saudi country code if not present
        return '+966' . $cleanedPhone;
    }
}