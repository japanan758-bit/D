<?php

namespace App\Filament\Resources\ThemeResource\Pages;

use App\Filament\Resources\ThemeResource;
use App\Models\Theme;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\File;

class CreateTheme extends CreateRecord
{
    protected static string $resource = ThemeResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Theme::generateSlug($data['name']);
        }
        
        // Set default settings if not provided
        if (empty($data['settings'])) {
            $data['settings'] = $this->getDefaultThemeSettings();
        }
        
        // Set default typography if not provided
        if (empty($data['typography'])) {
            $data['typography'] = $this->getDefaultTypography();
        }
        
        // Set default responsive breakpoints if not provided
        if (empty($data['responsive_breakpoints'])) {
            $data['responsive_breakpoints'] = $this->getDefaultBreakpoints();
        }
        
        return $data;
    }

    protected function afterCreate(): void
    {
        // Generate theme CSS and JS files
        $this->generateThemeFiles();
        
        // Clear application cache
        $this->clearApplicationCache();
        
        $this->dispatch('theme-created', theme: $this->record);
    }

    /**
     * Get default theme settings
     */
    private function getDefaultThemeSettings(): array
    {
        return [
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
        ];
    }

    /**
     * Get default typography settings
     */
    private function getDefaultTypography(): array
    {
        return [
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
            'line_height_loose' => '2',
            'letter_spacing_tight' => '-0.025em',
            'letter_spacing_normal' => '0',
            'letter_spacing_wide' => '0.025em',
            'letter_spacing_wider' => '0.05em',
            'letter_spacing_widest' => '0.1em'
        ];
    }

    /**
     * Get default responsive breakpoints
     */
    private function getDefaultBreakpoints(): array
    {
        return [
            'sm' => '640px',
            'md' => '768px',
            'lg' => '1024px',
            'xl' => '1280px',
            '2xl' => '1536px',
            'xs' => '475px',
            '3xl' => '1920px'
        ];
    }

    /**
     * Generate theme CSS and JS files
     */
    private function generateThemeFiles(): void
    {
        $theme = $this->record;
        $cssPath = public_path("themes/{$theme->slug}.css");
        $jsPath = public_path("themes/{$theme->slug}.js");
        
        // Ensure directory exists
        File::ensureDirectoryExists(dirname($cssPath));
        
        // Generate CSS
        $css = $this->generateThemeCSS($theme);
        File::put($cssPath, $css);
        
        // Generate JavaScript
        $js = $this->generateThemeJS($theme);
        File::put($jsPath, $js);
    }

    /**
     * Generate theme CSS
     */
    private function generateThemeCSS(Theme $theme): string
    {
        $settings = $theme->settings ?? [];
        $typography = $theme->typography ?? [];
        
        $css = "/* Theme: {$theme->name} */\n\n";
        
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
        $css .= "}\n\n";
        
        // Layout styles
        if ($theme->layout_type === 'boxed') {
            $css .= ".container {\n";
            $css .= "  max-width: var(--container-max-width);\n";
            $css .= "  margin: 0 auto;\n";
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
        $css .= "  transition: all 0.3s ease;\n";
        $css .= "}\n\n";
        
        $css .= ".btn-primary:hover {\n";
        $css .= "  background-color: color-mix(in srgb, var(--theme-primary) 90%, black 10%);\n";
        $css .= "  transform: translateY(-1px);\n";
        $css .= "  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);\n";
        $css .= "}\n\n";
        
        // Card styles
        $css .= ".card {\n";
        $css .= "  background-color: var(--theme-surface);\n";
        $css .= "  border-radius: var(--border-radius);\n";
        $css .= "  box-shadow: var(--card-shadow);\n";
        $css .= "  padding: calc(var(--spacing-unit) * 1.5);\n";
        $css .= "  margin-bottom: var(--spacing-unit);\n";
        $css .= "}\n\n";
        
        // Animation styles
        if ($settings['animations_enabled'] ?? true) {
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
        
        // Navigation styles
        $css .= ".navbar {\n";
        $css .= "  background-color: var(--theme-surface);\n";
        $css .= "  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);\n";
        $css .= "  padding: var(--spacing-unit) 0;\n";
        $css .= "}\n\n";
        
        // Footer styles
        if (($settings['footer_style'] ?? 'dark') === 'dark') {
            $css .= ".footer {\n";
            $css .= "  background-color: color-mix(in srgb, var(--theme-background) 80%, black 20%);\n";
            $css .= "  color: white;\n";
            $css .= "  padding: calc(var(--spacing-unit) * 2) 0;\n";
            $css .= "}\n\n";
        }
        
        // Back to top button
        if ($settings['show_back_to_top'] ?? true) {
            $css .= ".back-to-top {\n";
            $css .= "  position: fixed;\n";
            $css .= "  bottom: 20px;\n";
            $css .= "  right: 20px;\n";
            $css .= "  background-color: var(--theme-primary);\n";
            $css .= "  color: white;\n";
            $css .= "  width: 50px;\n";
            $css .= "  height: 50px;\n";
            $css .= "  border-radius: 50%;\n";
            $css .= "  border: none;\n";
            $css .= "  cursor: pointer;\n";
            $css .= "  opacity: 0;\n";
            $css .= "  visibility: hidden;\n";
            $css .= "  transition: all 0.3s ease;\n";
            $css .= "  z-index: 1000;\n";
            $css .= "}\n\n";
            
            $css .= ".back-to-top.visible {\n";
            $css .= "  opacity: 1;\n";
            $css .= "  visibility: visible;\n";
            $css .= "}\n\n";
        }
        
        // Custom CSS from theme
        if ($theme->custom_css) {
            $css .= "\n/* Custom CSS */\n";
            $css .= $theme->custom_css;
        }
        
        return $css;
    }

    /**
     * Generate theme JavaScript
     */
    private function generateThemeJS(Theme $theme): string
    {
        $settings = $theme->settings ?? [];
        
        $js = "// Theme: {$theme->name}\n\n";
        
        // Theme initialization
        $js .= "document.addEventListener('DOMContentLoaded', function() {\n";
        $js .= "  initTheme();\n";
        
        if ($settings['animations_enabled'] ?? true) {
            $js .= "  initAnimations();\n";
        }
        
        if ($settings['smooth_scroll'] ?? true) {
            $js .= "  initSmoothScroll();\n";
        }
        
        if ($settings['lazy_load'] ?? true) {
            $js .= "  initLazyLoading();\n";
        }
        
        if ($settings['show_back_to_top'] ?? true) {
            $js .= "  initBackToTop();\n";
        }
        
        $js .= "});\n\n";
        
        // Theme initialization function
        $js .= "function initTheme() {\n";
        $js .= "  console.log('Theme initialized: {$theme->name}');\n";
        $js .= "  \n";
        $js .= "  // Add theme class to body\n";
        $js .= "  document.body.classList.add('theme-{$theme->slug}');\n";
        $js .= "  \n";
        $js .= "  // Initialize theme-specific functionality\n";
        $js .= "  initializeThemeFeatures();\n";
        $js .= "}\n\n";
        
        // Theme features function
        $js .= "function initializeThemeFeatures() {\n";
        
        if ($theme->layout_type === 'boxed') {
            $js .= "  // Apply boxed layout\n";
            $js .= "  const container = document.querySelector('.container') || document.body;\n";
            $js .= "  container.classList.add('theme-boxed');\n";
        }
        
        if ($settings['animations_enabled'] ?? true) {
            $js .= "  // Enable animations\n";
            $js .= "  document.body.classList.add('animations-enabled');\n";
        }
        
        if ($settings['background_pattern'] ?? false) {
            $js .= "  // Apply background pattern\n";
            $js .= "  document.body.classList.add('background-pattern');\n";
        }
        
        $js .= "}\n\n";
        
        // Animation initialization
        if ($settings['animations_enabled'] ?? true) {
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
        if ($settings['smooth_scroll'] ?? true) {
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
        
        // Lazy loading initialization
        if ($settings['lazy_load'] ?? true) {
            $js .= "function initLazyLoading() {\n";
            $js .= "  const images = document.querySelectorAll('img[data-src]');\n";
            $js .= "  const imageObserver = new IntersectionObserver((entries, observer) => {\n";
            $js .= "    entries.forEach(entry => {\n";
            $js .= "      if (entry.isIntersecting) {\n";
            $js .= "        const img = entry.target;\n";
            $js .= "        img.src = img.dataset.src;\n";
            $js .= "        img.classList.remove('lazy');\n";
            $js .= "        img.classList.add('loaded');\n";
            $js .= "        imageObserver.unobserve(img);\n";
            $js .= "      }\n";
            $js .= "    });\n";
            $js .= "  });\n\n";
            $js .= "  images.forEach(img => imageObserver.observe(img));\n";
            $js .= "}\n\n";
        }
        
        // Back to top initialization
        if ($settings['show_back_to_top'] ?? true) {
            $js .= "function initBackToTop() {\n";
            $js .= "  // Create back to top button\n";
            $js .= "  const button = document.createElement('button');\n";
            $js .= "  button.innerHTML = '↑';\n";
            $js .= "  button.className = 'back-to-top';\n";
            $js .= "  document.body.appendChild(button);\n\n";
            $js .= "  // Show/hide button based on scroll position\n";
            $js .= "  window.addEventListener('scroll', function() {\n";
            $js .= "    if (window.pageYOffset > 300) {\n";
            $js .= "      button.classList.add('visible');\n";
            $js .= "    } else {\n";
            $js .= "      button.classList.remove('visible');\n";
            $js .= "    }\n";
            $js .= "  });\n\n";
            $js .= "  // Scroll to top on click\n";
            $js .= "  button.addEventListener('click', function() {\n";
            $js .= "    window.scrollTo({\n";
            $js .= "      top: 0,\n";
            $js .= "      behavior: 'smooth'\n";
            $js .= "    });\n";
            $js .= "  });\n";
            $js .= "}\n\n";
        }
        
        // Custom JS from theme
        if ($theme->custom_js) {
            $js .= "\n// Custom JavaScript\n";
            $js .= $theme->custom_js;
        }
        
        return $js;
    }

    /**
     * Clear application cache
     */
    private function clearApplicationCache(): void
    {
        try {
            cache()->forget('current_theme');
            cache()->forget('theme_settings');
            cache()->forget('custom_css');
            cache()->forget('custom_js');
        } catch (\Exception $e) {
            // Handle cache clearing errors silently
        }
    }
}