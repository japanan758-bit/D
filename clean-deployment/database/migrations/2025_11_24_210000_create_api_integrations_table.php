<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('api_integrations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // unique identifier for each integration
            $table->string('display_name'); // human readable name
            $table->string('category'); // analytics, security, communication, etc.
            $table->json('configuration'); // stores all configuration keys and values
            $table->json('api_keys'); // encrypted API keys
            $table->boolean('is_active')->default(false);
            $table->boolean('is_testing')->default(true);
            $table->text('description')->nullable();
            $table->json('settings')->nullable(); // additional settings
            $table->timestamps();
        });

        // Create a table for tracking integration usage and logs
        Schema::create('integration_logs', function (Blueprint $table) {
            $table->id();
            $table->string('integration_name');
            $table->string('action'); // activated, deactivated, updated, used
            $table->json('data')->nullable(); // additional data for the action
            $table->string('user_id')->nullable(); // who performed the action
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });

        // Create a table for storing integration statistics
        Schema::create('integration_stats', function (Blueprint $table) {
            $table->id();
            $table->string('integration_name');
            $table->date('date');
            $table->json('metrics'); // usage counts, response times, etc.
            $table->timestamps();
            $table->unique(['integration_name', 'date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('integration_stats');
        Schema::dropIfExists('integration_logs');
        Schema::dropIfExists('api_integrations');
    }
};