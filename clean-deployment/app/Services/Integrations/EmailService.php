<?php

namespace App\Services\Integrations;

use App\Services\BaseIntegrationService;
use Illuminate\Support\Facades\Mail;

class EmailService extends BaseIntegrationService
{
    public function initialize(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        // Configure Laravel Mail based on the provider
        $this->configureMailDriver();
        
        $this->log('initialized', [
            'provider' => $this->getConfig('provider'),
            'from_email' => $this->getConfig('from_email')
        ]);
        
        return true;
    }

    public function validate(): bool
    {
        $provider = $this->getConfig('provider');
        
        switch ($provider) {
            case 'mailgun':
                return !empty($this->getApiKey('mailgun_api_key')) && !empty($this->getConfig('mailgun_domain'));
            case 'sendgrid':
                return !empty($this->getApiKey('sendgrid_api_key'));
            case 'brevo':
                return !empty($this->getApiKey('brevo_api_key')) && !empty($this->getConfig('brevo_sender_email'));
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

        try {
            $testEmail = $this->getConfig('test_email');
            
            if (empty($testEmail)) {
                return [
                    'success' => false,
                    'message' => 'No test email configured'
                ];
            }

            // Send a test email
            Mail::raw('This is a test email from your Laravel application.', function ($message) use ($testEmail) {
                $message->to($testEmail)
                        ->subject('Test Email - Integration Configuration');
            });

            $this->log('test_email_sent', ['to' => $testEmail]);

            return [
                'success' => true,
                'message' => 'Test email sent successfully',
                'data' => ['sent_to' => $testEmail]
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to send test email: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Configure Laravel Mail driver
     */
    private function configureMailDriver(): void
    {
        $provider = $this->getConfig('provider');
        $fromEmail = $this->getConfig('from_email');
        $fromName = $this->getConfig('from_name', config('app.name'));

        config([
            'mail.from.address' => $fromEmail,
            'mail.from.name' => $fromName
        ]);

        switch ($provider) {
            case 'mailgun':
                config([
                    'mail.mailers.smtp.host' => 'smtp.mailgun.org',
                    'mail.mailers.smtp.port' => 587,
                    'mail.mailers.smtp.encryption' => 'tls',
                    'mail.mailers.smtp.username' => 'postmaster@' . $this->getConfig('mailgun_domain'),
                    'mail.mailers.smtp.password' => $this->getApiKey('mailgun_api_key'),
                ]);
                break;

            case 'sendgrid':
                config([
                    'mail.mailers.smtp.host' => 'smtp.sendgrid.net',
                    'mail.mailers.smtp.port' => 587,
                    'mail.mailers.smtp.encryption' => 'tls',
                    'mail.mailers.smtp.username' => 'apikey',
                    'mail.mailers.smtp.password' => $this->getApiKey('sendgrid_api_key'),
                ]);
                break;

            case 'brevo':
                config([
                    'mail.mailers.smtp.host' => 'smtp-relay.brevo.com',
                    'mail.mailers.smtp.port' => 587,
                    'mail.mailers.smtp.encryption' => 'tls',
                    'mail.mailers.smtp.username' => $this->getApiKey('brevo_api_key'),
                    'mail.mailers.smtp.password' => $this->getConfig('brevo_smtp_password'),
                ]);
                break;
        }
    }

    /**
     * Send appointment confirmation email
     */
    public function sendAppointmentConfirmation(array $appointmentData): bool
    {
        try {
            $emailData = [
                'patient_name' => $appointmentData['patient_name'],
                'appointment_date' => $appointmentData['appointment_date'],
                'appointment_time' => $appointmentData['appointment_time'],
                'doctor_name' => $appointmentData['doctor_name'],
                'clinic_address' => $appointmentData['clinic_address'],
                'confirmation_number' => $appointmentData['confirmation_number']
            ];

            Mail::to($appointmentData['patient_email'])->send(
                new \App\Mail\AppointmentConfirmationMail($emailData)
            );

            $this->log('appointment_email_sent', [
                'to' => $appointmentData['patient_email'],
                'confirmation_number' => $appointmentData['confirmation_number']
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Failed to send appointment confirmation email', [
                'error' => $e->getMessage(),
                'appointment_data' => $appointmentData
            ]);

            return false;
        }
    }

    /**
     * Send OTP email
     */
    public function sendOTP(string $email, string $otp): bool
    {
        try {
            Mail::to($email)->send(
                new \App\Mail\OTPMail($otp)
            );

            $this->log('otp_email_sent', ['to' => $email]);

            return true;

        } catch (\Exception $e) {
            Log::error('Failed to send OTP email', [
                'error' => $e->getMessage(),
                'email' => $email
            ]);

            return false;
        }
    }
}