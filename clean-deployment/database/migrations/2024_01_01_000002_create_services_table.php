<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            
            // Translatable fields
            $table->json('name');
            $table->json('description')->nullable();
            $table->json('duration')->nullable();
            $table->json('preparation')->nullable();
            
            // Regular fields
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('consultation_fee', 10, 2)->nullable();
            $table->decimal('follow_up_fee', 10, 2)->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->string('category')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};