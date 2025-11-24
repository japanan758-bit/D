<?php

namespace App\Filament\Resources\ThemeResource\Pages;

use App\Filament\Resources\ThemeResource;
use App\Models\Theme;
use Filament\Resources\Pages\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Response;

class PreviewTheme extends Page
{
    public Theme $record;
    
    protected static string $resource = ThemeResource::class;

    protected static string $view = 'filament.resources.theme-resource.pages.preview-theme';

    protected static bool $shouldRegisterNavigation = false;

    public function mount(Request $request): void
    {
        $themeId = $request->route('record');
        $this->record = Theme::findOrFail($themeId);
    }

    /**
     * Get page title
     */
    public function getTitle(): string
    {
        return 'معاينة الثيم: ' . $this->record->name;
    }

    /**
     * Get theme CSS
     */
    public function getThemeCSS(): string
    {
        $cssPath = public_path("themes/{$this->record->slug}.css");
        
        if (File::exists($cssPath)) {
            return File::get($cssPath);
        }
        
        // Generate CSS on the fly if file doesn't exist
        return $this->generatePreviewCSS();
    }

    /**
     * Get theme JavaScript
     */
    public function getThemeJS(): string
    {
        $jsPath = public_path("themes/{$this->record->slug}.js");
        
        if (File::exists($jsPath)) {
            return File::get($jsPath);
        }
        
        // Generate JS on the fly if file doesn't exist
        return $this->generatePreviewJS();
    }

