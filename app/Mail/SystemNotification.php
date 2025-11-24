<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class SystemNotification extends Mailable
{
    public $data;
    public $notificationType;

    public function __construct(array $data, string $notificationType = 'general')
    {
        $this->data = $data;
        $this->notificationType = $notificationType;
    }

    public function envelope(): Envelope
    {
        $subject = match($this->notificationType) {
            'daily_schedule' => 'جدول المواعيد اليومي',
            'system_alert' => 'تنبيه من النظام',
            'backup_report' => 'تقرير النسخ الاحتياطي',
            'health_check' => 'تقرير صحة النظام',
            default => 'إشعار من النظام'
        };

        return new Envelope(
            from: new Address('system@clinic.com', 'نظام إدارة العيادة'),
            to: [$this->data['recipient'] ?? 'admin@clinic.com'],
            subject: $subject,
            tags: ['system-notification', $this->notificationType],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.system-notification',
            with: [
                'data' => $this->data,
                'notificationType' => $this->notificationType,
                'clinicName' => 'عيادة الأنوار الطبية',
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}