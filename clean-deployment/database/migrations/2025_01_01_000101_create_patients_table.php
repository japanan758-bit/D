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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            
            // Basic Information
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('patient_number')->unique(); // Unique patient ID
            
            // Demographics
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->text('address')->nullable();
            $table->string('occupation')->nullable();
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed'])->nullable();
            
            // Emergency Contact
            $table->string('emergency_contact')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            
            // Medical Information
            $table->text('allergies')->nullable(); // Comma-separated list
            $table->text('current_medications')->nullable(); // Comma-separated list
            $table->text('medical_history')->nullable();
            $table->text('surgical_history')->nullable();
            $table->text('family_history')->nullable();
            $table->string('blood_type')->nullable(); // A+, A-, B+, B-, AB+, AB-, O+, O-
            
            // Insurance Information
            $table->string('insurance_provider')->nullable();
            $table->string('insurance_policy_number')->nullable();
            
            // Physical Information
            $table->decimal('height', 5, 2)->nullable(); // cm
            $table->decimal('weight', 5, 2)->nullable(); // kg
            
            // Media
            $table->string('photo_path')->nullable();
            
            // Status and Notes
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index(['name']);
            $table->index(['email']);
            $table->index(['phone']);
            $table->index(['patient_number']);
            $table->index(['is_active']);
            $table->index(['date_of_birth']);
            $table->index(['blood_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};