<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            
            // Translatable fields
            $table->json('name');
            $table->json('specialty');
            $table->json('bio')->nullable();
            $table->json('qualifications')->nullable();
            $table->json('experience')->nullable();
            $table->json('certificates')->nullable();
            
            // Regular fields
            $table->integer('years_of_experience')->nullable();
            $table->decimal('consultation_fee', 10, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};