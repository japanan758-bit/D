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
        Schema::create('page_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('category'); // home, about, services, contact, blog, booking, gallery, testimonials, faq, landing, custom
            $table->longText('content'); // HTML/Laravel Blade content
            $table->boolean('is_active')->default(true);
            $table->boolean('is_premium')->default(false);
            $table->json('settings')->nullable(); // Template settings
            $table->longText('custom_css')->nullable();
            $table->longText('custom_js')->nullable();
            $table->json('seo_settings')->nullable(); // Meta tags, title, description, etc.
            $table->json('component_data')->nullable(); // Component structure and data
            $table->timestamps();
            
            $table->index(['category', 'is_active']);
            $table->index('slug');
            $table->index('is_premium');
            $table->index('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_templates');
    }
};