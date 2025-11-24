<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use App\Models\Appointment;

class AppointmentConfirmation extends Mailable
{
    public $appointment;
    public $patient;
    public $doctor;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
        $this->patient = $appointment->patient;
        $this->doctor = $appointment->doctor;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('clinic@example.com', 'عيادة الأنوار الطبية'),
            to: [$this->patient->email],
            subject: "تأكيد موعدك الطبي",
            tags: ['appointment-confirmation'],
            replyTo: 'info@clinic.com',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.appointment-confirmation',
            with: [
                'appointment' => $this->appointment,
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