    /**
     * Generate preview CSS
     */
    private function generatePreviewCSS(): string
    {
        $settings = $this->record->settings ?? [];
        $typography = $this->record->typography ?? [];
        
        $css = "/* Preview Theme: {$this->record->name} */\n\n";
        
        // CSS Variables
        $css .= ":root {\n";
        $css .= "  --theme-primary: " . ($settings['primary_color'] ?? '#3b82f6') . ";\n";
        $css .= "  --theme-secondary: " . ($settings['secondary_color'] ?? '#64748b') . ";\n";
        $css .= "  --theme-accent: " . ($settings['accent_color'] ?? '#10b981') . ";\n";
        $css .= "  --theme-background: " . ($settings['background_color'] ?? '#ffffff') . ";\n";
        $css .= "  --theme-surface: " . ($settings['surface_color'] ?? '#f8fafc') . ";\n";
        $css .= "  --theme-text: " . ($settings['text_color'] ?? '#1f2937') . ";\n";
        $css .= "  --theme-success: " . ($settings['success_color'] ?? '#22c55e') . ";\n";
        $css .= "  --theme-warning: " . ($settings['warning_color'] ?? '#f59e0b') . ";\n";
        $css .= "  --theme-error: " . ($settings['error_color'] ?? '#ef4444') . ";\n";
        $css .= "  --theme-info: " . ($settings['info_color'] ?? '#06b6d4') . ";\n";
        
        // Typography
        $css .= "  --font-family: " . ($typography['font_family'] ?? 'Cairo') . ", " . ($typography['font_family_fallback'] ?? 'sans-serif') . ";\n";
        $css .= "  --font-size-base: " . ($typography['font_size_base'] ?? '16px') . ";\n";
        $css .= "  --line-height: " . ($typography['line_height_normal'] ?? '1.5') . ";\n";
        
        // Spacing
        $css .= "  --spacing-unit: " . ($settings['spacing_unit'] ?? '1rem') . ";\n";
        $css .= "  --container-max-width: " . ($settings['container_max_width'] ?? '1200px') . ";\n";
        
        // Border radius
        $css .= "  --border-radius: " . ($settings['border_radius'] ?? '8px') . ";\n";
        
        // Shadows
        $css .= "  --card-shadow: " . ($settings['card_shadow'] ?? '0 4px 6px -1px rgba(0, 0, 0, 0.1)') . ";\n";
        
        $css .= "}\n\n";
        
        // Base styles
        $css .= "body {\n";
        $css .= "  font-family: var(--font-family);\n";
        $css .= "  font-size: var(--font-size-base);\n";
        $css .= "  line-height: var(--line-height);\n";
        $css .= "  color: var(--theme-text);\n";
        $css .= "  background-color: var(--theme-background);\n";
        $css .= "  margin: 0;\n";
        $css .= "  padding: 0;\n";
        $css .= "}\n\n";
        
        // Navigation styles
        $css .= ".navbar {\n";
        $css .= "  background-color: var(--theme-surface);\n";
        $css .= "  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);\n";
        $css .= "  padding: var(--spacing-unit) 0;\n";
        $css .= "  margin-bottom: var(--spacing-unit);\n";
        $css .= "}\n\n";
        
        // Layout styles
        if ($this->record->layout_type === 'boxed') {
            $css .= ".container {\n";
            $css .= "  max-width: var(--container-max-width);\n";
            $css .= "  margin: 0 auto;\n";
            $css .= "  padding: 0 var(--spacing-unit);\n";
            $css .= "}\n\n";
        } else {
            $css .= ".container {\n";
            $css .= "  padding: 0 var(--spacing-unit);\n";
            $css .= "}\n\n";
        }
        
        // Button styles
        $css .= ".btn-primary {\n";
        $css .= "  background-color: var(--theme-primary);\n";
        $css .= "  color: white;\n";
        $css .= "  padding: calc(var(--spacing-unit) * 0.75) calc(var(--spacing-unit) * 1.5);\n";
        $css .= "  border-radius: var(--border-radius);\n";
        $css .= "  border: none;\n";
        $css .= "  cursor: pointer;\n";
        $css .= "  font-weight: 500;\n";
        $css .= "  text-decoration: none;\n";
        $css .= "  display: inline-block;\n";
        $css .= "  transition: all 0.3s ease;\n";
        $css .= "}\n\n";
        
        $css .= ".btn-primary:hover {\n";
        $css .= "  background-color: color-mix(in srgb, var(--theme-primary) 90%, black 10%);\n";
        $css .= "  transform: translateY(-1px);\n";
        $css .= "  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);\n";
        $css .= "  color: white;\n";
        $css .= "}\n\n";
        
        // Secondary button
        $css .= ".btn-secondary {\n";
        $css .= "  background-color: var(--theme-secondary);\n";
        $css .= "  color: white;\n";
        $css .= "  padding: calc(var(--spacing-unit) * 0.75) calc(var(--spacing-unit) * 1.5);\n";
        $css .= "  border-radius: var(--border-radius);\n";
        $css .= "  border: none;\n";
        $css .= "  cursor: pointer;\n";
        $css .= "  text-decoration: none;\n";
        $css .= "  display: inline-block;\n";
        $css .= "  transition: all 0.3s ease;\n";
        $css .= "}\n\n";
        
        // Card styles
        $css .= ".card {\n";
        $css .= "  background-color: var(--theme-surface);\n";
        $css .= "  border-radius: var(--border-radius);\n";
        $css .= "  box-shadow: var(--card-shadow);\n";
        $css .= "  padding: calc(var(--spacing-unit) * 1.5);\n";
        $css .= "  margin-bottom: var(--spacing-unit);\n";
        $css .= "}\n\n";
        
        // Hero section
        $css .= ".hero {\n";
        $css .= "  background: linear-gradient(135deg, var(--theme-primary) 0%, var(--theme-accent) 100%);\n";
        $css .= "  color: white;\n";
        $css .= "  padding: calc(var(--spacing-unit) * 4) 0;\n";
        $css .= "  text-align: center;\n";
        $css .= "  margin-bottom: calc(var(--spacing-unit) * 2);\n";
        $css .= "}\n\n";
        
        $css .= ".hero h1 {\n";
        $css .= "  font-size: calc(var(--spacing-unit) * 3);\n";
        $css .= "  margin-bottom: var(--spacing-unit);\n";
        $css .= "  font-weight: 700;\n";
        $css .= "}\n\n";
        
        $css .= ".hero p {\n";
        $css .= "  font-size: calc(var(--spacing-unit) * 1.5);\n";
        $css .= "  margin-bottom: calc(var(--spacing-unit) * 2);\n";
        $css .= "}\n\n";
        
        // Grid layouts
        $css .= ".grid {\n";
        $css .= "  display: grid;\n";
        $css .= "  gap: var(--spacing-unit);\n";
        $css .= "  margin-bottom: calc(var(--spacing-unit) * 2);\n";
        $css .= "}\n\n";
        
        $css .= ".grid-2 {\n";
        $css .= "  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));\n";
        $css .= "}\n\n";
        
        $css .= ".grid-3 {\n";
        $css .= "  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));\n";
        $css .= "}\n\n";
        
        // Animation styles
        if (($settings['animations_enabled'] ?? true)) {
            $css .= ".animate-on-scroll {\n";
            $css .= "  opacity: 0;\n";
            $css .= "  transform: translateY(20px);\n";
            $css .= "  transition: all 0.6s ease;\n";
            $css .= "}\n\n";
            
            $css .= ".animate-on-scroll.animate-in {\n";
            $css .= "  opacity: 1;\n";
            $css .= "  transform: translateY(0);\n";
            $css .= "}\n\n";
        }
        
        // Footer styles
        $css .= ".footer {\n";
        $css .= "  background-color: color-mix(in srgb, var(--theme-background) 80%, black 20%);\n";
        $css .= "  color: white;\n";
        $css .= "  padding: calc(var(--spacing-unit) * 2) 0;\n";
        $css .= "  text-align: center;\n";
        $css .= "  margin-top: calc(var(--spacing-unit) * 4);\n";
        $css .= "}\n\n";
        
        // Utilities
        $css .= ".text-center { text-align: center; }\n";
        $css .= ".mb-1 { margin-bottom: var(--spacing-unit); }\n";
        $css .= ".mb-2 { margin-bottom: calc(var(--spacing-unit) * 2); }\n";
        $css .= ".mb-3 { margin-bottom: calc(var(--spacing-unit) * 3); }\n";
        $css .= ".mt-1 { margin-top: var(--spacing-unit); }\n";
        $css .= ".mt-2 { margin-top: calc(var(--spacing-unit) * 2); }\n";
        $css .= ".mt-3 { margin-top: calc(var(--spacing-unit) * 3); }\n";
        
        // Responsive
        $css .= "@media (max-width: 768px) {\n";
        $css .= "  .hero h1 { font-size: calc(var(--spacing-unit) * 2); }\n";
        $css .= "  .hero p { font-size: var(--spacing-unit); }\n";
        $css .= "  .container { padding: 0 calc(var(--spacing-unit) * 0.5); }\n";
        $css .= "}\n\n";
        
        // Custom CSS from theme
        if ($this->record->custom_css) {
            $css .= "\n/* Custom CSS */\n";
            $css .= $this->record->custom_css;
        }
        
        return $css;
    }

