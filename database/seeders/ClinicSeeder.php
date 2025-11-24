<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class ClinicSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure Admin User Exists
        $adminEmail = 'admin@clinic.com';
        $adminUser = \App\Models\User::firstOrCreate(
            ['email' => $adminEmail],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'), // Default password
                'role' => 'admin',
            ]
        );
        // If user exists but role is wrong, update it
        if ($adminUser->role !== 'admin') {
            $adminUser->update(['role' => 'admin']);
        }

        // Update Settings
        $settings = Setting::firstOrCreate([]);
        $settings->update([
            'clinic_name' => 'عيادة الشبكية والمياه البيضاء – د. عبدالناصر الأخرس',
            'clinic_address' => '13 ميدان سفنكس – عمارة البنك الأهلي – المهندسين – داخل مركز برادة، المهندسين – الجيزة – مصر',
            'clinic_phone' => '01055558199',
            'clinic_email' => 'dr.abdelnaser@retinacataracteg.com',
            'whatsapp_number' => '01055558199',
            'enable_booking' => true,
            'enable_payment' => false, // Deferred
            'enable_registration' => true, // Optional
        ]);

        // Create/Update Doctor
        Doctor::updateOrCreate(
            ['email' => 'dr.abdelnaser@retinacataracteg.com'],
            [
                'name' => ['ar' => 'د. عبدالناصر الأخرس', 'en' => 'Dr. Abdelnaser Al-Akhras'],
                'specialty' => ['ar' => 'استشاري جراحات الشبكية والمياه البيضاء', 'en' => 'Retina & Cataract Consultant'],
                'phone' => '01055558199',
                'is_active' => true,
                'bio' => [
                    'ar' => 'أمراض وجراحات الشبكية، عمليات المياه البيضاء، علاج الانفصال الشبكي، علاج اعتلال الشبكية السكري، عمليات تصحيح الإبصار المتقدمة، متابعة الأمراض المزمنة للعين',
                    'en' => 'Retina diseases and surgeries, Cataract surgeries, Retinal detachment treatment, Diabetic retinopathy treatment, Advanced vision correction surgeries, Chronic eye diseases follow-up'
                ]
            ]
        );
    }
}
