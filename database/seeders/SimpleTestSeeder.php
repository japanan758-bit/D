<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;

class SimpleTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🔄 بدء إنشاء البيانات التجريبية...');

        // إنشاء أو تحديث مدير النظام
        $admin = User::updateOrCreate(
            ['email' => 'admin@clinic.com'],
            [
                'name' => 'مدير النظام',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'admin',
            ]
        );

        // إنشاء أو تحديث طبيب
        $doctorUser = User::updateOrCreate(
            ['email' => 'doctor@clinic.com'],
            [
                'name' => 'د. عبدالناصر الأخصور',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'doctor',
            ]
        );

        $doctor = Doctor::updateOrCreate(
            ['email' => 'doctor@clinic.com'],
            [
                'name' => 'د. عبدالناصر الأخصور',
                'specialty' => 'طب عام',
                'consultation_fee' => 150.00,
                'is_active' => true,
            ]
        );

        // إنشاء أو تحديث مريض تجريبي
        $patientUser = User::updateOrCreate(
            ['email' => 'patient@clinic.com'],
            [
                'name' => 'أحمد محمد السعودي',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'patient',
            ]
        );

        $patient = Patient::updateOrCreate(
            ['email' => 'patient@clinic.com'],
            [
                'name' => 'أحمد محمد السعودي',
                'phone' => '+966501234567',
                'blood_type' => 'O+',
                'is_active' => true,
            ]
        );

        // إنشاء مرضى إضافيين
        $patientsData = [
            ['name' => 'فاطمة أحمد العربي', 'email' => 'fatima.ahmed@email.com', 'blood_type' => 'A+'],
            ['name' => 'محمد علي السعد', 'email' => 'mohammed.ali@email.com', 'blood_type' => 'B+'],
            ['name' => 'نورا خالد المطيري', 'email' => 'nora.khalid@email.com', 'blood_type' => 'AB+'],
            ['name' => 'سعد عبدالله القحطاني', 'email' => 'saad.abdullah@email.com', 'blood_type' => 'O-'],
            ['name' => 'ليلى محمد العتيبي', 'email' => 'layla.mohammed@email.com', 'blood_type' => 'A-'],
            ['name' => 'عمر حسن البقمي', 'email' => 'omar.hassan@email.com', 'blood_type' => 'B-'],
            ['name' => 'أمل سالم الدوسري', 'email' => 'amal.salem@email.com', 'blood_type' => 'AB-'],
            ['name' => 'يوسف أحمد الغامدي', 'email' => 'youssef.ahmed@email.com', 'blood_type' => 'O+'],
        ];

        foreach ($patientsData as $index => $patientData) {
            $newPatientUser = User::updateOrCreate(
                ['email' => $patientData['email']],
                [
                    'name' => $patientData['name'],
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                    'role' => 'patient',
                ]
            );

            Patient::updateOrCreate(
                ['email' => $patientData['email']],
                [
                    'name' => $patientData['name'],
                    'phone' => '+96650' . str_pad($index + 1000000, 6, '0', STR_PAD_LEFT),
                    'blood_type' => $patientData['blood_type'],
                    'is_active' => true,
                ]
            );
        }

        $this->command->info('✅ تم إنشاء البيانات التجريبية بنجاح!');
        $this->command->info('👥 المستخدمون:');
        $this->command->info('  • admin@clinic.com / password (مدير)');
        $this->command->info('  • doctor@clinic.com / password (طبيب)');
        $this->command->info('  • patient@clinic.com / password (مريض)');
        $this->command->info('🧑‍⚕️ إجمالي المرضى: ' . Patient::count());
    }
}