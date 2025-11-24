<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PageBuilderComponent extends Model
{
    use HasFactory;

    protected $table = 'page_builder_components';

    protected $fillable = [
        'name',
        'type',
        'category',
        'settings',
        'html_template',
        'css_styles',
        'js_functionality',
        'preview_image',
        'is_reusable',
        'is_active'
    ];

    protected $casts = [
        'settings' => 'array',
        'is_reusable' => 'boolean',
        'is_active' => 'boolean'
    ];

    protected $attributes = [
        'settings' => '{}'
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();
    }



    /**
     * Scope for active components
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for reusable components
     */
    public function scopeReusable($query)
    {
        return $query->where('is_reusable', true);
    }

    /**
     * Scope by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope by type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Get preview image URL
     */
    public function getPreviewImageUrlAttribute()
    {
        // Temporary implementation - can be enhanced with media library later
        return null;
    }

    /**
     * Get component types
     */
    public static function getComponentTypes()
    {
        return [
            'layout' => 'تخطيط',
            'content' => 'محتوى',
            'media' => 'وسائط',
            'form' => 'نموذج',
            'navigation' => 'تنقل',
            'interactive' => 'تفاعلي',
            'widget' => 'عنصر مساعد'
        ];
    }

    /**
     * Get categories
     */
    public static function getCategories()
    {
        return [
            'header' => 'رأس الصفحة',
            'hero' => 'القسم الرئيسي',
            'features' => 'المميزات',
            'services' => 'الخدمات',
            'about' => 'حولنا',
            'team' => 'الفريق',
            'testimonials' => 'آراء العملاء',
            'pricing' => 'الأسعار',
            'gallery' => 'المعرض',
            'blog' => 'المدونة',
            'contact' => 'معلومات التواصل',
            'footer' => 'التذييل',
            'forms' => 'النماذج',
            'cta' => 'دعوة للعمل',
            'stats' => 'الإحصائيات',
            'timeline' => 'الخط الزمني',
            'faq' => 'الأسئلة الشائعة',
            'maps' => 'الخريطة',
            'social' => 'وسائل التواصل'
        ];
    }

    /**
     * Get available default components
     */
    public static function getDefaultComponents()
    {
        return [
            [
                'name' => 'Hero Section',
                'type' => 'layout',
                'category' => 'hero',
                'html_template' => '<section class="hero-section"><h1>{{$title}}</h1><p>{{$subtitle}}</p><button>{{$button_text}}</button></section>',
                'css_styles' => '.hero-section { padding: 100px 0; text-align: center; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }',
                'settings' => ['title', 'subtitle', 'button_text', 'background_image', 'text_color'],
                'is_reusable' => true
            ],
            [
                'name' => 'Features Grid',
                'type' => 'content',
                'category' => 'features',
                'html_template' => '<div class="features-grid">{{$features}}</div>',
                'css_styles' => '.features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; }',
                'settings' => ['features', 'columns', 'background_color'],
                'is_reusable' => true
            ],
            [
                'name' => 'Testimonials Carousel',
                'type' => 'interactive',
                'category' => 'testimonials',
                'html_template' => '<div class="testimonials-carousel">{{$testimonials}}</div>',
                'css_styles' => '.testimonials-carousel { overflow: hidden; }',
                'js_functionality' => 'initCarousel()',
                'settings' => ['testimonials', 'autoplay', 'show_dots'],
                'is_reusable' => true
            ],
            [
                'name' => 'Contact Form',
                'type' => 'form',
                'category' => 'contact',
                'html_template' => '<form class="contact-form">{{$form_fields}}</form>',
                'css_styles' => '.contact-form { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }',
                'settings' => ['fields', 'submit_text', 'success_message'],
                'is_reusable' => true
            ],
            [
                'name' => 'Image Gallery',
                'type' => 'media',
                'category' => 'gallery',
                'html_template' => '<div class="image-gallery">{{$images}}</div>',
                'css_styles' => '.image-gallery { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; }',
                'settings' => ['images', 'columns', 'lightbox'],
                'is_reusable' => true
            ]
        ];
    }

    /**
     * Create component from array
     */
    public static function createFromArray($data)
    {
        return static::create([
            'name' => $data['name'],
            'type' => $data['type'],
            'category' => $data['category'],
            'html_template' => $data['html_template'] ?? '',
            'css_styles' => $data['css_styles'] ?? '',
            'js_functionality' => $data['js_functionality'] ?? '',
            'settings' => $data['settings'] ?? '{}',
            'is_reusable' => $data['is_reusable'] ?? true,
            'is_active' => true
        ]);
    }

    /**
     * Duplicate component
     */
    public function duplicate($newName)
    {
        $duplicate = $this->replicate();
        $duplicate->name = $newName;
        $duplicate->save();

        // Note: Media copying temporarily disabled until MediaLibrary is properly configured
        return $duplicate;
    }

    /**
     * Export component
     */
    public function export()
    {
        $data = [
            'name' => $this->name,
            'type' => $this->type,
            'category' => $this->category,
            'html_template' => $this->html_template,
            'css_styles' => $this->css_styles,
            'js_functionality' => $this->js_functionality,
            'settings' => $this->settings,
            'is_reusable' => $this->is_reusable
        ];

        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    /**
     * Import component from JSON
     */
    public static function importFromJson($jsonData, $name = null)
    {
        $data = is_string($jsonData) ? json_decode($jsonData, true) : $jsonData;
        
        $component = static::create([
            'name' => $name ?? $data['name'] ?? 'Untitled Component',
            'type' => $data['type'] ?? 'content',
            'category' => $data['category'] ?? 'general',
            'html_template' => $data['html_template'] ?? '',
            'css_styles' => $data['css_styles'] ?? '',
            'js_functionality' => $data['js_functionality'] ?? '',
            'settings' => $data['settings'] ?? '{}',
            'is_reusable' => $data['is_reusable'] ?? true,
            'is_active' => true
        ]);

        return $component;
    }

    /**
     * Render component with settings
     */
    public function renderWithSettings($settings = [])
    {
        $html = $this->html_template;
        $css = $this->css_styles;
        $js = $this->js_functionality;

        // Replace placeholders with actual values
        foreach ($settings as $key => $value) {
            $html = str_replace('{{$' . $key . '}}', $value, $html);
        }

        return [
            'html' => $html,
            'css' => $css,
            'js' => $js
        ];
    }
}