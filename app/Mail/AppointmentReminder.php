<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use Carbon\Carbon;

class AppointmentReminder extends Mailable
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
        $appointmentDate = Carbon::parse($this->appointment->appointment_date)->format('Y-m-d');
        $appointmentTime = Carbon::parse($this->appointment->appointment_time)->format('H:i');
        
        return new Envelope(
            from: new Address('clinic@example.com', 'عيادة الأنوار الطبية'),
            to: [$this->patient->email],
            subject: "تذكير بموعدك الطبي غداً في العيادة",
            tags: ['appointment-reminder'],
            replyTo: 'info@clinic.com',
        );
    }

    public function content(): Content
    {
        $appointmentDate = Carbon::parse($this->appointment->appointment_date)->format('Y-m-d');
        $appointmentTime = Carbon::parse($this->appointment->appointment_time)->format('H:i');
        
        return new Content(
            view: 'emails.appointment-reminder',
            with: [
                'appointment' => $this->appointment,
                'patient' => $this->patient,
                'doctor' => $this->doctor,
                'appointmentDate' => $appointmentDate,
                'appointmentTime' => $appointmentTime,
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