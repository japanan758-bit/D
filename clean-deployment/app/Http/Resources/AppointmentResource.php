<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'patient_name' => $this->patient_name,
            'patient_phone' => $this->patient_phone,
            'patient_email' => $this->patient_email,
            'appointment_date' => $this->appointment_date->format('Y-m-d'),
            'appointment_time' => $this->appointment_time->format('H:i'),
            'notes' => $this->notes,
            'status' => $this->status,
            'is_confirmed' => $this->is_confirmed,
            'confirmation_code' => $this->confirmation_code,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            
            // Relationships
            'service' => [
                'id' => $this->service->id ?? null,
                'name' => $this->service->name ?? null,
                'price' => $this->service->price ?? null,
            ],
            'doctor' => [
                'id' => $this->doctor->id ?? null,
                'name' => $this->doctor->name ?? null,
                'specialty' => $this->doctor->specialty ?? null,
            ],
        ];
    }
}