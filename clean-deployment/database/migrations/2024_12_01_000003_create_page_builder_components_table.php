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
        Schema::create('page_builder_components', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // layout, content, media, form, navigation, interactive, widget
            $table->string('category'); // header, hero, features, services, about, team, testimonials, pricing, gallery, blog, contact, footer, forms, cta, stats, timeline, faq, maps, social
            $table->json('settings')->nullable(); // Available settings for this component
            $table->longText('html_template'); // HTML template with placeholders
            $table->longText('css_styles')->nullable(); // Custom CSS for the component
            $table->longText('js_functionality')->nullable(); // JavaScript functionality
            $table->boolean('is_reusable')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['type', 'is_active']);
            $table->index(['category', 'is_active']);
            $table->index('is_reusable');
            $table->index('type');
            $table->index('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_builder_components');
    }
};