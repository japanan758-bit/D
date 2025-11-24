<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            
            // Translatable fields
            $table->json('patient_name');
            $table->json('patient_location')->nullable();
            $table->json('content');
            $table->json('treatment_details')->nullable();
            
            // Regular fields
            $table->integer('rating')->default(5);
            $table->string('service_name')->nullable();
            $table->date('treatment_date')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_approved')->default(false);
            $table->integer('order')->default(0);
            $table->string('age_group')->nullable();
            $table->string('gender')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};