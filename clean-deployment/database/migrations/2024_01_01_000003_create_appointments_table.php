<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            
            // Patient Information
            $table->string('patient_name');
            $table->string('patient_phone');
            $table->string('patient_email')->nullable();
            
            // Appointment Details
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->text('notes')->nullable();
            
            // Status
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->boolean('is_confirmed')->default(false);
            $table->boolean('whatsapp_sent')->default(false);
            $table->string('confirmation_code', 6)->unique();
            
            // Additional fields
            $table->foreignId('doctor_id')->nullable()->constrained()->onDelete('set null');
            $table->string('cancel_reason')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('rescheduled_at')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};