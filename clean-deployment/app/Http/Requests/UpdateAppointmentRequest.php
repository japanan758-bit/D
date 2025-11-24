<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_name' => 'sometimes|string|max:255',
            'patient_phone' => 'sometimes|string|max:20|regex:/^[0-9+\-\s\(\)]+$/',
            'patient_email' => 'sometimes|email|max:255',
            'service_id' => 'sometimes|exists:services,id',
            'appointment_date' => 'sometimes|date|after:today',
            'appointment_time' => 'sometimes|date_format:H:i',
            'status' => 'sometimes|in:pending,confirmed,completed,cancelled',
            'notes' => 'nullable|string|max:1000'
        ];
    }

    public function messages(): array
    {
        return [
            'patient_name.string' => 'اسم المريض يجب أن يكون نص',
            'patient_phone.regex' => 'رقم الهاتف غير صحيح',
            'patient_email.email' => 'البريد الإلكتروني غير صحيح',
            'service_id.exists' => 'الخدمة المختارة غير موجودة',
            'appointment_date.after' => 'تاريخ الموعد يجب أن يكون في المستقبل',
            'appointment_time.date_format' => 'وقت الموعد يجب أن يكون بصيغة HH:MM',
            'status.in' => 'حالة الموعد غير صحيحة'
        ];
    }
}