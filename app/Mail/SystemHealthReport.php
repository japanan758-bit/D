<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class SystemHealthReport extends Mailable
{
    public $healthData;

    public function __construct(array $healthData)
    {
        $this->healthData = $healthData;
    }

    public function envelope(): Envelope
    {
        $score = $this->healthData['overall_score'] ?? 0;
        $status = $score >= 80 ? 'ممتاز' : ($score >= 60 ? 'جيد' : 'يحتاج تحسين');

        return new Envelope(
            from: new Address('system@clinic.com', 'نظام إدارة العيادة'),
            to: ['admin@clinic.com'],
            subject: "تقرير صحة النظام - النتيجة: $score% ($status)",
            tags: ['system-health-report'],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.system-health-report',
            with: [
                'healthData' => $this->healthData,
                'clinicName' => 'عيادة الأنوار الطبية',
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}