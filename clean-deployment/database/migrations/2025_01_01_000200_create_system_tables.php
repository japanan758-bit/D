<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // جدول الإشعارات
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type')->index(); // appointment_reminder, follow_up, system_alert, etc.
            $table->string('title');
            $table->text('message');
            $table->json('data')->nullable(); // بيانات إضافية
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            $table->index(['user_id', 'type']);
            $table->index('created_at');
        });

        // جدول نسخ احتياطية
        Schema::create('backup_logs', function (Blueprint $table) {
            $table->id();
            $table->string('filename')->unique();
            $table->json('backup_info');
            $table->string('status')->default('completed'); // completed, failed, in_progress
            $table->text('error_message')->nullable();
            $table->timestamps();
            $table->index('created_at');
        });

        // جدول تقارير النظام
        Schema::create('system_reports', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->json('data'); // إحصائيات متنوعة
            $table->string('type')->default('daily'); // daily, weekly, monthly
            $table->timestamps();
            $table->unique('date', 'type');
        });

        // جدول صحة النظام
        Schema::create('system_health_reports', function (Blueprint $table) {
            $table->id();
            $table->json('health_data');
            $table->integer('score'); // 0-100
            $table->timestamps();
            $table->index('created_at');
        });

        // جدول إحصائيات المرضى
        Schema::create('patient_statistics', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('active_patients')->default(0);
            $table->integer('inactive_patients')->default(0);
            $table->integer('total_patients')->default(0);
            $table->integer('new_patients_today')->default(0);
            $table->decimal('average_age', 5, 2)->nullable();
            $table->json('gender_distribution')->nullable();
            $table->timestamps();
            $table->unique('date');
        });

        // جدول إحصائيات الأطباء
        Schema::create('doctor_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->integer('total_appointments')->default(0);
            $table->integer('today_appointments')->default(0);
            $table->integer('completed_appointments')->default(0);
            $table->integer('pending_appointments')->default(0);
            $table->integer('cancelled_appointments')->default(0);
            $table->decimal('rating_average', 3, 2)->default(0);
            $table->integer('total_reviews')->default(0);
            $table->json('specialization_data')->nullable();
            $table->timestamps();
            $table->unique(['doctor_id', 'date']);
        });

        // جدول إعدادات النظام
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value');
            $table->string('type')->default('string'); // string, integer, boolean, json
            $table->string('group')->default('general'); // email, notification, backup, etc.
            $table->text('description')->nullable();
            $table->boolean('is_encrypted')->default(false);
            $table->timestamps();
            $table->index(['group', 'key']);
        });

        // جدول الجلسات
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // جدول سجل العمليات
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('action'); // login, logout, create_appointment, etc.
            $table->string('model_type')->nullable(); // App\Models\Appointment
            $table->unsignedBigInteger('model_id')->nullable();
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
            $table->index(['model_type', 'model_id']);
            $table->index('user_id');
            $table->index('action');
        });

        // جدول إعدادات البريد الإلكتروني
        Schema::create('email_settings', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // appointment_reminder, follow_up, etc.
            $table->boolean('enabled')->default(true);
            $table->boolean('send_email')->default(true);
            $table->boolean('send_sms')->default(false);
            $table->integer('send_hours_before')->default(24); // كم ساعة قبل الموعد
            $table->json('custom_template')->nullable();
            $table->timestamps();
            $table->index('type');
        });

        // جدول إعدادات النسخ الاحتياطية
        Schema::create('backup_settings', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // auto, manual
            $table->string('frequency'); // daily, weekly, monthly
            $table->boolean('compress')->default(true);
            $table->integer('retention_days')->default(30);
            $table->string('storage_location')->default('local'); // local, s3, google_drive
            $table->json('storage_config')->nullable(); // إعدادات التخزين السحابي
            $table->boolean('enabled')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('backup_settings');
        Schema::dropIfExists('email_settings');
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('system_settings');
        Schema::dropIfExists('doctor_statistics');
        Schema::dropIfExists('patient_statistics');
        Schema::dropIfExists('system_health_reports');
        Schema::dropIfExists('system_reports');
        Schema::dropIfExists('backup_logs');
        Schema::dropIfExists('notifications');
    }
};