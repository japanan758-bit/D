<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_name',
        'patient_email',
        'patient_phone',
        'patient_date_of_birth',
        'patient_gender',
        'patient_address',
        'patient_emergency_contact',
        'patient_allergies',
        'patient_current_medications',
        'patient_medical_history',
        'patient_blood_type',
        'doctor_id',
        'appointment_id',
        'chief_complaint',
        'symptoms',
        'duration',
        'onset',
        'severity',
        'location',
        'radiation',
        'aggravating_factors',
        'relieving_factors',
        'associated_symptoms',
        'past_medical_history',
        'past_surgical_history',
        'family_history',
        'social_history',
        'medication_history',
        'drug_allergies',
        'review_of_systems',
        'physical_examination',
        'vital_signs',
        'general_appearance',
        'vitals_height',
        'vitals_weight',
        'vitals_bp',
        'vitals_hr',
        'vitals_temp',
        'vitals_resp',
        'vitals_spo2',
        'lab_results',
        'imaging_studies',
        'other_investigations',
        'diagnosis',
        'differential_diagnosis',
        'diagnosis_code',
        'treatment_plan',
        'medications',
        'dosages',
        'frequencies',
        'durations',
        'instructions',
        'follow_up_instructions',
        'next_appointment',
        'referrals',
        'patient_education',
        'notes',
        'attachments',
        'record_date',
        'created_by',
    ];

    protected $casts = [
        'patient_date_of_birth' => 'date',
        'next_appointment' => 'date',
        'record_date' => 'date',
        'vitals_height' => 'decimal:2',
        'vitals_weight' => 'decimal:2',
        'vitals_temp' => 'decimal:2',
        'vital_signs' => 'array',
        'attachments' => 'array',
        'lab_results' => 'array',
        'imaging_studies' => 'array',
        'medications' => 'array',
        'dosages' => 'array',
        'frequencies' => 'array',
        'durations' => 'array',
    ];

    /**
     * Get the doctor that created this record.
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * Get the appointment this record is for.
     */
    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    /**
     * Get the patient (if exists in separate table).
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the user who created this record.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get vital signs as array.
     */
    public function getVitalSignsArrayAttribute(): array
    {
        return is_string($this->vital_signs) ? json_decode($this->vital_signs, true) : ($this->vital_signs ?? []);
    }

    /**
     * Get lab results as array.
     */
    public function getLabResultsArrayAttribute(): array
    {
        return is_string($this->lab_results) ? json_decode($this->lab_results, true) : ($this->lab_results ?? []);
    }

    /**
     * Get imaging studies as array.
     */
    public function getImagingStudiesArrayAttribute(): array
    {
        return is_string($this->imaging_studies) ? json_decode($this->imaging_studies, true) : ($this->imaging_studies ?? []);
    }

    /**
     * Get medications as array.
     */
    public function getMedicationsArrayAttribute(): array
    {
        return is_string($this->medications) ? json_decode($this->medications, true) : ($this->medications ?? []);
    }

    /**
     * Get dosages as array.
     */
    public function getDosagesArrayAttribute(): array
    {
        return is_string($this->dosages) ? json_decode($this->dosages, true) : ($this->dosages ?? []);
    }

    /**
     * Get frequencies as array.
     */
    public function getFrequenciesArrayAttribute(): array
    {
        return is_string($this->frequencies) ? json_decode($this->frequencies, true) : ($this->frequencies ?? []);
    }

    /**
     * Get durations as array.
     */
    public function getDurationsArrayAttribute(): array
    {
        return is_string($this->durations) ? json_decode($this->durations, true) : ($this->durations ?? []);
    }

    /**
     * Get attachments as array.
     */
    public function getAttachmentsArrayAttribute(): array
    {
        return is_string($this->attachments) ? json_decode($this->attachments, true) : ($this->attachments ?? []);
    }

    /**
     * Calculate BMI if height and weight are available.
     */
    public function getBmiAttribute(): ?float
    {
        if ($this->vitals_height && $this->vitals_weight) {
            $heightInMeters = $this->vitals_height / 100; // Convert cm to meters
            return round($this->vitals_weight / ($heightInMeters * $heightInMeters), 1);
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
     * Get patient age.
     */
    public function getPatientAgeAttribute(): ?int
    {
        if ($this->patient_date_of_birth) {
            return $this->patient_date_of_birth->age;
        }
        return null;
    }

    /**
     * Scope to filter by date range.
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('record_date', [$startDate, $endDate]);
    }

    /**
     * Scope to filter by doctor.
     */
    public function scopeByDoctor($query, $doctorId)
    {
        return $query->where('doctor_id', $doctorId);
    }

    /**
     * Scope to filter by patient.
     */
    public function scopeByPatient($query, $patientEmail)
    {
        return $query->where('patient_email', $patientEmail);
    }

    /**
     * Get formatted vital signs for display.
     */
    public function getFormattedVitalSignsAttribute(): array
    {
        $vitals = $this->vital_signs_array;
        $formatted = [];
        
        if ($this->vitals_height) $formatted['الطول'] = $this->vitals_height . ' سم';
        if ($this->vitals_weight) $formatted['الوزن'] = $this->vitals_weight . ' كجم';
        if ($this->vitals_bp) $formatted['ضغط الدم'] = $this->vitals_bp;
        if ($this->vitals_hr) $formatted['نبضات القلب'] = $this->vitals_hr . ' نبضة/دقيقة';
        if ($this->vitals_temp) $formatted['درجة الحرارة'] = $this->vitals_temp . '°م';
        if ($this->vitals_resp) $formatted['عدد التنفس'] = $this->vitals_resp . ' تنفس/دقيقة';
        if ($this->vitals_spo2) $formatted['تشبع الأكسجين'] = $this->vitals_spo2 . '%';
        
        return $formatted;
    }

    /**
     * Get medications with full details.
     */
    public function getFullMedicationsAttribute(): array
    {
        $medications = $this->medications_array;
        $dosages = $this->dosages_array;
        $frequencies = $this->frequencies_array;
        $durations = $this->durations_array;
        
        $fullMedications = [];
        
        foreach ($medications as $index => $medication) {
            if (trim($medication)) {
                $fullMedications[] = [
                    'name' => $medication,
                    'dosage' => $dosages[$index] ?? '',
                    'frequency' => $frequencies[$index] ?? '',
                    'duration' => $durations[$index] ?? '',
                    'full' => trim($medication) . 
                             ($dosages[$index] ? ' - ' . $dosages[$index] : '') .
                             ($frequencies[$index] ? ' - ' . $frequencies[$index] : '') .
                             ($durations[$index] ? ' - ' . $durations[$index] : '')
                ];
            }
        }
        
        return $fullMedications;
    }

    /**
     * Generate record summary.
     */
    public function getSummaryAttribute(): string
    {
        $summary = "شكوى رئيسية: " . $this->chief_complaint . "\n";
        $summary .= "التشخيص: " . $this->diagnosis . "\n";
        $summary .= "خطة العلاج: " . $this->treatment_plan;
        
        return $summary;
    }

    /**
     * Check if record has attachments.
     */
    public function hasAttachments(): bool
    {
        return !empty($this->attachments_array);
    }

    /**
     * Get latest record for a patient.
     */
    public static function getLatestForPatient($patientEmail): ?self
    {
        return static::where('patient_email', $patientEmail)
            ->orderBy('record_date', 'desc')
            ->first();
    }

    /**
     * Get records by diagnosis.
     */
    public static function getByDiagnosis($diagnosis): \Illuminate\Database\Eloquent\Collection
    {
        return static::where('diagnosis', 'LIKE', "%{$diagnosis}%")
            ->with(['doctor', 'appointment'])
            ->orderBy('record_date', 'desc')
            ->get();
    }

    /**
     * Scope to search records.
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('patient_name', 'LIKE', "%{$term}%")
              ->orWhere('chief_complaint', 'LIKE', "%{$term}%")
              ->orWhere('diagnosis', 'LIKE', "%{$term}%")
              ->orWhere('treatment_plan', 'LIKE', "%{$term}%");
        });
    }

    /**
     * Get the attachment URLs.
     */
    public function getAttachmentUrlsAttribute(): array
    {
        $urls = [];
        foreach ($this->attachments_array as $attachment) {
            $urls[] = asset('storage/' . $attachment);
        }
        return $urls;
    }

    /**
     * Delete all attachments.
     */
    public function deleteAttachments(): void
    {
        foreach ($this->attachments_array as $attachment) {
            \Storage::disk('public')->delete($attachment);
        }
        $this->update(['attachments' => '[]']);
    }
}