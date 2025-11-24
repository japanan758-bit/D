<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class PageTemplate extends Model
{
    use HasFactory, HasTranslations;

    protected $table = 'page_templates';

    public $translatable = [
        'name',
        'description',
        'content'
    ];

    protected $fillable = [
        'name',
        'slug',
        'description',
        'category',
        'content',
        'preview_image',
        'is_active',
        'is_premium',
        'settings',
        'custom_css',
        'custom_js',
        'seo_settings',
        'component_data'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_premium' => 'boolean',
        'settings' => 'array',
        'seo_settings' => 'array',
        'component_data' => 'array'
    ];

    protected $attributes = [
        'settings' => '{}',
        'seo_settings' => '{}',
        'component_data' => '{}'
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();
    }



    /**
     * Scope for active templates
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for free templates
     */
    public function scopeFree($query)
    {
        return $query->where('is_premium', false);
    }

    /**
     * Scope for premium templates
     */
    public function scopePremium($query)
    {
        return $query->where('is_premium', true);
    }

    /**
     * Scope by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
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
     * Generate slug from name
     */
    public static function generateSlug($name)
    {
        $slug = strtolower(trim($name));
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');
        
        // Ensure uniqueness
        $originalSlug = $slug;
        $counter = 1;
        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }

    /**
     * Get categories list
     */
    public static function getCategories()
    {
        return [
            'home' => 'الصفحة الرئيسية',
            'about' => 'حولنا',
            'services' => 'الخدمات',
            'contact' => 'اتصل بنا',
            'blog' => 'المدونة',
            'booking' => 'حجز المواعيد',
            'gallery' => 'معرض الصور',
            'testimonials' => 'آراء العملاء',
            'faq' => 'الأسئلة الشائعة',
            'landing' => 'صفحة الهبوط',
            'custom' => 'مخصصة'
        ];
    }

    /**
     * Get component types available
     */
    public static function getComponentTypes()
    {
        return [
            'hero' => 'القسم الرئيسي',
            'features' => 'المميزات',
            'services' => 'الخدمات',
            'testimonials' => 'آراء العملاء',
            'pricing' => 'الأسعار',
            'team' => 'الفريق',
            'gallery' => 'المعرض',
            'blog' => 'المدونة',
            'contact' => 'معلومات التواصل',
            'footer' => 'التذييل',
            'navbar' => 'شريط التنقل',
            'cta' => 'دعوة للعمل',
            'stats' => 'الإحصائيات',
            'timeline' => 'الخط الزمني',
            'faq' => 'الأسئلة الشائعة',
            'forms' => 'النماذج',
            'maps' => 'الخريطة',
            'social' => 'وسائل التواصل'
        ];
    }

    /**
     * Create template from content
     */
    public static function createFromContent($content, $name, $description = '', $category = 'custom')
    {
        return static::create([
            'name' => $name,
            'slug' => static::generateSlug($name),
            'description' => $description,
            'category' => $category,
            'content' => $content,
            'is_active' => true,
            'is_premium' => false
        ]);
    }

    /**
     * Duplicate template
     */
    public function duplicate($newName)
    {
        $duplicate = $this->replicate();
        $duplicate->name = $newName;
        $duplicate->slug = static::generateSlug($newName);
        $duplicate->save();

        // Note: Media copying temporarily disabled until MediaLibrary is properly configured
        return $duplicate;
    }

    /**
     * Export template
     */
    public function export()
    {
        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'category' => $this->category,
            'content' => $this->content,
            'settings' => $this->settings,
            'custom_css' => $this->custom_css,
            'custom_js' => $this->custom_js,
            'seo_settings' => $this->seo_settings,
            'component_data' => $this->component_data
        ];

        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    /**
     * Import template from JSON
     */
    public static function importFromJson($jsonData, $name = null)
    {
        $data = is_string($jsonData) ? json_decode($jsonData, true) : $jsonData;
        
        $template = static::create([
            'name' => $name ?? $data['name'] ?? 'Untitled Template',
            'slug' => static::generateSlug($name ?? $data['name'] ?? 'Untitled Template'),
            'description' => $data['description'] ?? '',
            'category' => $data['category'] ?? 'custom',
            'content' => $data['content'] ?? '',
            'settings' => $data['settings'] ?? '{}',
            'custom_css' => $data['custom_css'] ?? '',
            'custom_js' => $data['custom_js'] ?? '',
            'seo_settings' => $data['seo_settings'] ?? '{}',
            'component_data' => $data['component_data'] ?? '{}',
            'is_active' => true,
            'is_premium' => false
        ]);

        return $template;
    }

    /**
     * Get sample templates
     */
    public static function getSampleTemplates()
    {
        return [
            [
                'name' => 'صفحة رئيسية طبية',
                'description' => 'قالب للصفحة الرئيسية للعيادات الطبية',
                'category' => 'home',
                'is_premium' => false
            ],
            [
                'name' => 'صفحة خدمات شاملة',
                'description' => 'قالب لعرض خدمات العيادة بشكل تفاعلي',
                'category' => 'services',
                'is_premium' => false
            ],
            [
                'name' => 'صفحة حجز المواعيد',
                'description' => 'قالب متقدم لحجز المواعيد مع التفاعل',
                'category' => 'booking',
                'is_premium' => true
            ],
            [
                'name' => 'صفحة حولنا',
                'description' => 'قالب لعرض معلومات العيادة والطبيب',
                'category' => 'about',
                'is_premium' => false
            ]
        ];
    }
}