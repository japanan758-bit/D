<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->boolean('enable_booking')->default(true);
            $table->boolean('enable_payment')->default(false); // Deferred as requested
            $table->boolean('enable_registration')->default(true);
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['enable_booking', 'enable_payment', 'enable_registration']);
        });
    }
};
