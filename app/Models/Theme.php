<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class Theme extends Model
{
    use HasFactory, HasTranslations;

    protected $table = 'themes';

    public $translatable = [
        'name',
        'description',
        'author'
    ];

    protected $fillable = [
        'name',
        'slug',
        'description',
        'author',
        'version',
        'is_active',
        'is_default',
        'custom_css',
        'custom_js',
        'settings',
        'preview_image',
        'layout_type',
        'color_scheme',
        'typography',
        'animations_enabled',
        'responsive_breakpoints'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'settings' => 'array',
        'typography' => 'array',
        'responsive_breakpoints' => 'array',
        'animations_enabled' => 'boolean'
    ];

    protected $attributes = [
        'settings' => '{}',
        'typography' => '{}',
        'responsive_breakpoints' => '{}',
        'animations_enabled' => true
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($theme) {
            // Ensure only one theme is default
            if ($theme->is_default) {
                static::where('id', '!=', $theme->id)->update(['is_default' => false]);
            }
        });
    }



    /**
     * Scope for active themes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for default theme
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    /**
     * Get the default theme
     */
    public static function getDefaultTheme()
    {
        return static::default()->active()->first();
    }

    /**
     * Set as default theme
     */
    public function setAsDefault()
    {
        $this->update(['is_default' => true]);
        static::where('id', '!=', $this->id)->update(['is_default' => false]);
    }

    /**
     * Activate theme
     */
    public function activate()
    {
        $this->update(['is_active' => true]);
    }

    /**
     * Deactivate theme
     */
    public function deactivate()
    {
        // Don't allow deactivating the default theme
        if ($this->is_default) {
            throw new \Exception('لا يمكن إلغاء تفعيل الثيم الافتراضي');
        }
        $this->update(['is_active' => false]);
    }

    /**
     * Get preview image URL
     */
    public function getPreviewImageUrlAttribute()
    {
        return $this->getFirstMediaUrl('preview_image');
    }

    /**
     * Get background image URL
     */
    public function getBackgroundImageUrlAttribute()
    {
        return $this->getFirstMediaUrl('background_image');
    }

    /**
     * Get theme CSS
     */
    public function getThemeCssAttribute()
    {
        return $this->custom_css ?? '';
    }

    /**
     * Get theme JavaScript
     */
    public function getThemeJsAttribute()
    {
        return $this->custom_js ?? '';
    }

    /**
     * Get theme settings as array
     */
    public function getThemeSettingsAttribute()
    {
        return is_string($this->settings) ? json_decode($this->settings, true) : $this->settings;
    }

    /**
     * Get typography settings as array
     */
    public function getThemeTypographyAttribute()
    {
        return is_string($this->typography) ? json_decode($this->typography, true) : $this->typography;
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
     * Create theme from array settings
     */
    public static function createFromSettings($settings, $name, $description = '')
    {
        $theme = static::create([
            'name' => $name,
            'slug' => static::generateSlug($name),
            'description' => $description,
            'settings' => $settings,
            'is_active' => false,
            'is_default' => false
        ]);

        return $theme;
    }

    /**
     * Duplicate theme
     */
    public function duplicate($newName)
    {
        $duplicate = $this->replicate();
        $duplicate->name = $newName;
        $duplicate->slug = static::generateSlug($newName);
        $duplicate->is_active = false;
        $duplicate->is_default = false;
        $duplicate->save();

        // Copy media files
        foreach ($this->getMedia() as $media) {
            $duplicate->addMedia($media->getPath())->toMediaCollection($media->collection_name);
        }

        return $duplicate;
    }

    /**
     * Export theme settings
     */
    public function export()
    {
        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'version' => $this->version,
            'settings' => $this->settings,
            'custom_css' => $this->custom_css,
            'custom_js' => $this->custom_js,
            'color_scheme' => $this->color_scheme,
            'typography' => $this->typography,
            'layout_type' => $this->layout_type,
            'animations_enabled' => $this->animations_enabled,
            'responsive_breakpoints' => $this->responsive_breakpoints
        ];

        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    /**
     * Import theme from JSON
     */
    public static function importFromJson($jsonData, $name = null)
    {
        $data = is_string($jsonData) ? json_decode($jsonData, true) : $jsonData;
        
        $theme = static::create([
            'name' => $name ?? $data['name'] ?? 'Untitled Theme',
            'slug' => static::generateSlug($name ?? $data['name'] ?? 'Untitled Theme'),
            'description' => $data['description'] ?? '',
            'version' => $data['version'] ?? '1.0.0',
            'settings' => $data['settings'] ?? '{}',
            'custom_css' => $data['custom_css'] ?? '',
            'custom_js' => $data['custom_js'] ?? '',
            'color_scheme' => $data['color_scheme'] ?? 'default',
            'typography' => $data['typography'] ?? '{}',
            'layout_type' => $data['layout_type'] ?? 'default',
            'animations_enabled' => $data['animations_enabled'] ?? true,
            'responsive_breakpoints' => $data['responsive_breakpoints'] ?? '{}',
            'is_active' => false,
            'is_default' => false
        ]);

        return $theme;
    }
}