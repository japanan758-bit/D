<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use Carbon\Carbon;

class FollowUpReminder extends Mailable
{
    public $record;
    public $patient;
    public $doctor;

    public function __construct($record)
    {
        if ($record instanceof MedicalRecord) {
            $this->record = $record;
            $this->patient = $record->patient;
            $this->doctor = $record->doctor;
        } else {
            $this->record = $record;
            $this->patient = $record->patient;
            $this->doctor = $record->doctor;
        }
    }

    public function envelope(): Envelope
    {
        $followUpDate = Carbon::parse($this->record->follow_up_date)->format('Y-m-d');
        
        return new Envelope(
            from: new Address('clinic@example.com', 'عيادة الأنوار الطبية'),
            to: [$this->patient->email],
            subject: "موعد المتابعة الطبية - $followUpDate",
            tags: ['follow-up'],
            replyTo: 'info@clinic.com',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.follow-up-reminder',
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