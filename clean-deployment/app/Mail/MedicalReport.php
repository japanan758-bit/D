<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use App\Models\MedicalRecord;

class MedicalReport extends Mailable
{
    public $record;
    public $patient;
    public $doctor;

    public function __construct(MedicalRecord $record)
    {
        $this->record = $record;
        $this->patient = $record->patient;
        $this->doctor = $record->doctor;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('clinic@example.com', 'عيادة الأنوار الطبية'),
            to: [$this->patient->email],
            subject: "تقريرك الطبي",
            tags: ['medical-report'],
            replyTo: 'info@clinic.com',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.medical-report',
            with: [
                'record' => $this->record,
                'patient' => $this->patient,
                'doctor' => $this->doctor,
                'clinicName' => 'عيادة الأنوار الطبية',
                'clinicPhone' => '+966123456789',
                'clinicAddress' => 'الرياض، المملكة العربية السعودية'
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}