<?php

namespace App\Filament\Resources\ThemeResource\Pages;

use App\Filament\Resources\ThemeResource;
use App\Models\Theme;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\File;

class EditTheme extends EditRecord
{
    protected static string $resource = ThemeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('preview')
                ->label('معاينة الثيم')
                ->icon('heroicon-m-eye')
                ->color('info')
                ->url(fn (): string => route('theme.preview', $this->record))
                ->openUrlInNewTab(),
            
            Actions\Action::make('builder')
                ->label('محرر الثيم')
                ->icon('heroicon-m-paint-brush')
                ->color('warning')
                ->url(fn (): string => route('theme.builder', $this->record)),
            
            Actions\DeleteAction::make()
                ->label('حذف الثيم')
                ->visible(fn (): bool => !$this->record->is_default)
                ->requiresConfirmation()
                ->modalHeading('حذف الثيم')
                ->modalDescription('هل أنت متأكد من حذف هذا الثيم؟ لا يمكن التراجع عن هذا الإجراء.'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Ensure only one default theme
        if ($data['is_default'] ?? false) {
            Theme::where('id', '!=', $data['id'])->update(['is_default' => false]);
        }
        
        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Theme::generateSlug($data['name']);
        }
        
        // Apply theme if activated
        if (($data['is_active'] ?? false) && !$this->record->is_active) {
            // Deactivate other themes first
            Theme::where('id', '!=', $data['id'])->update(['is_active' => false]);
            
            // Generate theme CSS file
            $this->generateThemeFile($data);
        }
        
        return $data;
    }

    protected function afterSave(): void
    {
        // Generate theme CSS and JS files
        $this->generateThemeFiles();
        
        // Clear application cache
        $this->clearApplicationCache();
        
        $this->dispatch('theme-updated', theme: $this->record);
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
        $css = "/* Theme: {$theme->name} */\n\n";
        
        // Base styles
        $css .= ":root {\n";
        $css .= "  --theme-primary: {$theme->getSetting('primary_color', '#3b82f6')};\n";
        $css .= "  --theme-secondary: {$theme->getSetting('secondary_color', '#64748b')};\n";
        $css .= "  --theme-accent: {$theme->getSetting('accent_color', '#10b981')};\n";
        $css .= "  --theme-background: {$theme->getSetting('background_color', '#ffffff')};\n";
        $css .= "  --theme-text: {$theme->getSetting('text_color', '#1f2937')};\n";
        $css .= "  --theme-surface: {$theme->getSetting('surface_color', '#f8fafc')};\n";
        
        // Typography settings
        $typography = $theme->typography ?? [];
        $css .= "  --font-family: {$typography['font_family'] ?? 'Cairo, sans-serif'};\n";
        $css .= "  --font-size-base: {$typography['font_size_base'] ?? '16px'};\n";
        $css .= "  --line-height: {$typography['line_height'] ?? '1.6'};\n";
        
        // Spacing settings
        $css .= "  --spacing-unit: {$theme->getSetting('spacing_unit', '1rem')};\n";
        
        $css .= "}\n\n";
        
        // Layout-specific styles
        if ($theme->layout_type === 'boxed') {
            $css .= ".container {\n";
            $css .= "  max-width: 1200px;\n";
            $css .= "  margin: 0 auto;\n";
            $css .= "  padding: 0 1rem;\n";
            $css .= "}\n\n";
        }
        
        // Background patterns
        if ($theme->getSetting('background_pattern')) {
            $css .= "body {\n";
            $css .= "  background: var(--theme-background);\n";
            $css .= "}\n\n";
        }
        
        // Animation settings
        if ($theme->animations_enabled) {
            $css .= "* {\n";
            $css .= "  transition: all 0.3s ease;\n";
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
        $js = "// Theme: {$theme->name}\n\n";
        
        // Initialize theme functionality
        $js .= "document.addEventListener('DOMContentLoaded', function() {\n";
        $js .= "  initTheme();\n";
        $js .= "});\n\n";
        
        // Theme initialization
        $js .= "function initTheme() {\n";
        $js .= "  // Apply theme classes\n";
        $js .= "  document.body.classList.add('theme-' + '{$theme->slug}');\n";
        
        if ($theme->animations_enabled) {
            $js .= "  // Enable animations\n";
            $js .= "  initAnimations();\n";
        }
        
        // Custom functionality based on settings
        if ($theme->getSetting('smooth_scroll', false)) {
            $js .= "  // Enable smooth scroll\n";
            $js .= "  enableSmoothScroll();\n";
        }
        
        if ($theme->getSetting('lazy_load', true)) {
            $js .= "  // Enable lazy loading\n";
            $js .= "  initLazyLoading();\n";
        }
        
        $js .= "}\n\n";
        
        // Animation functions
        if ($theme->animations_enabled) {
            $js .= "function initAnimations() {\n";
            $js .= "  // Intersection Observer for scroll animations\n";
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
        
        // Smooth scroll function
        if ($theme->getSetting('smooth_scroll', false)) {
            $js .= "function enableSmoothScroll() {\n";
            $js .= "  document.querySelectorAll('a[href^=\"#\"]').forEach(anchor => {\n";
            $js .= "    anchor.addEventListener('click', function (e) {\n";
            $js .= "      e.preventDefault();\n";
            $js .= "      const target = document.querySelector(this.getAttribute('href'));\n";
            $js .= "      if (target) {\n";
            $js .= "        target.scrollIntoView({ behavior: 'smooth' });\n";
            $js .= "      }\n";
            $js .= "    });\n";
            $js .= "  });\n";
            $js .= "}\n\n";
        }
        
        // Lazy loading function
        if ($theme->getSetting('lazy_load', true)) {
            $js .= "function initLazyLoading() {\n";
            $js .= "  const images = document.querySelectorAll('img[data-src]');\n";
            $js .= "  const imageObserver = new IntersectionObserver((entries, observer) => {\n";
            $js .= "    entries.forEach(entry => {\n";
            $js .= "      if (entry.isIntersecting) {\n";
            $js .= "        const img = entry.target;\n";
            $js .= "        img.src = img.dataset.src;\n";
            $js .= "        img.classList.remove('lazy');\n";
            $js .= "        imageObserver.unobserve(img);\n";
            $js .= "      }\n";
            $js .= "    });\n";
            $js .= "  });\n\n";
            $js .= "  images.forEach(img => imageObserver.observe(img));\n";
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