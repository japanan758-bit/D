<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_name' => 'required|string|max:255',
            'patient_phone' => 'required|string|max:20|regex:/^[0-9+\-\s\(\)]+$/',
            'patient_email' => 'required|email|max:255',
            'service_id' => 'required|exists:services,id',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required|date_format:H:i',
            'notes' => 'nullable|string|max:1000'
        ];
    }

    public function messages(): array
    {
        return [
            'patient_name.required' => 'اسم المريض مطلوب',
            'patient_phone.required' => 'رقم الهاتف مطلوب',
            'patient_phone.regex' => 'رقم الهاتف غير صحيح',
            'patient_email.required' => 'البريد الإلكتروني مطلوب',
            'patient_email.email' => 'البريد الإلكتروني غير صحيح',
            'service_id.required' => 'يجب اختيار الخدمة',
            'service_id.exists' => 'الخدمة المختارة غير موجودة',
            'appointment_date.required' => 'تاريخ الموعد مطلوب',
            'appointment_date.after' => 'تاريخ الموعد يجب أن يكون في المستقبل',
            'appointment_time.required' => 'وقت الموعد مطلوب',
            'appointment_time.date_format' => 'وقت الموعد يجب أن يكون بصيغة HH:MM'
        ];
    }
}