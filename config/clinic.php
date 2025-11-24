<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Clinic Management System Configuration
    |--------------------------------------------------------------------------
    |
    | إعدادات نظام إدارة العيادة
    |
    */

    // معلومات العيادة
    'clinic_info' => [
        'name' => env('CLINIC_NAME', 'عيادة د. عبدالناصر الأخصور'),
        'description' => env('CLINIC_DESCRIPTION', 'عيادة رائدة في جراحات الشبكية والمياه البيضاء'),
        'tagline' => env('CLINIC_TAGLINE', 'استشاري جراحات الشبكية والمياه البيضاء'),
        'established_year' => env('CLINIC_ESTABLISHED', '2000'),
        'location' => env('CLINIC_LOCATION', 'الرياض، المملكة العربية السعودية'),
    ],

    // معلومات الطبيب
    'doctor_info' => [
        'name' => env('DOCTOR_NAME', 'د. عبدالناصر الأخصور'),
        'specialty' => env('DOCTOR_SPECIALTY', 'استشاري جراحات الشبكية والمياه البيضاء'),
        'experience_years' => env('DOCTOR_EXPERIENCE', '20'),
        'qualifications' => [
            'bachelor' => 'بكالوريوس الطب والجراحة',
            'specialist' => 'أخصائي طب وجراحة العيون',
            'consultant' => 'استشاري جراحات الشبكية والمياه البيضاء',
        ],
        'certifications' => [
            'international_retina' => 'شهادة دولية في جراحات الشبكية',
            'cataract_surgery' => 'شهادة جراحة المياه البيضاء المتقدمة',
            'laser_surgery' => 'شهادة جراحات الليزر',
        ],
    ],

    // إعدادات الخدمات
    'services' => [
        'default_consultation_fee' => env('DEFAULT_CONSULTATION_FEE', 500),
        'currency' => env('CURRENCY', 'SAR'),
        'currency_symbol' => env('CURRENCY_SYMBOL', 'ر.س'),
        'payment_methods' => ['cash', 'card', 'insurance'],
        'insurance_accepted' => env('INSURANCE_ACCEPTED', false),
    ],

    // إعدادات المواعيد
    'appointments' => [
        'default_duration' => 30, // minutes
        'working_days' => ['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday'],
        'working_hours' => [
            'start' => '10:00',
            'end' => '20:00',
            'break_start' => '13:00',
            'break_end' => '14:00',
        ],
        'advance_booking_days' => 30, // days
        'cancellation_policy_hours' => 24, // hours before appointment
        'max_daily_appointments' => 20,
    ],

    // إعدادات التواصل
    'communication' => [
        'whatsapp' => [
            'enabled' => env('WHATSAPP_ENABLED', true),
            'number' => env('WHATSAPP_NUMBER', '966123456789'),
            'auto_reply' => env('WHATSAPP_AUTO_REPLY', true),
        ],
        'email' => [
            'enabled' => env('EMAIL_ENABLED', true),
            'notifications' => env('EMAIL_NOTIFICATIONS', true),
            'auto_responses' => env('EMAIL_AUTO_RESPONSES', true),
        ],
        'sms' => [
            'enabled' => env('SMS_ENABLED', false),
            'provider' => env('SMS_PROVIDER', 'twilio'),
        ],
    ],

    // إعدادات العيادة
    'facility' => [
        'address' => env('CLINIC_ADDRESS', ''),
        'phone' => env('CLINIC_PHONE', ''),
        'emergency_phone' => env('EMERGENCY_PHONE', ''),
        'email' => env('CLINIC_EMAIL', ''),
        'website' => env('CLINIC_WEBSITE', ''),
        'coordinates' => [
            'latitude' => env('CLINIC_LATITUDE', null),
            'longitude' => env('CLINIC_LONGITUDE', null),
        ],
    ],

    // إعدادات الترجمة والواجهة
    'interface' => [
        'default_locale' => 'ar',
        'supported_locales' => ['ar', 'en'],
        'timezone' => env('APP_TIMEZONE', 'Asia/Riyadh'),
        'date_format' => 'Y-m-d',
        'time_format' => 'H:i',
        'rtl_support' => true,
    ],

    // إعدادات الأداء
    'performance' => [
        'cache_enabled' => env('CACHE_ENABLED', true),
        'image_optimization' => true,
        'minify_assets' => env('MINIFY_ASSETS', true),
        'cdn_enabled' => env('CDN_ENABLED', false),
        'preload_critical_resources' => true,
    ],

    // إعدادات SEO
    'seo' => [
        'meta_title' => env('SEO_META_TITLE', 'عيادة د. عبدالناصر الأخصور - استشاري جراحات الشبكية والمياه البيضاء'),
        'meta_description' => env('SEO_META_DESCRIPTION', 'عيادة متخصصة في جراحات الشبكية والمياه البيضاء مع أكثر من 20 عاماً من الخبرة'),
        'meta_keywords' => env('SEO_META_KEYWORDS', 'عيادة، عيون، شبكية، مياه بيضاء، جلوكوما، د. عبدالناصر الأخصور'),
        'google_analytics_id' => env('GOOGLE_ANALYTICS_ID', ''),
        'google_search_console' => env('GOOGLE_SEARCH_CONSOLE', ''),
        'facebook_pixel_id' => env('FACEBOOK_PIXEL_ID', ''),
    ],

    // إعدادات الأمان
    'security' => [
        'require_authentication' => true,
        'session_timeout' => 7200, // 2 hours
        'max_login_attempts' => 5,
        'lockout_duration' => 900, // 15 minutes
        'force_https' => env('FORCE_HTTPS', true),
        'enable_2fa' => env('ENABLE_2FA', false),
        'audit_logging' => true,
        'data_encryption' => true,
    ],

    // إعدادات النسخ الاحتياطي
    'backup' => [
        'enabled' => env('BACKUP_ENABLED', true),
        'frequency' => env('BACKUP_FREQUENCY', 'daily'),
        'retention_days' => env('BACKUP_RETENTION_DAYS', 30),
        'destination' => env('BACKUP_DESTINATION', 'local'),
        'compression' => true,
        'encryption' => true,
    ],

    // إعدادات الإشعارات
    'notifications' => [
        'appointment_reminders' => true,
        'appointment_confirmations' => true,
        'cancellation_notifications' => true,
        'marketing_emails' => env('MARKETING_EMAILS_ENABLED', false),
        'push_notifications' => env('PUSH_NOTIFICATIONS_ENABLED', false),
    ],

    // إعدادات البيانات والتحليلات
    'analytics' => [
        'track_user_behavior' => true,
        'track_appointment_metrics' => true,
        'track_popular_services' => true,
        'patient_satisfaction_surveys' => true,
        'performance_monitoring' => true,
    ],

    // إعدادات الاستضافة
    'hosting' => [
        'provider' => 'hostinger',
        'shared_hosting' => true,
        'max_execution_time' => 300,
        'memory_limit' => '256M',
        'upload_max_filesize' => '64M',
        'post_max_size' => '64M',
    ],

    // إعدادات الصيانة
    'maintenance' => [
        'auto_cleanup_logs' => true,
        'cleanup_after_days' => 90,
        'auto_optimize_database' => true,
        'maintenance_mode_enabled' => false,
        'maintenance_message' => 'الموقع تحت الصيانة حالياً. يرجى المحاولة لاحقاً.',
    ],

    // إعدادات API
    'api' => [
        'enabled' => false, // Will be enabled in future versions
        'version' => 'v1',
        'rate_limiting' => true,
        'authentication' => 'api_key',
        'cors_enabled' => true,
    ],

    // إعدادات المتاجر والتطبيقات
    'integrations' => [
        'whatsapp_business_api' => env('WHATSAPP_BUSINESS_API', false),
        'telegram_bot' => env('TELEGRAM_BOT', false),
        'google_calendar' => env('GOOGLE_CALENDAR', false),
        'stripe_payments' => env('STRIPE_PAYMENTS', false),
        'paypal_payments' => env('PAYPAL_PAYMENTS', false),
    ],

];