    /**
     * Generate preview JavaScript
     */
    private function generatePreviewJS(): string
    {
        $settings = $this->record->settings ?? [];
        
        $js = "// Preview Theme: {$this->record->name}\n\n";
        
        // Theme initialization
        $js .= "document.addEventListener('DOMContentLoaded', function() {\n";
        $js .= "  initPreviewTheme();\n";
        
        if (($settings['animations_enabled'] ?? true)) {
            $js .= "  initAnimations();\n";
        }
        
        if (($settings['smooth_scroll'] ?? true)) {
            $js .= "  initSmoothScroll();\n";
        }
        
        $js .= "});\n\n";
        
        // Theme initialization function
        $js .= "function initPreviewTheme() {\n";
        $js .= "  console.log('Preview theme initialized: {$this->record->name}');\n";
        $js .= "  \n";
        $js .= "  // Add theme class to body\n";
        $js .= "  document.body.classList.add('theme-{$this->record->slug}');\n";
        $js .= "  \n";
        $js .= "  // Initialize theme preview\n";
        $js .= "  initializePreview();\n";
        $js .= "}\n\n";
        
        // Initialize preview function
        $js .= "function initializePreview() {\n";
        
        if ($this->record->layout_type === 'boxed') {
            $js .= "  // Apply boxed layout preview\n";
            $js .= "  document.body.classList.add('boxed-layout-preview');\n";
        }
        
        if (($settings['animations_enabled'] ?? true)) {
            $js .= "  // Enable animation preview\n";
            $js .= "  document.body.classList.add('animations-enabled');\n";
        }
        
        $js .= "}\n\n";
        
        // Animation initialization
        if (($settings['animations_enabled'] ?? true)) {
            $js .= "function initAnimations() {\n";
            $js .= "  const observerOptions = {\n";
            $js .= "    threshold: 0.1,\n";
            $js .= "    rootMargin: '0px 0px -50px 0px'\n";
            $js .= "  };\n\n";
            $js .= "  const observer = new IntersectionObserver(function(entries) {\n";
            $js .= "    entries.forEach(entry => {\n";
            $js .= "      if (entry.isIntersecting) {\n";
            $js .= "        entry.target.classList.add('animate-in');\n";
            $js .= "      }\n";
            $js .= "    });\n";
            $js .= "  }, observerOptions);\n\n";
            $js .= "  document.querySelectorAll('.animate-on-scroll').forEach(el => {\n";
            $js .= "    observer.observe(el);\n";
            $js .= "  });\n";
            $js .= "}\n\n";
        }
        
        // Smooth scroll initialization
        if (($settings['smooth_scroll'] ?? true)) {
            $js .= "function initSmoothScroll() {\n";
            $js .= "  document.querySelectorAll('a[href^=\"#\"]').forEach(anchor => {\n";
            $js .= "    anchor.addEventListener('click', function (e) {\n";
            $js .= "      e.preventDefault();\n";
            $js .= "      const target = document.querySelector(this.getAttribute('href'));\n";
            $js .= "      if (target) {\n";
            $js .= "        target.scrollIntoView({\n";
            $js .= "          behavior: 'smooth',\n";
            $js .= "          block: 'start'\n";
            $js .= "        });\n";
            $js .= "      }\n";
            $js .= "    });\n";
            $js .= "  });\n";
            $js .= "}\n\n";
        }
        
        // Demo interactive features
        $js .= "// Demo interactive features\n";
        $js .= "function demoInteractive() {\n";
        $js .= "  // Toggle demo modal\n";
        $js .= "  const modalButtons = document.querySelectorAll('[data-demo=\"modal\"]');\n";
        $js .= "  modalButtons.forEach(button => {\n";
        $js .= "    button.addEventListener('click', function() {\n";
        $js .= "      const modal = document.getElementById('demo-modal');\n";
        $js .= "      modal.style.display = modal.style.display === 'none' ? 'block' : 'none';\n";
        $js .= "    });\n";
        $js .= "  });\n";
        $js .= "  \n";
        $js .= "  // Toggle demo navigation\n";
        $js .= "  const navToggle = document.querySelector('[data-demo=\"nav-toggle\"]');\n";
        $js .= "  if (navToggle) {\n";
        $js .= "    navToggle.addEventListener('click', function() {\n";
        $js .= "      const nav = document.querySelector('.demo-nav');\n";
        $js .= "      nav.classList.toggle('open');\n";
        $js .= "    });\n";
        $js .= "  }\n";
        $js .= "}\n\n";
        
        $js .= "// Initialize demo features\n";
        $js .= "document.addEventListener('DOMContentLoaded', demoInteractive);\n\n";
        
        // Custom JS from theme
        if ($this->record->custom_js) {
            $js .= "\n// Custom JavaScript\n";
            $js .= $this->record->custom_js;
        }
        
        return $js;
    }

    /**
     * Get theme description
     */
    public function getThemeDescription(): string
    {
        return $this->record->description ?? 'لا يوجد وصف متاح';
    }

    /**
     * Get theme author
     */
    public function getThemeAuthor(): string
    {
        return $this->record->author ?? 'غير محدد';
    }

    /**
     * Get theme version
     */
    public function getThemeVersion(): string
    {
        return $this->record->version ?? '1.0.0';
    }

    /**
     * Get layout type display name
     */
    public function getLayoutTypeDisplay(): string
    {
        return match ($this->record->layout_type) {
            'full-width' => 'عرض كامل',
            'boxed' => 'صندوق',
            'split' => 'مقسم',
            default => $this->record->layout_type ?? 'افتراضي'
        };
    }

    /**
     * Get color scheme display name
     */
    public function getColorSchemeDisplay(): string
    {
        return match ($this->record->color_scheme) {
            'blue' => 'أزرق',
            'green' => 'أخضر',
            'purple' => 'بنفسجي',
            'red' => 'أحمر',
            'custom' => 'مخصص',
            default => $this->record->color_scheme ?? 'افتراضي'
        };
    }
}