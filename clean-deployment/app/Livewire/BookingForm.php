<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Service;
use App\Models\Appointment;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BookingForm extends Component
{
    public $step = 1;
    public $patientName = '';
    public $patientPhone = '';
    public $patientEmail = '';
    public $serviceId = '';
    public $appointmentDate = '';
    public $appointmentTime = '';
    public $notes = '';
    public $termsAccepted = false;

    public $services = [];
    public $isSubmitting = false;
    public $success = false;
    public $confirmationCode = '';

    protected $rules = [
        'patientName' => 'required|string|min:3|max:255',
        'patientPhone' => 'required|regex:/^05[0-9]{8}$/',
        'patientEmail' => 'nullable|email|max:255',
        'serviceId' => 'required|exists:services,id',
        'appointmentDate' => 'required|date|after:today',
        'appointmentTime' => 'required|date_format:H:i',
        'notes' => 'nullable|string|max:500',
        'termsAccepted' => 'required|accepted'
    ];

    protected $messages = [
        'patientName.required' => 'اسم المريض مطلوب',
        'patientName.min' => 'اسم المريض يجب أن يكون 3 أحرف على الأقل',
        'patientPhone.required' => 'رقم الهاتف مطلوب',
        'patientPhone.regex' => 'رقم الهاتف غير صحيح (مثال: 0501234567)',
        'patientEmail.email' => 'البريد الإلكتروني غير صحيح',
        'serviceId.required' => 'يرجى اختيار الخدمة',
        'serviceId.exists' => 'الخدمة المختارة غير موجودة',
        'appointmentDate.required' => 'تاريخ الموعد مطلوب',
        'appointmentDate.after' => 'تاريخ الموعد يجب أن يكون في المستقبل',
        'appointmentTime.required' => 'وقت الموعد مطلوب',
        'appointmentTime.date_format' => 'وقت الموعد غير صحيح',
        'notes.max' => 'الملاحظات يجب ألا تتجاوز 500 حرف',
        'termsAccepted.accepted' => 'يجب الموافقة على الشروط والأحكام'
    ];

    public function mount()
    {
        $this->services = Service::select('id', 'name', 'consultation_fee', 'duration')
            ->where('is_active', true)
            ->get();
    }

    public function nextStep()
    {
        // Validate current step before proceeding
        if ($this->step === 1) {
            $this->validate([
                'patientName' => 'required|string|min:3|max:255',
                'patientPhone' => 'required|regex:/^05[0-9]{8}$/',
                'patientEmail' => 'nullable|email|max:255',
            ]);
        } elseif ($this->step === 2) {
            $this->validate([
                'serviceId' => 'required|exists:services,id',
            ]);
        } elseif ($this->step === 3) {
            $this->validate([
                'appointmentDate' => 'required|date|after:today',
                'appointmentTime' => 'required|date_format:H:i',
            ]);
        }

        if ($this->step < 4) {
            $this->step++;
        }
    }

    public function previousStep()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function updatedPatientPhone($value)
    {
        // Clean phone number
        $this->patientPhone = preg_replace('/[^0-9]/', '', $value);
        
        // Format Saudi phone number
        if (strlen($this->patientPhone) === 10 && starts_with($this->patientPhone, '5')) {
            $this->patientPhone = '0' . $this->patientPhone;
        } elseif (strlen($this->patientPhone) === 9 && starts_with($this->patientPhone, '5')) {
            $this->patientPhone = '05' . $this->patientPhone;
        }
    }

    public function generateTimeSlots()
    {
        $timeSlots = [];
        $currentHour = 9; // Start from 9 AM
        $endHour = 18; // End at 6 PM
        
        while ($currentHour < $endHour) {
            $hour = str_pad($currentHour, 2, '0', STR_PAD_LEFT);
            $timeSlots[] = $hour . ':00';
            $timeSlots[] = $hour . ':30';
            $currentHour++;
        }
        
        return $timeSlots;
    }

    public function submit()
    {
        $this->validate();

        $this->isSubmitting = true;

        try {
            // Check if selected time slot is available
            $existingAppointment = Appointment::where('appointment_date', $this->appointmentDate)
                ->where('appointment_time', $this->appointmentTime . ':00')
                ->where('status', '!=', 'cancelled')
                ->first();

            if ($existingAppointment) {
                $this->addError('appointmentTime', 'هذا الموعد محجوز مسبقاً. يرجى اختيار وقت آخر');
                $this->isSubmitting = false;
                return;
            }

            // Generate confirmation code
            $this->confirmationCode = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

            // Create appointment
            $appointment = Appointment::create([
                'patient_name' => $this->patientName,
                'patient_phone' => $this->patientPhone,
                'patient_email' => $this->patientEmail,
                'service_id' => $this->serviceId,
                'appointment_date' => $this->appointmentDate,
                'appointment_time' => $this->appointmentTime . ':00',
                'notes' => $this->notes,
                'status' => 'pending',
                'confirmation_code' => $this->confirmationCode
            ]);

            // Get service details
            $service = Service::find($this->serviceId);

            // Prepare WhatsApp message
            $whatsappMessage = $this->prepareWhatsAppMessage($appointment, $service);

            // Redirect to WhatsApp
            $this->redirectToWhatsApp($whatsappMessage);

        } catch (\Exception $e) {
            session()->flash('error', 'حدث خطأ أثناء حفظ الموعد. يرجى المحاولة مرة أخرى.');
            $this->isSubmitting = false;
        }
    }

    private function prepareWhatsAppMessage($appointment, $service)
    {
        $settings = \App\Models\Setting::getSettings();
        
        $message = "🏥 *حجز موعد جديد - عيادة د. عبدالناصر الأخرس*\n\n";
        $message .= "👤 *اسم المريض:* {$appointment->patient_name}\n";
        $message .= "📞 *رقم الهاتف:* {$appointment->patient_phone}\n";
        
        if ($appointment->patient_email) {
            $message .= "📧 *البريد الإلكتروني:* {$appointment->patient_email}\n";
        }
        
        $message .= "🏥 *الخدمة:* " . $service->getTranslation('name', 'ar') . "\n";
        $message .= "📅 *التاريخ:* " . \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') . "\n";
        $message .= "🕒 *الوقت:* " . \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') . "\n";
        $message .= "💰 *رسوم الاستشارة:* {$service->consultation_fee} ريال\n";
        
        if ($appointment->notes) {
            $message .= "📝 *ملاحظات:* {$appointment->notes}\n";
        }
        
        $message .= "\n🔢 *رمز التأكيد:* {$appointment->confirmation_code}\n";
        $message .= "\n⏰ *تاريخ الحجز:* " . now()->format('d/m/Y h:i A') . "\n\n";
        $message .= "يرجى التواصل مع المريض لتأكيد الموعد. شكراً لك.";

        return $message;
    }

    private function redirectToWhatsApp($message)
    {
        $whatsappNumber = '966112345678'; // Clinic WhatsApp number without +
        $encodedMessage = urlencode($message);
        $whatsappUrl = "https://wa.me/{$whatsappNumber}?text={$encodedMessage}";

        // Show success message and redirect
        $this->success = true;
        session()->flash('success', 'تم حفظ الموعد بنجاح! سيتم توجيهك إلى واتساب للتواصل مع العيادة.');
        
        // Add JavaScript to redirect to WhatsApp
        echo "<script>
            setTimeout(function() {
                window.open('{$whatsappUrl}', '_blank');
            }, 2000);
        </script>";

        // Reset form after 3 seconds
        $this->dispatch('reset-form', delay: 3000);
    }

    public function render()
    {
        $timeSlots = $this->generateTimeSlots();
        
        return view('livewire.booking-form', [
            'timeSlots' => $timeSlots
        ]);
    }
}