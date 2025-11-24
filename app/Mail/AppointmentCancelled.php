<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Lang;

class AppointmentCancelled extends Mailable
{
    public function __construct(public Appointment $appointment)
    {
        $this->subject(Lang::get('إلغاء موعد العيادة - دكتور عبدالناصر الأخرص'));
    }

    public function build()
    {
        return $this->view('emails.appointment-cancelled')
                    ->with([
                        'appointment' => $this->appointment,
                        'doctor' => 'دكتور عبدالناصر الأخرص'
                    ]);
    }
}