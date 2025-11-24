<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            
            // Translatable fields
            $table->json('title');
            $table->json('content');
            $table->json('excerpt')->nullable();
            $table->json('meta_description')->nullable();
            
            // Regular fields
            $table->string('featured_image')->nullable();
            $table->boolean('is_published')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->string('author')->default('Dr. Abdelnasser Al-Akhras');
            $table->timestamp('published_at')->nullable();
            $table->integer('reading_time')->nullable();
            $table->string('category')->nullable();
            $table->json('tags')->nullable();
            $table->string('slug')->unique();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};