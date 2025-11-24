<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;
use App\Models\Service;
use App\Models\Article;
use App\Models\Testimonial;
use App\Models\Faq;
use App\Models\Setting;
use App\Models\Appointment;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ComprehensiveSeeder::class,
        ]);

        // Create Doctor
        $doctor = Doctor::create([
            'name' => [
                'ar' => 'د. عبدالناصر الأخرس',
                'en' => 'Dr. Abdelnasser Al-Akhras'
            ],
            'specialty' => [
                'ar' => 'استشاري جراحات الشبكية والمياه البيضاء',
                'en' => 'Retina and Cataract Surgery Consultant'
            ],
            'bio' => [
                'ar' => 'د. عبدالناصر الأخرس هو استشاري في جراحات الشبكية والمياه البيضاء مع أكثر من 20 عاماً من الخبرة في هذا المجال.',
                'en' => 'Dr. Abdelnasser Al-Akhras is a consultant in retina and cataract surgery with more than 20 years of experience in this field.'
            ],
            'qualifications' => [
                'ar' => 'بكالوريوس الطب والجراحة - أخصائي طب وجراحة العيون - استشاري جراحات الشبكية والمياه البيضاء',
                'en' => 'MBBCh - Ophthalmology Specialist - Retina and Cataract Surgery Consultant'
            ],
            'experience' => [
                'ar' => 'أكثر من 20 عاماً من الخبرة في جراحات العيون المتقدمة',
                'en' => 'More than 20 years of experience in advanced eye surgeries'
            ],
            'certificates' => [
                'ar' => 'شهادات متقدمة في جراحات الشبكية والمياه البيضاء من أفضل الجامعات العالمية',
                'en' => 'Advanced certifications in retina and cataract surgery from leading international universities'
            ],
            'years_of_experience' => 20,
            'consultation_fee' => 500.00,
            'email' => 'dr.akhras@clinic.com',
            'phone' => '01055558199'
        ]);

        // Create Settings (Singleton)
        $settings = Setting::create([
            'key' => 'main_settings',
            'clinic_name' => [
                'ar' => 'عيادة د. عبدالناصر الأخرس',
                'en' => 'Dr. Abdelnasser Al-Akhras Clinic'
            ],
            'description' => [
                'ar' => 'عيادة رائدة في جراحات الشبكية والمياه البيضاء',
                'en' => 'Leading clinic for retina and cataract surgery'
            ],
            'address' => [
                'ar' => '13 ميدان سفنكس، المهندسين، الجيزة، مصر',
                'en' => '13 Sphinx Square, El-Mohandessin, Giza, Egypt'
            ],
            'phone' => '01055558199',
            'whatsapp_number' => '01055558199',
            'email' => 'info@akhrasclinic.com',
            'working_hours' => [
                'ar' => json_encode([
                    'saturday' => '10:00 - 20:00',
                    'sunday' => '10:00 - 20:00', 
                    'monday' => '10:00 - 20:00',
                    'tuesday' => '10:00 - 20:00',
                    'wednesday' => '10:00 - 20:00',
                    'thursday' => '10:00 - 20:00',
                    'friday' => 'مغلق'
                ])
            ],
            'consultation_fee' => 500.00,
            'facebook_url' => 'https://facebook.com/akhrasclinic',
            'instagram_url' => 'https://instagram.com/akhrasclinic',
            'google_maps_url' => 'https://maps.google.com/?q=13+Sphinx+Square+El-Mohandessin+Giza'
        ]);

        // Create Services
        $services = [
            [
                'name' => [
                    'ar' => 'جراحة المياه البيضاء',
                    'en' => 'Cataract Surgery'
                ],
                'description' => [
                    'ar' => 'جراحة متقدمة للمياه البيضاء باستخدام أحدث التقنيات',
                    'en' => 'Advanced cataract surgery using the latest techniques'
                ],
                'price' => 8000.00,
                'consultation_fee' => 300.00,
                'follow_up_fee' => 150.00,
                'duration' => 30,
                'category' => 'cataract'
            ],
            [
                'name' => [
                    'ar' => 'جراحة الشبكية',
                    'en' => 'Retina Surgery'
                ],
                'description' => [
                    'ar' => 'علاج متقدم لأمراض الشبكية باستخدام أحدث التقنيات',
                    'en' => 'Advanced treatment for retinal diseases using cutting-edge techniques'
                ],
                'price' => 15000.00,
                'consultation_fee' => 500.00,
                'follow_up_fee' => 200.00,
                'duration' => 60,
                'category' => 'retina'
            ],
            [
                'name' => [
                    'ar' => 'فحص شامل للعيون',
                    'en' => 'Comprehensive Eye Examination'
                ],
                'description' => [
                    'ar' => 'فحص شامل للعيون يتضمن فحص البصر وضغط العين',
                    'en' => 'Complete eye examination including vision test and eye pressure'
                ],
                'price' => 300.00,
                'consultation_fee' => 300.00,
                'follow_up_fee' => 150.00,
                'duration' => 45,
                'category' => 'examination'
            ],
            [
                'name' => [
                    'ar' => 'علاج الجلوكوما',
                    'en' => 'Glaucoma Treatment'
                ],
                'description' => [
                    'ar' => 'علاج الجلوكوما بالأدوية والجراحة حسب الحالة',
                    'en' => 'Glaucoma treatment with medication and surgery depending on the case'
                ],
                'price' => 6000.00,
                'consultation_fee' => 400.00,
                'follow_up_fee' => 200.00,
                'duration' => 45,
                'category' => 'glaucoma'
            ],
            [
                'name' => [
                    'ar' => 'تصحيح النظر بالليزر',
                    'en' => 'Laser Vision Correction'
                ],
                'description' => [
                    'ar' => 'تصحيح النظر بعمليات الليزر الحديثة',
                    'en' => 'Vision correction with modern laser operations'
                ],
                'price' => 12000.00,
                'consultation_fee' => 500.00,
                'follow_up_fee' => 250.00,
                'duration' => 90,
                'category' => 'laser'
            ],
            [
                'name' => [
                    'ar' => 'فحص قاع العين',
                    'en' => 'Retina Examination'
                ],
                'description' => [
                    'ar' => 'فحص مفصل لقاع العين والشبكية',
                    'en' => 'Detailed examination of the retina and fundus'
                ],
                'price' => 400.00,
                'consultation_fee' => 400.00,
                'follow_up_fee' => 200.00,
                'duration' => 30,
                'category' => 'examination'
            ]
        ];

        foreach ($services as $service) {
            Service::create($service);
        }

        // Create Articles
        $articles = [
            [
                'title' => [
                    'ar' => 'أعراض وعلاج الجلوكوما',
                    'en' => 'Symptoms and Treatment of Glaucoma'
                ],
                'content' => [
                    'ar' => '<p>الجلوكوما هو أحد أهم أمراض العيون وأكثرها خطورة...</p>',
                    'en' => '<p>Glaucoma is one of the most important and dangerous eye diseases...</p>'
                ],
                'excerpt' => [
                    'ar' => 'دليل شامل عن الجلوكوما أعراضها وطرق العلاج المختلفة',
                    'en' => 'Comprehensive guide to glaucoma, its symptoms and different treatment methods'
                ],
                'is_published' => true,
                'is_featured' => true,
                'published_at' => now(),
                'category' => 'glaucoma',
                'slug' => 'glaucoma-symptoms-treatment'
            ],
            [
                'title' => [
                    'ar' => 'أحدث تقنيات جراحة المياه البيضاء',
                    'en' => 'Latest Techniques in Cataract Surgery'
                ],
                'content' => [
                    'ar' => '<p>تشهد جراحة المياه البيضاء تطوراً كبيراً في السنوات الأخيرة...</p>',
                    'en' => '<p>Cataract surgery has seen great development in recent years...</p>'
                ],
                'excerpt' => [
                    'ar' => 'تعرف على أحدث التقنيات المستخدمة في جراحة المياه البيضاء',
                    'en' => 'Learn about the latest techniques used in cataract surgery'
                ],
                'is_published' => true,
                'is_featured' => true,
                'published_at' => now()->subDays(7),
                'category' => 'cataract',
                'slug' => 'latest-cataract-surgery-techniques'
            ],
            [
                'title' => [
                    'ar' => 'أهمية فحص العيون الدوري',
                    'en' => 'Importance of Regular Eye Examination'
                ],
                'content' => [
                    'ar' => '<p>فحص العيون الدوري ضروري للحفاظ على صحة البصر...</p>',
                    'en' => '<p>Regular eye examination is essential for maintaining eye health...</p>'
                ],
                'excerpt' => [
                    'ar' => 'لماذا يجب إجراء فحص العيون بانتظام؟',
                    'en' => 'Why should eye examinations be done regularly?'
                ],
                'is_published' => true,
                'published_at' => now()->subDays(14),
                'category' => 'prevention',
                'slug' => 'importance-regular-eye-examination'
            ]
        ];

        foreach ($articles as $article) {
            Article::create($article);
        }

        // Create Testimonials
        $testimonials = [
            [
                'patient_name' => [
                    'ar' => 'أحمد محمد علي',
                    'en' => 'Ahmed Mohamed Ali'
                ],
                'patient_location' => [
                    'ar' => 'القاهرة',
                    'en' => 'Cairo'
                ],
                'content' => [
                    'ar' => 'تجربة ممتازة مع د. عبدالناصر الأخرس، العلاج كان ناجحاً جداً.',
                    'en' => 'Excellent experience with Dr. Abdelnasser Al-Akhras, the treatment was very successful.'
                ],
                'treatment_details' => [
                    'ar' => 'جراحة المياه البيضاء',
                    'en' => 'Cataract Surgery'
                ],
                'rating' => 5,
                'service_name' => 'جراحة المياه البيضاء',
                'treatment_date' => now()->subMonths(3),
                'is_featured' => true,
                'is_approved' => true
            ],
            [
                'patient_name' => [
                    'ar' => 'فاطمة حسن إسماعيل',
                    'en' => 'Fatma Hassan Ismail'
                ],
                'patient_location' => [
                    'ar' => 'الجيزة',
                    'en' => 'Giza'
                ],
                'content' => [
                    'ar' => 'أشعر بالامتنان للعيادة، الاهتمام كان مميزاً والنتائج مبهرة.',
                    'en' => 'I feel grateful to the clinic, the care was excellent and the results amazing.'
                ],
                'treatment_details' => [
                    'ar' => 'علاج الجلوكوما',
                    'en' => 'Glaucoma Treatment'
                ],
                'rating' => 5,
                'service_name' => 'علاج الجلوكوما',
                'treatment_date' => now()->subMonths(2),
                'is_featured' => true,
                'is_approved' => true
            ],
            [
                'patient_name' => [
                    'ar' => 'محمد أحمد الدين',
                    'en' => 'Mohamed Ahmed El Din'
                ],
                'patient_location' => [
                    'ar' => 'الإسكندرية',
                    'en' => 'Alexandria'
                ],
                'content' => [
                    'ar' => 'د. عبدالناصر محترف جداً، ساعدني في استعادة بصري.',
                    'en' => 'Dr. Abdelnasser is very professional, he helped me regain my vision.'
                ],
                'treatment_details' => [
                    'ar' => 'جراحة الشبكية',
                    'en' => 'Retina Surgery'
                ],
                'rating' => 5,
                'service_name' => 'جراحة الشبكية',
                'treatment_date' => now()->subMonth(),
                'is_featured' => true,
                'is_approved' => true
            ]
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }

        // Create FAQs
        $faqs = [
            [
                'question' => [
                    'ar' => 'كم تستغرق جراحة المياه البيضاء؟',
                    'en' => 'How long does cataract surgery take?'
                ],
                'answer' => [
                    'ar' => 'عادة ما تستغرق الجراحة من 15 إلى 30 دقيقة لكل عين.',
                    'en' => 'Surgery usually takes 15 to 30 minutes per eye.'
                ],
                'category' => [
                    'ar' => 'cataract',
                    'en' => 'cataract'
                ],
                'order' => 1
            ],
            [
                'question' => [
                    'ar' => 'هل يمكنني القيادة بعد جراحة الشبكية؟',
                    'en' => 'Can I drive after retina surgery?'
                ],
                'answer' => [
                    'ar' => 'ينصح بعدم القيادة لمدة أسبوع على الأقل بعد الجراحة.',
                    'en' => 'It is recommended not to drive for at least a week after surgery.'
                ],
                'category' => [
                    'ar' => 'retina',
                    'en' => 'retina'
                ],
                'order' => 2
            ],
            [
                'question' => [
                    'ar' => 'كم مرة يجب فحص العيون؟',
                    'en' => 'How often should I have my eyes examined?'
                ],
                'answer' => [
                    'ar' => 'يُنصح بالفحص السنوي للأشخاص فوق سن 40.',
                    'en' => 'Annual examination is recommended for people over 40.'
                ],
                'category' => [
                    'ar' => 'general',
                    'en' => 'general'
                ],
                'order' => 3
            ],
            [
                'question' => [
                    'ar' => 'ما هي تكلفة استشارة العيون؟',
                    'en' => 'What is the cost of an eye consultation?'
                ],
                'answer' => [
                    'ar' => 'تكلفة الاستشارة 500 جنيه مصري',
                    'en' => 'Consultation fee is 500 Egyptian pounds'
                ],
                'category' => [
                    'ar' => 'costs',
                    'en' => 'costs'
                ],
                'order' => 4
            ]
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }

        // Create sample appointments
        $servicesModel = Service::all();
        $firstService = $servicesModel->first();

        Appointment::create([
            'patient_name' => 'محمد أحمد محمد',
            'patient_phone' => '01012345678',
            'patient_email' => 'mohamed@example.com',
            'service_id' => $firstService->id,
            'appointment_date' => now()->addDays(7),
            'appointment_time' => '10:00:00',
            'notes' => 'طلب موعد للفحص الروتيني',
            'status' => 'pending',
            'confirmation_code' => str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT)
        ]);

        $this->command->info('Database seeded successfully!');
    }
}
