<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'date_of_birth',
        'gender',
        'address',
        'emergency_contact',
        'emergency_contact_phone',
        'allergies',
        'current_medications',
        'medical_history',
        'surgical_history',
        'family_history',
        'blood_type',
        'insurance_provider',
        'insurance_policy_number',
        'occupation',
        'marital_status',
        'height',
        'weight',
        'photo_path',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'height' => 'decimal:2',
        'weight' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get the appointments for this patient.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'patient_email', 'email')
                    ->orWhere('patient_name', $this->name);
    }

    /**
     * Get the medical records for this patient.
     */
    public function medicalRecords(): HasMany
    {
        return $this->hasMany(MedicalRecord::class, 'patient_email', 'email')
                    ->orWhere('patient_name', $this->name);
    }

    /**
     * Get user's age.
     */
    public function getAgeAttribute(): ?int
    {
        return $this->date_of_birth ? $this->date_of_birth->age : null;
    }

    /**
     * Calculate BMI.
     */
    public function getBmiAttribute(): ?float
    {
        if ($this->height && $this->weight) {
            $heightInMeters = $this->height / 100; // Convert cm to meters
            return round($this->weight / ($heightInMeters * $heightInMeters), 1);
        }
        return null;
    }

    /**
     * Get BMI category.
     */
    public function getBmiCategoryAttribute(): ?string
    {
        $bmi = $this->bmi;
        
        if (!$bmi) return null;
        
        if ($bmi < 18.5) return 'نحيف';
        if ($bmi < 25) return 'طبيعي';
        if ($bmi < 30) return 'وزن زائد';
        return 'سمنة';
    }

    /**
     * Get the full address.
     */
    public function getFullAddressAttribute(): string
    {
        return $this->address ?? '';
    }

    /**
     * Get the photo URL.
     */
    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo_path ? asset('storage/' . $this->photo_path) : null;
    }

    /**
     * Get emergency contact details.
     */
    public function getEmergencyContactDetailsAttribute(): array
    {
        return [
            'name' => $this->emergency_contact,
            'phone' => $this->emergency_contact_phone,
        ];
    }

    /**
     * Get upcoming appointments.
     */
    public function getUpcomingAppointmentsAttribute()
    {
        return $this->appointments()
            ->where('appointment_date', '>=', now())
            ->whereIn('status', ['confirmed', 'pending'])
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();
    }

    /**
     * Get recent medical records.
     */
    public function getRecentMedicalRecordsAttribute()
    {
        return $this->medicalRecords()
            ->orderBy('record_date', 'desc')
            ->limit(5)
            ->get();
    }

    /**
     * Get last appointment.
     */
    public function getLastAppointmentAttribute(): ?Appointment
    {
        return $this->appointments()
            ->orderBy('appointment_date', 'desc')
            ->first();
    }

    /**
     * Get last medical record.
     */
    public function getLastMedicalRecordAttribute(): ?MedicalRecord
    {
        return $this->medicalRecords()
            ->orderBy('record_date', 'desc')
            ->first();
    }

    /**
     * Scope to filter active patients.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to search patients.
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'LIKE', "%{$term}%")
              ->orWhere('email', 'LIKE', "%{$term}%")
              ->orWhere('phone', 'LIKE', "%{$term}%");
        });
    }

    /**
     * Scope to filter by gender.
     */
    public function scopeByGender($query, $gender)
    {
        return $query->where('gender', $gender);
    }

    /**
     * Scope to filter by age range.
     */
    public function scopeAgeRange($query, $minAge, $maxAge)
    {
        return $query->whereBetween('date_of_birth', [
            now()->subYears($maxAge)->toDateString(),
            now()->subYears($minAge)->toDateString()
        ]);
    }

    /**
     * Get patients by blood type.
     */
    public function scopeByBloodType($query, $bloodType)
    {
        return $query->where('blood_type', $bloodType);
    }

    /**
     * Get patients with upcoming appointments.
     */
    public function scopeWithUpcomingAppointments($query)
    {
        return $query->whereHas('appointments', function ($q) {
            $q->where('appointment_date', '>=', now())
              ->whereIn('status', ['confirmed', 'pending']);
        });
    }

    /**
     * Get patient statistics.
     */
    public function getStatisticsAttribute(): array
    {
        return [
            'total_appointments' => $this->appointments->count(),
            'completed_appointments' => $this->appointments->where('status', 'completed')->count(),
            'upcoming_appointments' => $this->appointments->where('appointment_date', '>=', now())->count(),
            'total_medical_records' => $this->medicalRecords->count(),
            'last_visit' => $this->last_appointment?->appointment_date,
        ];
    }

    /**
     * Generate patient ID number.
     */
    public static function generatePatientNumber(): string
    {
        $prefix = 'PT';
        $year = date('Y');
        $latest = static::whereYear('created_at', $year)->orderBy('id', 'desc')->first();
        
        if ($latest) {
            $number = (int) substr($latest->patient_number ?? 0, -6) + 1;
        } else {
            $number = 1;
        }
        
        return $prefix . $year . str_pad($number, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($patient) {
            if (empty($patient->patient_number)) {
                $patient->patient_number = static::generatePatientNumber();
            }
        });
    }

    /**
     * Get all patients for dropdown.
     */
    public static function forDropdown(): \Illuminate\Database\Eloquent\Collection
    {
        return static::active()->orderBy('name')->get();
    }

    /**
     * Get patient by email or phone.
     */
    public static function findByContact($email, $phone = null): ?self
    {
        $query = static::where('email', $email);
        
        if ($phone) {
            $query->orWhere('phone', $phone);
        }
        
        return $query->first();
    }

    /**
     * Create or find patient by email.
     */
    public static function findOrCreateByEmail($email, $name = null, $phone = null): self
    {
        $patient = static::where('email', $email)->first();
        
        if (!$patient) {
            $patient = static::create([
                'email' => $email,
                'name' => $name,
                'phone' => $phone,
                'is_active' => true,
            ]);
        }
        
        return $patient;
    }

    /**
     * Get patient's allergies array.
     */
    public function getAllergiesArrayAttribute(): array
    {
        if ($this->allergies) {
            return array_map('trim', explode(',', $this->allergies));
        }
        return [];
    }

    /**
     * Get patient's current medications array.
     */
    public function getCurrentMedicationsArrayAttribute(): array
    {
        if ($this->current_medications) {
            return array_map('trim', explode(',', $this->current_medications));
        }
        return [];
    }

    /**
     * Check if patient has allergies.
     */
    public function hasAllergies(): bool
    {
        return !empty($this->allergies_array);
    }

    /**
     * Check if patient has current medications.
     */
    public function hasCurrentMedications(): bool
    {
        return !empty($this->current_medications_array);
    }

    /**
     * Get risk factors.
     */
    public function getRiskFactorsAttribute(): array
    {
        $riskFactors = [];
        
        if ($this->hasAllergies()) {
            $riskFactors[] = 'حساسيات';
        }
        
        if ($this->hasCurrentMedications()) {
            $riskFactors[] = 'أدوية حالية';
        }
        
        if ($this->medical_history) {
            $riskFactors[] = 'تاريخ طبي';
        }
        
        if ($this->family_history) {
            $riskFactors[] = 'تاريخ عائلي';
        }
        
        return $riskFactors;
    }

    /**
     * Get formatted appointment history.
     */
    public function getAppointmentHistoryAttribute(): array
    {
        return $this->appointments->map(function ($appointment) {
            return [
                'date' => $appointment->appointment_date,
                'time' => $appointment->appointment_time,
                'service' => $appointment->service->name ?? 'غير محدد',
                'doctor' => $appointment->doctor->name ?? 'غير محدد',
                'status' => $appointment->status,
                'status_ar' => match($appointment->status) {
                    'pending' => 'قيد الانتظار',
                    'confirmed' => 'مؤكد',
                    'completed' => 'مكتمل',
                    'cancelled' => 'ملغي',
                    default => $appointment->status
                }
            ];
        })->toArray();
    }
}