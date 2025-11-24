<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            
            // Key for singleton pattern
            $table->string('key')->unique();
            
            // Translatable fields
            $table->json('clinic_name')->nullable();
            $table->json('description')->nullable();
            $table->json('address')->nullable();
            $table->json('working_hours')->nullable();
            $table->json('about_us')->nullable();
            $table->json('mission')->nullable();
            $table->json('vision')->nullable();
            $table->json('values')->nullable();
            $table->json('meta_title')->nullable();
            $table->json('meta_description')->nullable();
            $table->json('keywords')->nullable();
            
            // Regular fields
            $table->string('phone')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->string('email')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('google_maps_url')->nullable();
            $table->decimal('consultation_fee', 10, 2)->nullable();
            $table->string('emergency_contact')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};