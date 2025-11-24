<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            
            // Patient Information
            $table->string('patient_name');
            $table->string('patient_email');
            $table->string('patient_phone');
            $table->date('patient_date_of_birth')->nullable();
            $table->enum('patient_gender', ['male', 'female'])->nullable();
            $table->text('patient_address')->nullable();
            $table->string('patient_emergency_contact')->nullable();
            $table->text('patient_allergies')->nullable();
            $table->text('patient_current_medications')->nullable();
            $table->text('patient_medical_history')->nullable();
            $table->string('patient_blood_type')->nullable(); // A+, A-, B+, B-, AB+, AB-, O+, O-
            
            // Relationships
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
            $table->foreignId('appointment_id')->nullable()->constrained('appointments')->onDelete('set null');
            
            // Chief Complaint
            $table->text('chief_complaint'); // الشكوى الرئيسية
            $table->text('symptoms'); // الأعراض
            $table->string('duration')->nullable(); // مدة الأعراض
            $table->string('onset')->nullable(); // بداية الأعراض
            $table->enum('severity', ['mild', 'moderate', 'severe'])->nullable();
            $table->string('location')->nullable(); // مكان الأعراض
            $table->string('radiation')->nullable(); // امتداد الألم
            $table->text('aggravating_factors')->nullable(); // العوامل المفاقمة
            $table->text('relieving_factors')->nullable(); // العوامل المخففة
            $table->text('associated_symptoms')->nullable(); // الأعراض المصاحبة
            
            // History
            $table->text('past_medical_history')->nullable();
            $table->text('past_surgical_history')->nullable();
            $table->text('family_history')->nullable();
            $table->text('social_history')->nullable();
            $table->text('medication_history')->nullable();
            $table->text('drug_allergies')->nullable();
            $table->text('review_of_systems')->nullable();
            
            // Physical Examination
            $table->text('physical_examination')->nullable();
            $table->json('vital_signs')->nullable(); // Vital signs as JSON
            $table->string('general_appearance')->nullable();
            $table->decimal('vitals_height', 5, 2)->nullable(); // cm
            $table->decimal('vitals_weight', 5, 2)->nullable(); // kg
            $table->string('vitals_bp')->nullable(); // Blood Pressure
            $table->integer('vitals_hr')->nullable(); // Heart Rate
            $table->decimal('vitals_temp', 4, 2)->nullable(); // Temperature
            $table->integer('vitals_resp')->nullable(); // Respiratory Rate
            $table->integer('vitals_spo2')->nullable(); // Oxygen Saturation
            
            // Investigations
            $table->json('lab_results')->nullable(); // Lab results as JSON
            $table->json('imaging_studies')->nullable(); // Imaging studies as JSON
            $table->text('other_investigations')->nullable();
            
            // Diagnosis and Treatment
            $table->text('diagnosis');
            $table->text('differential_diagnosis')->nullable();
            $table->string('diagnosis_code')->nullable(); // ICD-10 or other codes
            $table->text('treatment_plan');
            
            // Medications
            $table->json('medications')->nullable(); // Array of medication names
            $table->json('dosages')->nullable(); // Array of dosages
            $table->json('frequencies')->nullable(); // Array of frequencies
            $table->json('durations')->nullable(); // Array of durations
            $table->text('instructions')->nullable();
            $table->text('follow_up_instructions')->nullable();
            $table->date('next_appointment')->nullable();
            $table->text('referrals')->nullable();
            $table->text('patient_education')->nullable();
            
            // Additional Information
            $table->text('notes')->nullable();
            $table->json('attachments')->nullable(); // Array of file paths
            
            // Metadata
            $table->date('record_date');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            // Indexes
            $table->index(['patient_email']);
            $table->index(['doctor_id']);
            $table->index(['appointment_id']);
            $table->index(['record_date']);
            $table->index(['diagnosis']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};