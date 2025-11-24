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
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('author')->nullable();
            $table->string('version')->default('1.0.0');
            $table->boolean('is_active')->default(false);
            $table->boolean('is_default')->default(false);
            $table->longText('custom_css')->nullable();
            $table->longText('custom_js')->nullable();
            $table->json('settings')->nullable();
            $table->string('layout_type')->default('full-width'); // full-width, boxed, split
            $table->string('color_scheme')->default('blue'); // blue, green, purple, red, custom
            $table->json('typography')->nullable();
            $table->boolean('animations_enabled')->default(true);
            $table->json('responsive_breakpoints')->nullable();
            $table->timestamps();
            
            $table->index(['is_active', 'is_default']);
            $table->index('slug');
            $table->index('color_scheme');
            $table->index('layout_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('themes');
    }
};