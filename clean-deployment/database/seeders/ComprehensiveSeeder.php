<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Service;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ComprehensiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
        $this->clearData();
        
        // Create admin user if not exists
        $this->createAdminUser();
        
        // Create patients
        $patients = $this->createPatients();
        
        // Create appointments for patients
        $this->createAppointments($patients);
        
        // Create medical records
        $this->createMedicalRecords($patients);
        
        $this->command->info('تم إكمال إنشاء البيانات الشاملة بنجاح!');
    }
    
    private function clearData()
    {
        MedicalRecord::truncate();
        Appointment::truncate();
        Patient::truncate();
        
        $this->command->info('تم مسح البيانات القديمة');
    }
    
    private function createAdminUser()
    {
        if (!User::where('email', 'admin@clinic.com')->exists()) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@clinic.com',
                'password' => bcrypt('admin123'),
                'email_verified_at' => now(),
            ]);
            $this->command->info('تم إنشاء مستخدم الإدارة');
        }
    }
    
    private function createPatients()
    {
        $patientsData = [
            [
                'name' => 'أحمد محمد السعودي',
                'email' => 'ahmed.mohammed@example.com',
                'phone' => '+966501234567',
                'date_of_birth' => Carbon::parse('1985-03-15'),
                'gender' => 'male',
                'address' => 'الرياض، حي العليا، شارع الملك فهد',
                'allergies' => 'بنسللين، الأسبرين',
                'current_medications' => 'ميتفورمين 500mg مرتين يومياً',
                'medical_history' => 'مرض السكري النوع 2، ارتفاع ضغط الدم',
                'blood_type' => 'A+',
                'is_active' => true,
            ],
            [
                'name' => 'فاطمة علي الزهراني',
                'email' => 'fatima.ali@example.com',
                'phone' => '+966502345678',
                'date_of_birth' => Carbon::parse('1990-07-22'),
                'gender' => 'female',
                'address' => 'جدة، حي الروضة، شارع التحلية',
                'allergies' => 'لا توجد',
                'current_medications' => 'حمض الفوليك، فيتامين د',
                'medical_history' => 'فقر الدم، نقص فيتامين د',
                'blood_type' => 'O+',
                'is_active' => true,
            ],
            [
                'name' => 'خالد عبدالله المطيري',
                'email' => 'khalid.abdullah@example.com',
                'phone' => '+966503456789',
                'date_of_birth' => Carbon::parse('1978-11-10'),
                'gender' => 'male',
                'address' => 'الدمام، حي الشاطئ، طريق الكورنيش',
                'allergies' => 'أومبريبzol',
                'current_medications' => 'أتورفاستاتين 20mg يومياً',
                'medical_history' => 'ارتفاع الكوليسترول، مشاكل في القلب',
                'blood_type' => 'B+',
                'is_active' => true,
            ],
            [
                'name' => 'نورا سالم الحربي',
                'email' => 'nora.salem@example.com',
                'phone' => '+966504567890',
                'date_of_birth' => Carbon::parse('1995-12-05'),
                'gender' => 'female',
                'address' => 'مكة المكرمة، حي العزيزية، شارع إبراهيم الخليل',
                'allergies' => 'لا توجد',
                'current_medications' => 'لا توجد',
                'medical_history' => 'لا توجد',
                'blood_type' => 'AB+',
                'is_active' => true,
            ],
            [
                'name' => 'عبدالرحمن أحمد القحطاني',
                'email' => 'abdulrahman.ahmed@example.com',
                'phone' => '+966505678901',
                'date_of_birth' => Carbon::parse('1982-04-18'),
                'gender' => 'male',
                'address' => 'الطائف، حي الشهداء، طريق الملك فهد',
                'allergies' => 'Ibuprofen',
                'current_medications' => 'أملوديبين 5mg يومياً',
                'medical_history' => 'ارتفاع ضغط الدم، التهاب المفاصل',
                'blood_type' => 'O-',
                'is_active' => true,
            ],
            [
                'name' => 'ريم محمد الدوسري',
                'email' => 'reem.mohammed@example.com',
                'phone' => '+966506789012',
                'date_of_birth' => Carbon::parse('1988-09-30'),
                'gender' => 'female',
                'address' => 'أبها، حي المنهل، شارع الملك عبدالعزيز',
                'allergies' => 'Penicillin',
                'current_medications' => 'ليفوثيروكسين 100mcg يومياً',
                'medical_history' => 'قصور الغدة الدرقية',
                'blood_type' => 'A-',
                'is_active' => true,
            ],
            [
                'name' => 'محمد سعد الغامدي',
                'email' => 'mohammed.saad@example.com',
                'phone' => '+966507890123',
                'date_of_birth' => Carbon::parse('1975-01-25'),
                'gender' => 'male',
                'address' => 'خميس مشيط، حي السداد، شارع الملك فيصل',
                'allergies' => 'لا توجد',
                'current_medications' => 'ميتوبرولول 50mg مرتين يومياً',
                'medical_history' => 'أمراض القلب التاجية',
                'blood_type' => 'B-',
                'is_active' => true,
            ],
            [
                'name' => 'سارة عمر الشهري',
                'email' => 'sara.omar@example.com',
                'phone' => '+966508901234',
                'date_of_birth' => Carbon::parse('1992-06-12'),
                'gender' => 'female',
                'address' => 'بريدة، حي الصفراء، طريق الملك عبدالعزيز',
                'allergies' => 'Aspirin',
                'current_medications' => 'إيزوميبرازول 20mg يومياً',
                'medical_history' => 'قرحة المعدة، متلازمة القولون العصبي',
                'blood_type' => 'AB-',
                'is_active' => true,
            ],
            [
                'name' => 'يوسف علي الأندلسي',
                'email' => 'youssef.ali@example.com',
                'phone' => '+966509012345',
                'date_of_birth' => Carbon::parse('1980-08-08'),
                'gender' => 'male',
                'address' => 'جازان، حي الصناعية، طريق الملك فهد',
                'allergies' => 'لا توجد',
                'current_medications' => 'كلوميد 50mg مرتين يومياً',
                'medical_history' => 'داء السكري النوع 1',
                'blood_type' => 'A+',
                'is_active' => true,
            ],
            [
                'name' => 'هند حسن القرني',
                'email' => 'hind.hassan@example.com',
                'phone' => '+966510123456',
                'date_of_birth' => Carbon::parse('1993-11-14'),
                'gender' => 'female',
                'address' => 'نجران، حي الفيصلية، شارع الأمير مشعل',
                'allergies' => 'Cephalexin',
                'current_medications' => 'مكملات الكالسيوم وفيتامين د',
                'medical_history' => 'هشاشة العظام المبكرة',
                'blood_type' => 'B+',
                'is_active' => true,
            ]
        ];
        
        $patients = [];
        foreach ($patientsData as $patientData) {
            $patient = Patient::create($patientData);
            $patients[] = $patient;
        }
        
        $this->command->info('تم إنشاء ' . count($patients) . ' مريض');
        return $patients;
    }
    
    private function createAppointments($patients)
    {
        $doctors = Doctor::all();
        $services = Service::all();
        
        if ($doctors->isEmpty() || $services->isEmpty()) {
            $this->command->warn('تحذير: لا توجد أطباء أو خدمات. سيتم إنشاء مواعيد أساسية فقط.');
            return;
        }
        
        $appointmentStatuses = ['pending', 'confirmed', 'completed', 'cancelled'];
        $appointmentStatuses = ['pending' => 20, 'confirmed' => 30, 'completed' => 45, 'cancelled' => 5];
        
        foreach ($patients as $patient) {
            // Create 2-4 appointments per patient
            $appointmentCount = rand(2, 4);
            
            for ($i = 0; $i < $appointmentCount; $i++) {
                // Random appointment date (some past, some future)
                $daysFromNow = rand(-60, 30);
                $appointmentDate = Carbon::now()->addDays($daysFromNow);
                
                // Random appointment time
                $times = ['09:00', '10:00', '11:00', '14:00', '15:00', '16:00'];
                $appointmentTime = $times[array_rand($times)];
                
                // Determine status based on date
                if ($appointmentDate->isPast()) {
                    $status = 'completed';
                } elseif ($daysFromNow <= 7) {
                    $status = 'confirmed';
                } else {
                    $status = 'pending';
                }
                
                // Random service and doctor
                $service = $services->random();
                $doctor = $doctors->random();
                
                $appointment = Appointment::create([
                    'patient_name' => $patient->name,
                    'patient_phone' => $patient->phone,
                    'patient_email' => $patient->email,
                    'service_id' => $service->id,
                    'doctor_id' => $doctor->id,
                    'appointment_date' => $appointmentDate->format('Y-m-d'),
                    'appointment_time' => $appointmentTime,
                    'service_fee' => $service->price,
                    'status' => $status,
                    'notes' => rand(0, 1) ? 'ملاحظات إضافية للموعد' : null,
                    'created_at' => Carbon::now()->subDays(rand(1, 30)),
                ]);
                
                // Add cancellation reasons for cancelled appointments
                if ($status === 'cancelled') {
                    $appointment->update([
                        'cancelled_at' => Carbon::now()->subDays(rand(1, 7)),
                        'cancel_reason' => [
                            'لم أحضر في الوقت المحدد',
                            'تغيرت الظروف',
                            'مشاكل في النقل',
                            'طلب من المريض'
                        ][array_rand(['لم أحضر في الوقت المحدد', 'تغيرت الظروف', 'مشاكل في النقل', 'طلب من المريض'])]
                    ]);
                }
            }
        }
        
        $totalAppointments = count($patients) * rand(2, 4);
        $this->command->info("تم إنشاء {$totalAppointments} موعد");
    }
    
    private function createMedicalRecords($patients)
    {
        $doctors = Doctor::all();
        $services = Service::all();
        
        $completedAppointments = Appointment::where('status', 'completed')->get();
        
        foreach ($completedAppointments as $appointment) {
            // Create medical record for completed appointments only
            $medicalRecord = MedicalRecord::create([
                'patient_name' => $appointment->patient_name,
                'patient_email' => $appointment->patient_email,
                'patient_phone' => $appointment->patient_phone,
                'patient_date_of_birth' => $appointment->patient->date_of_birth ?? null,
                'patient_gender' => $appointment->patient->gender ?? null,
                'patient_address' => $appointment->patient->address ?? null,
                'patient_emergency_contact' => 'جهة الاتصال للطوارئ',
                'patient_allergies' => $appointment->patient->allergies ?? null,
                'patient_current_medications' => $appointment->patient->current_medications ?? null,
                'patient_medical_history' => $appointment->patient->medical_history ?? null,
                'patient_blood_type' => $appointment->patient->blood_type ?? null,
                'doctor_id' => $appointment->doctor_id,
                'appointment_id' => $appointment->id,
                'chief_complaint' => $this->getRandomChiefComplaint(),
                'symptoms' => $this->getRandomSymptoms(),
                'duration' => 'منذ أسبوع',
                'severity' => ['mild', 'moderate', 'severe'][array_rand(['mild', 'moderate', 'severe'])],
                'location' => 'منطقة العين اليمنى',
                'past_medical_history' => $appointment->patient->medical_history ?? null,
                'past_surgical_history' => 'لا توجد',
                'family_history' => 'لا توجد أمراض عائلية',
                'social_history' => 'مدخن',
                'drug_allergies' => $appointment->patient->allergies ?? null,
                'physical_examination' => 'الفحص البدني طبيعي',
                'vital_signs' => json_encode([
                    'blood_pressure' => '120/80',
                    'heart_rate' => '72',
                    'temperature' => '36.5'
                ]),
                'general_appearance' => 'المريض يبدو بصحة جيدة',
                'vitals_height' => 175,
                'vitals_weight' => 70,
                'vitals_bp' => '120/80',
                'vitals_hr' => 72,
                'vitals_temp' => 36.5,
                'lab_results' => json_encode([
                    'glucose' => '90 mg/dL',
                    'cholesterol' => '180 mg/dL',
                    'hemoglobin' => '14 g/dL'
                ]),
                'imaging_studies' => json_encode([
                    'x_ray' => 'طبيعي',
                    'ct_scan' => 'غير مطلوب'
                ]),
                'diagnosis' => $this->getRandomDiagnosis(),
                'differential_diagnosis' => 'تشخيص تفريقي',
                'treatment_plan' => $this->getRandomTreatmentPlan(),
                'medications' => json_encode(['دواء للمريض']),
                'dosages' => json_encode(['قرص واحد']),
                'frequencies' => json_encode(['مرتين يومياً']),
                'durations' => json_encode(['لمدة أسبوع']),
                'instructions' => 'تناول الدواء مع الطعام',
                'follow_up_instructions' => 'متابعة بعد أسبوع',
                'next_appointment' => Carbon::now()->addDays(7)->format('Y-m-d'),
                'patient_education' => 'المريض تم توعيته بالوضع الصحي',
                'notes' => 'ملاحظات إضافية',
                'record_date' => $appointment->appointment_date,
                'created_by' => 1,
            ]);
        }
        
        $this->command->info('تم إنشاء ' . count($completedAppointments) . ' سجل طبي');
    }
    
    private function getRandomChiefComplaint()
    {
        $complaints = [
            'ألم في العين اليمنى',
            'عدم وضوح في الرؤية',
            'إرهاق في العينين',
            'احمرار في العينين',
            'حكة في العينين',
            'إفرازات من العين',
            'صداع مستمر',
            'ألم خلف العين',
            'رؤية هالات ملونة حول الأضواء',
            'صعوبة في القراءة'
        ];
        
        return $complaints[array_rand($complaints)];
    }
    
    private function getRandomSymptoms()
    {
        $symptoms = [
            'ألم حاد في العين',
            'احمرار وتهيج',
            'رؤية ضبابية',
            'حكة مستمرة',
            'إفرازات مائية',
            'تورم في الجفون',
            'حساسية للضوء',
            'دموع غزيرة',
            'تشنج في الجفن',
            'فقدان جزئي للرؤية'
        ];
        
        return $symptoms[array_rand($symptoms)];
    }
    
    private function getRandomDiagnosis()
    {
        $diagnoses = [
            'التهاب الملتحمة',
            'جفاف العين',
            'إجهاد العين الرقمي',
            'التهاب الجفون',
            'اعتلال الشبكية السكري',
            'المياه الزرقاء',
            'قصر النظر',
            'طول النظر',
            'إعتام عدسة العين',
            'التهاب القرنية'
        ];
        
        return $diagnoses[array_rand($diagnoses)];
    }
    
    private function getRandomTreatmentPlan()
    {
        $treatments = [
            'استخدام قطرات العين المضادة للالتهاب',
            'فحص النظر ووصف نظارات',
            'دورات تقوية عضلات العين',
            'استخدام مراهم العين المهدئة',
            'تغيير نمط الحياة وتجنب الشاشات',
            'فحص دوري كل 6 أشهر',
            'تحاليل دم شاملة',
            'تصوير شبكي للعين',
            'قياس ضغط العين',
            'فحص قاع العين'
        ];
        
        return $treatments[array_rand($treatments)];
    }
}