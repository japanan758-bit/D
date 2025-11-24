<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\ApiIntegration;

class ApiIntegrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $integrations = [
            // Analytics Integrations
            [
                'name' => 'google_analytics',
                'display_name' => 'Google Analytics 4',
                'category' => 'analytics',
                'description' => 'Track website traffic, user behavior, and conversion data with Google Analytics 4',
                'is_active' => false,
                'is_testing' => true,
                'configuration' => [
                    'environment' => 'production',
                    'tracking_enabled' => true,
                    'privacy_compliant' => true,
                    'anonymize_ip' => true,
                    'cookie_consent_required' => true
                ],
                'api_keys' => [
                    'api_secret' => '' // Placeholder - needs real key
                ]
            ],
            [
                'name' => 'cloudflare_analytics',
                'display_name' => 'Cloudflare Web Analytics',
                'category' => 'analytics',
                'description' => 'Privacy-focused analytics without cookies, compatible with GDPR',
                'is_active' => false,
                'is_testing' => true,
                'configuration' => [
                    'environment' => 'production',
                    'tracking_enabled' => true,
                    'privacy_compliant' => true
                ],
                'api_keys' => [
                    'site_tag' => '' // Cloudflare site tag
                ]
            ],
            [
                'name' => 'meta_pixel',
                'display_name' => 'Meta Pixel (Facebook & Instagram)',
                'category' => 'marketing',
                'description' => 'Track Facebook and Instagram ads performance and conversions',
                'is_active' => false,
                'is_testing' => true,
                'configuration' => [
                    'environment' => 'production',
                    'tracking_events' => true,
                    'conversion_tracking' => true,
                    'custom_audiences' => true
                ],
                'api_keys' => [
                    'access_token' => '' // Placeholder - needs real token
                ]
            ],

            // Security Integrations
            [
                'name' => 'recaptcha',
                'display_name' => 'Google reCAPTCHA v3',
                'category' => 'security',
                'description' => 'Protect forms from spam and bot attacks using Google reCAPTCHA v3',
                'is_active' => false,
                'is_testing' => true,
                'configuration' => [
                    'environment' => 'production',
                    'security_level' => 'high',
                    'rate_limiting' => true,
                    'theme' => 'light',
                    'size' => 'normal'
                ],
                'api_keys' => [
                    'secret_key' => '' // Placeholder - needs real key
                ]
            ],
            [
                'name' => 'hcaptcha',
                'display_name' => 'hCaptcha',
                'category' => 'security',
                'description' => 'Privacy-focused alternative to Google reCAPTCHA',
                'is_active' => false,
                'is_testing' => true,
                'configuration' => [
                    'environment' => 'production',
                    'security_level' => 'medium',
                    'theme' => 'light'
                ],
                'api_keys' => [
                    'secret_key' => '' // Placeholder - needs real key
                ]
            ],

            // Communication Integrations
            [
                'name' => 'email',
                'display_name' => 'SMTP Email Service',
                'category' => 'communication',
                'description' => 'Send appointment confirmations, reminders, and notifications via email',
                'is_active' => false,
                'is_testing' => true,
                'configuration' => [
                    'environment' => 'production',
                    'provider' => 'sendgrid',
                    'retry_attempts' => 3,
                    'batch_processing' => true,
                    'from_email' => 'noreply@clinic.com',
                    'from_name' => 'Dr. Al-Akhras Clinic'
                ],
                'api_keys' => [
                    'sendgrid_api_key' => '', // Placeholder - needs real key
                    'mailgun_api_key' => '',
                    'brevo_api_key' => ''
                ]
            ],
            [
                'name' => 'whatsapp',
                'display_name' => 'WhatsApp Cloud API',
                'category' => 'communication',
                'description' => 'Send appointment confirmations and reminders via WhatsApp',
                'is_active' => false,
                'is_testing' => true,
                'configuration' => [
                    'environment' => 'production',
                    'retry_attempts' => 3,
                    'batch_processing' => true,
                    'phone_number_id' => '',
                    'business_account_id' => ''
                ],
                'api_keys' => [
                    'access_token' => '' // Placeholder - needs real token
                ]
            ],
            [
                'name' => 'sms',
                'display_name' => 'SMS Gateway Service',
                'category' => 'communication',
                'description' => 'Send OTP codes and appointment reminders via SMS',
                'is_active' => false,
                'is_testing' => true,
                'configuration' => [
                    'environment' => 'production',
                    'provider' => 'twilio',
                    'retry_attempts' => 3,
                    'batch_processing' => true,
                    'sender_name' => 'ClinicApp',
                    'otp_expires_in' => 300
                ],
                'api_keys' => [
                    'twilio_sid' => '', // Placeholder - needs real SID
                    'twilio_token' => '',
                    'vodafone_api_key' => '',
                    'infobip_api_key' => ''
                ]
            ],
            [
                'name' => 'firebase',
                'display_name' => 'Firebase (Notifications & Storage)',
                'category' => 'storage',
                'description' => 'Real-time notifications, cloud storage, and database synchronization',
                'is_active' => false,
                'is_testing' => true,
                'configuration' => [
                    'environment' => 'production',
                    'compression' => true,
                    'cdn_enabled' => true,
                    'backup_enabled' => true,
                    'project_id' => '',
                    'database_url' => '',
                    'client_email' => ''
                ],
                'api_keys' => [
                    'private_key' => '', // Placeholder - needs real key
                    'api_key' => '' // Firebase web API key
                ]
            ],

            // Payment Integrations
            [
                'name' => 'payment',
                'display_name' => 'Payment Gateway Service',
                'category' => 'payment',
                'description' => 'Process appointment payments using Stripe, Paymob, or Fawry',
                'is_active' => false,
                'is_testing' => true,
                'configuration' => [
                    'environment' => 'sandbox',
                    'provider' => 'stripe',
                    'currency' => 'SAR',
                    'auto_capture' => true,
                    'refund_policy' => 'standard',
                    'paymob_integration_id' => '',
                    'fawry_merchant_code' => ''
                ],
                'api_keys' => [
                    'stripe_secret_key' => '', // Placeholder - needs real key
                    'paymob_api_key' => '',
                    'fawry_security_key' => ''
                ]
            ],

            // Storage & Media Integrations
            [
                'name' => 'cloudinary',
                'display_name' => 'Cloudinary (Image & Video)',
                'category' => 'storage',
                'description' => 'Upload, optimize, and deliver images and videos with automatic compression',
                'is_active' => false,
                'is_testing' => true,
                'configuration' => [
                    'environment' => 'production',
                    'compression' => true,
                    'cdn_enabled' => true,
                    'backup_enabled' => true,
                    'upload_folder' => 'clinic_uploads',
                    'default_transformation' => 'w_1200,q_auto,f_auto',
                    'cloud_name' => ''
                ],
                'api_keys' => [
                    'api_key' => '', // Placeholder - needs real key
                    'api_secret' => '',
                    'upload_preset' => ''
                ]
            ],
            [
                'name' => 'imagekit',
                'display_name' => 'ImageKit (Image Optimization)',
                'category' => 'storage',
                'description' => 'Real-time image optimization, transformation, and CDN delivery',
                'is_active' => false,
                'is_testing' => true,
                'configuration' => [
                    'environment' => 'production',
                    'compression' => true,
                    'cdn_enabled' => true,
                    'endpoint' => '',
                    'private_key' => ''
                ],
                'api_keys' => [
                    'api_key' => '', // Placeholder - needs real key
                    'api_secret' => ''
                ]
            ],

            // Location & Maps Integration
            [
                'name' => 'google_maps',
                'display_name' => 'Google Maps API',
                'category' => 'analytics',
                'description' => 'Display clinic location, directions, and nearby place recommendations',
                'is_active' => false,
                'is_testing' => true,
                'configuration' => [
                    'environment' => 'production',
                    'clinic_address' => '',
                    'clinic_latitude' => 24.7136,
                    'clinic_longitude' => 46.6753,
                    'clinic_place_id' => '',
                    'map_size' => '600x400',
                    'search_radius' => 5000
                ],
                'api_keys' => [
                    'api_key' => '' // Placeholder - needs real key
                ]
            ],

            // Monitoring & Analytics
            [
                'name' => 'uptime_robot',
                'display_name' => 'UptimeRobot Monitoring',
                'category' => 'monitoring',
                'description' => 'Monitor website uptime and performance with automated alerts',
                'is_active' => false,
                'is_testing' => true,
                'configuration' => [
                    'environment' => 'production',
                    'alert_thresholds' => 'default',
                    'notification_frequency' => 'immediate',
                    'check_interval' => 5
                ],
                'api_keys' => [
                    'api_key' => '' // Placeholder - needs real key
                ]
            ],

            // Additional Security
            [
                'name' => 'cloudflare_turnstile',
                'display_name' => 'Cloudflare Turnstile',
                'category' => 'security',
                'description' => 'Privacy-focused CAPTCHA replacement by Cloudflare',
                'is_active' => false,
                'is_testing' => true,
                'configuration' => [
                    'environment' => 'production',
                    'security_level' => 'medium',
                    'theme' => 'auto'
                ],
                'api_keys' => [
                    'secret_key' => '' // Placeholder - needs real key
                ]
            ],

            // Geolocation
            [
                'name' => 'ip_geolocation',
                'display_name' => 'IP Geolocation API',
                'category' => 'analytics',
                'description' => 'Detect visitor location and customize content based on geography',
                'is_active' => false,
                'is_testing' => true,
                'configuration' => [
                    'environment' => 'production',
                    'provider' => 'ipdata',
                    'cache_duration' => 3600
                ],
                'api_keys' => [
                    'api_key' => '' // Placeholder - needs real key
                ]
            ],

            // Tag Management
            [
                'name' => 'google_tag_manager',
                'display_name' => 'Google Tag Manager',
                'category' => 'marketing',
                'description' => 'Manage all tracking and marketing tags from a single interface',
                'is_active' => false,
                'is_testing' => true,
                'configuration' => [
                    'environment' => 'production',
                    'container_id' => '',
                    'debug_mode' => false
                ],
                'api_keys' => [
                    'api_key' => '' // Placeholder - needs real key
                ]
            ],

            // OneSignal for Push Notifications
            [
                'name' => 'onesignal',
                'display_name' => 'OneSignal Push Notifications',
                'category' => 'communication',
                'description' => 'Send web push notifications for appointment reminders and updates',
                'is_active' => false,
                'is_testing' => true,
                'configuration' => [
                    'environment' => 'production',
                    'app_id' => '',
                    'safari_web_id' => '',
                    'notification_settings' => [
                        'sound' => 'default',
                        'vibrate' => true,
                        'TTL' => 86400
                    ]
                ],
                'api_keys' => [
                    'rest_api_key' => '' // Placeholder - needs real key
                ]
            ]
        ];

        foreach ($integrations as $integration) {
            ApiIntegration::create($integration);
        }

        $this->command->info('API integrations seeded successfully!');
        $this->command->info('Remember to configure API keys and settings for each integration.');
    }
}