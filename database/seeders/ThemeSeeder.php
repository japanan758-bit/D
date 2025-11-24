<?php

namespace Database\Seeders;

use App\Models\Theme;
use App\Models\PageTemplate;
use App\Models\PageBuilderComponent;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default themes
        $this->createDefaultThemes();
        
        // Create default page templates
        $this->createDefaultPageTemplates();
        
        // Create default page builder components
        $this->createDefaultPageBuilderComponents();
    }

    /**
     * Create default themes
     */
    private function createDefaultThemes(): void
    {
        // Default Medical Theme
        $defaultTheme = Theme::create([
            'name' => 'الثيم الطبي الافتراضي',
            'slug' => 'default-medical',
            'description' => 'ثيم طبي احترافي مُحسن للعيادات والمستشفيات مع دعم كامل للغة العربية',
            'author' => 'فريق MiniMax',
            'version' => '1.0.0',
            'is_active' => true,
            'is_default' => true,
            'layout_type' => 'boxed',
            'color_scheme' => 'blue',
            'settings' => [
                'primary_color' => '#3b82f6',
                'secondary_color' => '#64748b',
                'accent_color' => '#10b981',
                'background_color' => '#ffffff',
                'surface_color' => '#f8fafc',
                'text_color' => '#1f2937',
                'success_color' => '#22c55e',
                'warning_color' => '#f59e0b',
                'error_color' => '#ef4444',
                'info_color' => '#06b6d4',
                'border_radius' => '8px',
                'spacing_unit' => '1rem',
                'container_max_width' => '1200px',
                'smooth_scroll' => true,
                'lazy_load' => true,
                'animations_enabled' => true,
                'show_back_to_top' => true,
                'background_pattern' => false,
                'card_shadow' => '0 4px 6px -1px rgba(0, 0, 0, 0.1)',
                'button_style' => 'rounded',
                'navigation_style' => 'horizontal',
                'footer_style' => 'dark'
            ],
            'typography' => [
                'font_family' => 'Cairo',
                'font_family_fallback' => 'sans-serif',
                'font_size_base' => '16px',
                'font_size_sm' => '14px',
                'font_size_md' => '16px',
                'font_size_lg' => '18px',
                'font_size_xl' => '20px',
                'font_size_2xl' => '24px',
                'font_size_3xl' => '30px',
                'font_size_4xl' => '36px',
                'font_size_5xl' => '48px',
                'font_weight_thin' => '100',
                'font_weight_light' => '300',
                'font_weight_normal' => '400',
                'font_weight_medium' => '500',
                'font_weight_semibold' => '600',
                'font_weight_bold' => '700',
                'font_weight_extrabold' => '800',
                'line_height_tight' => '1.25',
                'line_height_snug' => '1.375',
                'line_height_normal' => '1.5',
                'line_height_relaxed' => '1.625',
                'line_height_loose' => '2'
            ],
            'responsive_breakpoints' => [
                'xs' => '475px',
                'sm' => '640px',
                'md' => '768px',
                'lg' => '1024px',
                'xl' => '1280px',
                '2xl' => '1536px',
                '3xl' => '1920px'
            ]
        ]);

        // Modern Healthcare Theme
        $modernTheme = Theme::create([
            'name' => 'الثيم الطبي الحديث',
            'slug' => 'modern-healthcare',
            'description' => 'ثيم طبي حديث بتصميم عصري ومبتكر مع ألوان متدرجة ورسوم متحركة',
            'author' => 'فريق MiniMax',
            'version' => '1.1.0',
            'is_active' => false,
            'is_default' => false,
            'layout_type' => 'full-width',
            'color_scheme' => 'green',
            'settings' => [
                'primary_color' => '#10b981',
                'secondary_color' => '#059669',
                'accent_color' => '#3b82f6',
                'background_color' => '#ffffff',
                'surface_color' => '#f9fafb',
                'text_color' => '#111827',
                'success_color' => '#10b981',
                'warning_color' => '#f59e0b',
                'error_color' => '#ef4444',
                'info_color' => '#3b82f6',
                'border_radius' => '12px',
                'spacing_unit' => '1rem',
                'container_max_width' => '1400px',
                'smooth_scroll' => true,
                'lazy_load' => true,
                'animations_enabled' => true,
                'show_back_to_top' => true,
                'background_pattern' => true,
                'card_shadow' => '0 10px 25px -5px rgba(0, 0, 0, 0.1)',
                'button_style' => 'modern',
                'navigation_style' => 'minimal',
                'footer_style' => 'light'
            ],
            'typography' => [
                'font_family' => 'Inter',
                'font_family_fallback' => 'sans-serif',
                'font_size_base' => '16px',
                'font_size_sm' => '14px',
                'font_size_md' => '16px',
                'font_size_lg' => '18px',
                'font_size_xl' => '20px',
                'font_size_2xl' => '24px',
                'font_size_3xl' => '32px',
                'font_size_4xl' => '40px',
                'font_size_5xl' => '56px'
            ],
            'responsive_breakpoints' => [
                'xs' => '475px',
                'sm' => '640px',
                'md' => '768px',
                'lg' => '1024px',
                'xl' => '1280px',
                '2xl' => '1536px',
                '3xl' => '1920px'
            ],
            'custom_css' => '
                .hero-gradient {
                    background: linear-gradient(135deg, #10b981 0%, #3b82f6 100%);
                }
                
                .card-hover {
                    transition: all 0.3s ease;
                }
                
                .card-hover:hover {
                    transform: translateY(-8px);
                    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
                }
            '
        ]);

        // Premium Medical Theme
        $premiumTheme = Theme::create([
            'name' => 'الثيم الطبي المميز',
            'slug' => 'premium-medical',
            'description' => 'ثيم طبي فاخر مع تصميم راقي ومميزات متقدمة للعيادات المتميزة',
            'author' => 'فريق MiniMax',
            'version' => '2.0.0',
            'is_active' => false,
            'is_default' => false,
            'layout_type' => 'split',
            'color_scheme' => 'purple',
            'settings' => [
                'primary_color' => '#7c3aed',
                'secondary_color' => '#6d28d9',
                'accent_color' => '#fbbf24',
                'background_color' => '#ffffff',
                'surface_color' => '#fafafa',
                'text_color' => '#1f1f1f',
                'success_color' => '#10b981',
                'warning_color' => '#f59e0b',
                'error_color' => '#ef4444',
                'info_color' => '#06b6d4',
                'border_radius' => '16px',
                'spacing_unit' => '1.25rem',
                'container_max_width' => '1280px',
                'smooth_scroll' => true,
                'lazy_load' => true,
                'animations_enabled' => true,
                'show_back_to_top' => true,
                'background_pattern' => true,
                'card_shadow' => '0 25px 50px -12px rgba(0, 0, 0, 0.25)',
                'button_style' => 'luxury',
                'navigation_style' => 'elegant',
                'footer_style' => 'gradient'
            ],
            'custom_js' => '
                // Premium theme custom functionality
                document.addEventListener("DOMContentLoaded", function() {
                    // Add smooth parallax effects
                    const parallaxElements = document.querySelectorAll(".parallax");
                    
                    function handleParallax() {
                        parallaxElements.forEach(element => {
                            const speed = element.dataset.speed || 0.5;
                            const scrolled = window.pageYOffset;
                            const rate = scrolled * speed;
                            element.style.transform = "translateY(" + rate + "px)";
                        });
                    }
                    
                    window.addEventListener("scroll", handleParallax);
                    
                    // Premium animations
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                entry.target.classList.add("fade-in-up");
                            }
                        });
                    });
                    
                    document.querySelectorAll(".animate-on-scroll").forEach(el => {
                        observer.observe(el);
                    });
                });
            '
        ]);
    }

    /**
     * Create default page templates
     */
    private function createDefaultPageTemplates(): void
    {
        // Home Page Template
        $homeTemplate = PageTemplate::create([
            'name' => 'صفحة رئيسية طبية',
            'slug' => 'medical-home',
            'description' => 'قالب شامل للصفحة الرئيسية للعيادات الطبية',
            'category' => 'home',
            'content' => '
                <!-- Hero Section -->
                <section class="hero-section bg-gradient-to-r from-blue-600 to-blue-800 text-white py-20">
                    <div class="container mx-auto px-4">
                        <div class="text-center">
                            <h1 class="text-5xl font-bold mb-6">{{ $clinic_name }}</h1>
                            <p class="text-xl mb-8">{{ $tagline }}</p>
                            <div class="flex justify-center gap-4">
                                <a href="/booking" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100">احجز موعد</a>
                                <a href="/services" class="border border-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600">استكشف الخدمات</a>
                            </div>
                        </div>
                    </div>
                </section>
                
                <!-- Services Section -->
                <section class="services-section py-16 bg-gray-50">
                    <div class="container mx-auto px-4">
                        <h2 class="text-3xl font-bold text-center mb-12">خدماتنا</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            @foreach($services as $service)
                            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                                <h3 class="text-xl font-semibold mb-4">{{ $service->name }}</h3>
                                <p class="text-gray-600 mb-4">{{ $service->description }}</p>
                                <a href="/services/{{ $service->slug }}" class="text-blue-600 hover:underline">اعرف أكثر</a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            ',
            'is_active' => true,
            'is_premium' => false
        ]);

        // Contact Template
        $contactTemplate = PageTemplate::create([
            'name' => 'صفحة اتصل بنا',
            'slug' => 'contact-page',
            'description' => 'قالب احترافي لصفحة التواصل مع خريطة وبيانات الاتصال',
            'category' => 'contact',
            'content' => '
                <!-- Contact Hero -->
                <section class="bg-blue-600 text-white py-16">
                    <div class="container mx-auto px-4 text-center">
                        <h1 class="text-4xl font-bold mb-4">اتصل بنا</h1>
                        <p class="text-xl">نحن هنا لخدمتك</p>
                    </div>
                </section>
                
                <!-- Contact Form -->
                <section class="py-16">
                    <div class="container mx-auto px-4">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                            <div>
                                <h2 class="text-2xl font-bold mb-6">راسلنا</h2>
                                <form class="space-y-4">
                                    <input type="text" placeholder="الاسم" class="w-full p-3 border rounded-lg">
                                    <input type="email" placeholder="البريد الإلكتروني" class="w-full p-3 border rounded-lg">
                                    <textarea placeholder="رسالتك" rows="5" class="w-full p-3 border rounded-lg"></textarea>
                                    <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700">إرسال</button>
                                </form>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold mb-6">معلومات الاتصال</h2>
                                <div class="space-y-4">
                                    <div>
                                        <h3 class="font-semibold">العنوان</h3>
                                        <p>{{ $address }}</p>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold">الهاتف</h3>
                                        <p>{{ $phone }}</p>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold">البريد الإلكتروني</h3>
                                        <p>{{ $email }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            ',
            'is_active' => true,
            'is_premium' => false
        ]);

        // Services Template
        $servicesTemplate = PageTemplate::create([
            'name' => 'صفحة الخدمات',
            'slug' => 'services-page',
            'description' => 'قالب لعرض جميع خدمات العيادة بتفاصيل شاملة',
            'category' => 'services',
            'content' => '
                <!-- Services Hero -->
                <section class="bg-gradient-to-r from-green-600 to-green-800 text-white py-16">
                    <div class="container mx-auto px-4 text-center">
                        <h1 class="text-4xl font-bold mb-4">خدماتنا الطبية</h1>
                        <p class="text-xl">نقدم أفضل الخدمات الطبية بأعلى معايير الجودة</p>
                    </div>
                </section>
                
                <!-- Services Grid -->
                <section class="py-16">
                    <div class="container mx-auto px-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach($services as $service)
                            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:transform hover:scale-105 transition-transform">
                                <div class="p-6">
                                    <div class="text-green-600 text-4xl mb-4">
                                        <i class="fas fa-stethoscope"></i>
                                    </div>
                                    <h3 class="text-xl font-bold mb-4">{{ $service->name }}</h3>
                                    <p class="text-gray-600 mb-4">{{ Str::limit($service->description, 120) }}</p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-green-600 font-semibold">{{ $service->price }} ر.س</span>
                                        <a href="/services/{{ $service->slug }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">تفاصيل</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            ',
            'is_active' => true,
            'is_premium' => true
        ]);
    }

    /**
     * Create default page builder components
     */
    private function createDefaultPageBuilderComponents(): void
    {
        // Hero Section Component
        PageBuilderComponent::create([
            'name' => 'قسم رئيسي',
            'type' => 'layout',
            'category' => 'hero',
            'html_template' => '
                <section class="hero-section" style="background: {{ $background_image ? \'url(\' + $background_image + \')\' : \'linear-gradient(135deg, #667eea 0%, #764ba2 100%)\' }}; color: white; padding: 100px 0; text-align: center;">
                    <div class="container">
                        <h1 style="font-size: {{ $title_size ?? \'48px\' }}; font-weight: 700; margin-bottom: 16px;">{{ $title }}</h1>
                        <p style="font-size: {{ $subtitle_size ?? \'20px\' }}; margin-bottom: 32px; opacity: 0.9;">{{ $subtitle }}</p>
                        <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
                            <a href="{{ $primary_button_link ?? \'#\' }}" style="background: var(--theme-primary); color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 500;">{{ $primary_button_text ?? \'زر أساسي\' }}</a>
                            <a href="{{ $secondary_button_link ?? \'#\' }}" style="background: transparent; color: white; border: 2px solid white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 500;">{{ $secondary_button_text ?? \'زر ثانوي\' }}</a>
                        </div>
                    </div>
                </section>
            ',
            'css_styles' => '
                .hero-section {
                    position: relative;
                    overflow: hidden;
                }
                
                .hero-section::before {
                    content: "";
                    position: absolute;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background: rgba(0, 0, 0, 0.3);
                    z-index: 1;
                }
                
                .hero-section > * {
                    position: relative;
                    z-index: 2;
                }
            ',
            'settings' => [
                'title',
                'subtitle',
                'title_size',
                'subtitle_size',
                'primary_button_text',
                'primary_button_link',
                'secondary_button_text',
                'secondary_button_link',
                'background_image',
                'background_overlay',
                'text_alignment',
                'text_color'
            ],
            'is_reusable' => true
        ]);

        // Features Grid Component
        PageBuilderComponent::create([
            'name' => 'شبكة المميزات',
            'type' => 'content',
            'category' => 'features',
            'html_template' => '
                <section class="features-section py-16" style="background: {{ $background_color ?? \'#f8fafc\' }};">
                    <div class="container" style="max-width: {{ $container_max_width ?? \'1200px\' }}; margin: 0 auto; padding: 0 16px;">
                        <div style="text-align: center; margin-bottom: 48px;">
                            <h2 style="font-size: {{ $title_size ?? \'36px\' }}; font-weight: 700; margin-bottom: 16px; color: var(--theme-primary);">{{ $section_title }}</h2>
                            <p style="font-size: {{ $subtitle_size ?? \'18px\' }}; color: var(--theme-secondary); max-width: 600px; margin: 0 auto;">{{ $section_subtitle }}</p>
                        </div>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax({{ $card_min_width ?? \'300px\' }}, 1fr)); gap: {{ $card_gap ?? \'24px\' }};">
                            @foreach($features as $index => $feature)
                            <div style="background: white; padding: 32px; border-radius: 12px; box-shadow: var(--card-shadow); text-align: center; transition: all 0.3s ease;" class="feature-card">
                                <div style="width: 64px; height: 64px; background: var(--theme-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; color: white; font-size: 24px;">
                                    {{ $feature[\'icon\'] ?? \'★\' }}
                                </div>
                                <h3 style="font-size: {{ $card_title_size ?? \'20px\' }}; font-weight: 600; margin-bottom: 16px; color: var(--theme-text);">{{ $feature[\'title\'] }}</h3>
                                <p style="color: var(--theme-secondary); line-height: 1.6;">{{ $feature[\'description\'] }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            ',
            'css_styles' => '
                .feature-card:hover {
                    transform: translateY(-8px);
                    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
                }
            ',
            'settings' => [
                'section_title',
                'section_subtitle',
                'title_size',
                'subtitle_size',
                'card_title_size',
                'background_color',
                'container_max_width',
                'card_min_width',
                'card_gap',
                'card_alignment',
                'show_icons',
                'card_style'
            ],
            'is_reusable' => true
        ]);

        // Contact Form Component
        PageBuilderComponent::create([
            'name' => 'نموذج التواصل',
            'type' => 'form',
            'category' => 'forms',
            'html_template' => '
                <section class="contact-form-section py-16" style="background: {{ $background_color ?? \'#ffffff\' }};">
                    <div class="container" style="max-width: {{ $container_max_width ?? \'800px\' }}; margin: 0 auto; padding: 0 16px;">
                        <div style="text-align: center; margin-bottom: 48px;">
                            <h2 style="font-size: {{ $title_size ?? \'36px\' }}; font-weight: 700; margin-bottom: 16px; color: var(--theme-primary);">{{ $form_title }}</h2>
                            <p style="font-size: {{ $subtitle_size ?? \'18px\' }}; color: var(--theme-secondary);">{{ $form_subtitle }}</p>
                        </div>
                        
                        <form action="{{ $form_action ?? \'#\' }}" method="POST" style="background: var(--theme-surface); padding: 48px; border-radius: 16px; box-shadow: var(--card-shadow);" id="contact-form">
                            @csrf
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax({{ $input_min_width ?? \'250px\' }}, 1fr)); gap: {{ $input_gap ?? \'24px\' }};">
                                <div>
                                    <label style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--theme-text);">{{ $field_name_label ?? \'الاسم\' }}</label>
                                    <input type="text" name="name" required style="width: 100%; padding: 12px 16px; border: 2px solid rgba(0, 0, 0, 0.1); border-radius: 8px; font-size: 16px; transition: border-color 0.3s ease;" placeholder="{{ $field_name_placeholder ?? \'أدخل اسمك\' }}">
                                </div>
                                <div>
                                    <label style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--theme-text);">{{ $field_email_label ?? \'البريد الإلكتروني\' }}</label>
                                    <input type="email" name="email" required style="width: 100%; padding: 12px 16px; border: 2px solid rgba(0, 0, 0, 0.1); border-radius: 8px; font-size: 16px; transition: border-color 0.3s ease;" placeholder="{{ $field_email_placeholder ?? \'example@domain.com\' }}">
                                </div>
                                <div>
                                    <label style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--theme-text);">{{ $field_phone_label ?? \'الهاتف\' }}</label>
                                    <input type="tel" name="phone" style="width: 100%; padding: 12px 16px; border: 2px solid rgba(0, 0, 0, 0.1); border-radius: 8px; font-size: 16px; transition: border-color 0.3s ease;" placeholder="{{ $field_phone_placeholder ?? \'05xxxxxxxx\' }}">
                                </div>
                                <div>
                                    <label style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--theme-text);">{{ $field_subject_label ?? \'الموضوع\' }}</label>
                                    <select name="subject" style="width: 100%; padding: 12px 16px; border: 2px solid rgba(0, 0, 0, 0.1); border-radius: 8px; font-size: 16px; transition: border-color 0.3s ease;">
                                        <option value="">{{ $field_subject_placeholder ?? \'اختر الموضوع\' }}</option>
                                        <option value="consultation">{{ $option_consultation ?? \'استشارة طبية\' }}</option>
                                        <option value="appointment">{{ $option_appointment ?? \'حجز موعد\' }}</option>
                                        <option value="general">{{ $option_general ?? \'استفسار عام\' }}</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div style="margin-top: 24px;">
                                <label style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--theme-text);">{{ $field_message_label ?? \'الرسالة\' }}</label>
                                <textarea name="message" rows="4" style="width: 100%; padding: 12px 16px; border: 2px solid rgba(0, 0, 0, 0.1); border-radius: 8px; font-size: 16px; transition: border-color 0.3s ease; resize: vertical;" placeholder="{{ $field_message_placeholder ?? \'اكتب رسالتك هنا...\' }}"></textarea>
                            </div>
                            
                            <div style="text-align: center; margin-top: 32px;">
                                <button type="submit" style="background: var(--theme-primary); color: white; padding: 16px 32px; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);" onmouseover="this.style.transform=\'translateY(-2px)\';" onmouseout="this.style.transform=\'translateY(0)\';">
                                    {{ $submit_button_text ?? \'إرسال الرسالة\' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </section>
            ',
            'css_styles' => '
                .contact-form-section input:focus,
                .contact-form-section select:focus,
                .contact-form-section textarea:focus {
                    border-color: var(--theme-primary);
                    outline: none;
                    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
                }
            ',
            'settings' => [
                'form_title',
                'form_subtitle',
                'title_size',
                'subtitle_size',
                'background_color',
                'container_max_width',
                'input_min_width',
                'input_gap',
                'field_name_label',
                'field_name_placeholder',
                'field_email_label',
                'field_email_placeholder',
                'field_phone_label',
                'field_phone_placeholder',
                'field_subject_label',
                'field_subject_placeholder',
                'field_message_label',
                'field_message_placeholder',
                'option_consultation',
                'option_appointment',
                'option_general',
                'submit_button_text',
                'form_action',
                'show_labels',
                'input_style'
            ],
            'is_reusable' => true
        ]);

        // Testimonials Component
        PageBuilderComponent::create([
            'name' => 'آراء العملاء',
            'type' => 'content',
            'category' => 'testimonials',
            'html_template' => '
                <section class="testimonials-section py-16" style="background: {{ $background_color ?? \'#f8fafc\' }};">
                    <div class="container" style="max-width: {{ $container_max_width ?? \'1200px\' }}; margin: 0 auto; padding: 0 16px;">
                        <div style="text-align: center; margin-bottom: 48px;">
                            <h2 style="font-size: {{ $title_size ?? \'36px\' }}; font-weight: 700; margin-bottom: 16px; color: var(--theme-primary);">{{ $section_title }}</h2>
                            <p style="font-size: {{ $subtitle_size ?? \'18px\' }}; color: var(--theme-secondary); max-width: 600px; margin: 0 auto;">{{ $section_subtitle }}</p>
                        </div>
                        
                        <div style="position: relative;">
                            <div id="testimonials-carousel" style="display: grid; grid-template-columns: repeat(auto-fit, minmax({{ $card_min_width ?? \'350px\' }}, 1fr)); gap: {{ $card_gap ?? \'32px\' }}; transition: transform 0.5s ease;">
                                @foreach($testimonials as $index => $testimonial)
                                <div class="testimonial-card" style="background: white; padding: 32px; border-radius: 16px; box-shadow: var(--card-shadow); text-align: center; position: relative;" data-testimonial="{{ $index }}">
                                    <div style="font-size: 48px; color: var(--theme-accent); margin-bottom: 16px;">"</div>
                                    <p style="font-size: {{ $quote_size ?? \'16px\' }}; color: var(--theme-text); line-height: 1.6; margin-bottom: 24px; font-style: italic;">{{ $testimonial[\'quote\'] }}</p>
                                    <div style="display: flex; align-items: center; justify-content: center; gap: 16px;">
                                        <div style="width: 64px; height: 64px; border-radius: 50%; background: var(--theme-primary); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 20px;">
                                            {{ substr($testimonial[\'name\'], 0, 1) }}
                                        </div>
                                        <div style="text-align: left;">
                                            <h4 style="font-size: 18px; font-weight: 600; margin: 0; color: var(--theme-text);">{{ $testimonial[\'name\'] }}</h4>
                                            <p style="font-size: 14px; color: var(--theme-secondary); margin: 4px 0 0 0;">{{ $testimonial[\'position\'] ?? \'عميل\' }}</p>
                                        </div>
                                    </div>
                                    @if($show_rating)
                                    <div style="margin-top: 16px; display: flex; justify-content: center; gap: 4px;">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span style="color: {{ $i <= ($testimonial[\'rating\'] ?? 5) ? \'var(--theme-accent)\' : \'#e5e7eb\' }}; font-size: 18px;">★</span>
                                        @endfor
                                    </div>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                            
                            @if($show_navigation)
                            <div style="display: flex; justify-content: center; gap: 12px; margin-top: 24px;">
                                <button id="prev-testimonial" style="background: var(--theme-primary); color: white; border: none; width: 40px; height: 40px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center;">‹</button>
                                <button id="next-testimonial" style="background: var(--theme-primary); color: white; border: none; width: 40px; height: 40px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center;">›</button>
                            </div>
                            @endif
                            
                            @if($show_dots)
                            <div style="display: flex; justify-content: center; gap: 8px; margin-top: 16px;" id="testimonial-dots">
                                @foreach($testimonials as $index => $testimonial)
                                <button class="testimonial-dot" data-index="{{ $index }}" style="width: 12px; height: 12px; border-radius: 50%; border: none; background: {{ $index === 0 ? \'var(--theme-primary)\' : \'#e5e7eb\' }}; cursor: pointer;"></button>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                </section>
            ',
            'js_functionality' => '
                initTestimonialsCarousel();
            ',
            'settings' => [
                'section_title',
                'section_subtitle',
                'title_size',
                'subtitle_size',
                'quote_size',
                'background_color',
                'container_max_width',
                'card_min_width',
                'card_gap',
                'show_rating',
                'show_navigation',
                'show_dots',
                'autoplay',
                'autoplay_speed',
                'cards_per_view',
                'card_style'
            ],
            'is_reusable' => true
        ]);
    }
}