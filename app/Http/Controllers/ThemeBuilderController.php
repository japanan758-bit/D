<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use App\Models\PageTemplate;
use App\Models\PageBuilderComponent;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class ThemeBuilderController extends Controller
{
    /**
     * Display the theme builder interface
     */
    public function index()
    {
        $themes = Theme::active()->get();
        $components = PageBuilderComponent::active()->reusable()->get();
        $templates = PageTemplate::active()->get();
        
        return view('theme-builder.index', compact('themes', 'components', 'templates'));
    }

    /**
     * Get theme data for builder
     */
    public function getTheme(Request $request, Theme $theme): JsonResponse
    {
        return response()->json([
            'theme' => $theme->load('media'),
            'components' => PageBuilderComponent::active()->reusable()->get(),
            'templates' => PageTemplate::active()->get(),
            'settings' => $theme->theme_settings ?? [],
            'typography' => $theme->theme_typography ?? [],
            'css' => $theme->theme_css,
            'js' => $theme->theme_js,
            'preview_url' => route('theme.preview', $theme)
        ]);
    }

    /**
     * Update theme settings
     */
    public function updateTheme(Request $request, Theme $theme): JsonResponse
    {
        $request->validate([
            'settings' => 'array',
            'typography' => 'array',
            'custom_css' => 'nullable',
            'custom_js' => 'nullable',
            'color_scheme' => 'nullable',
            'layout_type' => 'nullable'
        ]);

        $theme->update([
            'settings' => array_merge($theme->settings ?? [], $request->settings ?? []),
            'typography' => array_merge($theme->typography ?? [], $request->typography ?? []),
            'custom_css' => $request->custom_css,
            'custom_js' => $request->custom_js,
            'color_scheme' => $request->color_scheme ?? $theme->color_scheme,
            'layout_type' => $request->layout_type ?? $theme->layout_type,
        ]);

        // Generate updated CSS and JS files
        $this->generateThemeFiles($theme);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث إعدادات الثيم بنجاح',
            'theme' => $theme->fresh()
        ]);
    }

    /**
     * Update theme colors
     */
    public function updateColors(Request $request, Theme $theme): JsonResponse
    {
        $request->validate([
            'primary_color' => 'required|string',
            'secondary_color' => 'nullable|string',
            'accent_color' => 'nullable|string',
            'background_color' => 'nullable|string',
            'surface_color' => 'nullable|string',
            'text_color' => 'nullable|string'
        ]);

        $colors = $request->only([
            'primary_color', 'secondary_color', 'accent_color', 
            'background_color', 'surface_color', 'text_color'
        ]);

        $settings = $theme->settings ?? [];
        $settings = array_merge($settings, $colors);

        $theme->update(['settings' => $settings]);

        // Update color scheme if primary color matches a preset
        $theme->update([
            'color_scheme' => $this->detectColorScheme($request->primary_color)
        ]);

        // Regenerate CSS
        $this->generateThemeFiles($theme);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث الألوان بنجاح',
            'colors' => $colors,
            'color_scheme' => $theme->fresh()->color_scheme
        ]);
    }

    /**
     * Update typography settings
     */
    public function updateTypography(Request $request, Theme $theme): JsonResponse
    {
        $request->validate([
            'font_family' => 'required|string',
            'font_size_base' => 'required|string',
            'line_height' => 'required|string',
            'font_weight' => 'nullable|string'
        ]);

        $typography = $request->only([
            'font_family', 'font_family_fallback', 'font_size_base', 
            'font_size_sm', 'font_size_md', 'font_size_lg', 'font_size_xl', 'font_size_2xl',
            'line_height_tight', 'line_height_normal', 'line_height_relaxed',
            'font_weight_normal', 'font_weight_medium', 'font_weight_bold'
        ]);

        $theme->update(['typography' => $typography]);

        // Regenerate CSS
        $this->generateThemeFiles($theme);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث إعدادات الطباعة بنجاح',
            'typography' => $typography
        ]);
    }

    /**
     * Save theme layout
     */
    public function saveLayout(Request $request, Theme $theme): JsonResponse
    {
        $request->validate([
            'layout_components' => 'required|array',
            'layout_type' => 'required|string'
        ]);

        $layout = [
            'components' => $request->layout_components,
            'type' => $request->layout_type,
            'updated_at' => now()
        ];

        $settings = $theme->settings ?? [];
        $settings['custom_layout'] = $layout;

        $theme->update([
            'settings' => $settings,
            'layout_type' => $request->layout_type
        ]);

        // Regenerate CSS and JS
        $this->generateThemeFiles($theme);

        return response()->json([
            'success' => true,
            'message' => 'تم حفظ تخطيط الثيم بنجاح',
            'layout' => $layout
        ]);
    }

    /**
     * Get available components
     */
    public function getComponents(Request $request): JsonResponse
    {
        $query = PageBuilderComponent::active()->reusable();

        if ($request->category) {
            $query->byCategory($request->category);
        }

        if ($request->type) {
            $query->byType($request->type);
        }

        $components = $query->orderBy('name')->get();

        return response()->json([
            'components' => $components,
            'categories' => PageBuilderComponent::getCategories(),
            'types' => PageBuilderComponent::getComponentTypes()
        ]);
    }

    /**
     * Get component template
     */
    public function getComponent(Request $request, PageBuilderComponent $component): JsonResponse
    {
        $rendered = $component->renderWithSettings($request->settings ?? []);
        
        return response()->json([
            'component' => $component,
            'html' => $rendered['html'],
            'css' => $rendered['css'],
            'js' => $rendered['js'],
            'settings' => $component->settings
        ]);
    }

    /**
     * Create custom component
     */
    public function createComponent(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'category' => 'required|string',
            'html_template' => 'required',
            'css_styles' => 'nullable',
            'js_functionality' => 'nullable',
            'settings' => 'nullable|array'
        ]);

        $component = PageBuilderComponent::create([
            'name' => $request->name,
            'type' => $request->type,
            'category' => $request->category,
            'html_template' => $request->html_template,
            'css_styles' => $request->css_styles,
            'js_functionality' => $request->js_functionality,
            'settings' => $request->settings ?? [],
            'is_reusable' => true,
            'is_active' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم إنشاء المكون بنجاح',
            'component' => $component
        ]);
    }

    /**
     * Update component
     */
    public function updateComponent(Request $request, PageBuilderComponent $component): JsonResponse
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'html_template' => 'sometimes|required',
            'css_styles' => 'nullable',
            'js_functionality' => 'nullable',
            'settings' => 'nullable|array'
        ]);

        $component->update($request->only([
            'name', 'html_template', 'css_styles', 'js_functionality', 'settings'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث المكون بنجاح',
            'component' => $component->fresh()
        ]);
    }

    /**
     * Delete component
     */
    public function deleteComponent(PageBuilderComponent $component): JsonResponse
    {
        $component->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف المكون بنجاح'
        ]);
    }

    /**
     * Get templates
     */
    public function getTemplates(Request $request): JsonResponse
    {
        $query = PageTemplate::active();

        if ($request->category) {
            $query->byCategory($request->category);
        }

        if ($request->premium !== null) {
            $query->when($request->premium == 'true', function ($q) {
                $q->premium();
            }, function ($q) {
                $q->free();
            });
        }

        $templates = $query->orderBy('name')->get();

        return response()->json([
            'templates' => $templates,
            'categories' => PageTemplate::getCategories()
        ]);
    }

    /**
     * Apply template to theme
     */
    public function applyTemplate(Request $request, Theme $theme): JsonResponse
    {
        $request->validate([
            'template_id' => 'required|exists:page_templates,id'
        ]);

        $template = PageTemplate::findOrFail($request->template_id);

        // Apply template content to theme
        $settings = $theme->settings ?? [];
        $settings['applied_template'] = [
            'id' => $template->id,
            'name' => $template->name,
            'content' => $template->content,
            'applied_at' => now()
        ];

        $theme->update(['settings' => $settings]);

        return response()->json([
            'success' => true,
            'message' => 'تم تطبيق القالب بنجاح',
            'template' => $template
        ]);
    }

    /**
     * Preview theme changes
     */
    public function preview(Request $request, Theme $theme): JsonResponse
    {
        // Apply temporary changes for preview
        $tempSettings = array_merge($theme->settings ?? [], $request->settings ?? []);
        $tempTypography = array_merge($theme->typography ?? [], $request->typography ?? []);

        // Generate temporary CSS
        $css = $this->generatePreviewCSS($theme, $tempSettings, $tempTypography);
        $js = $this->generatePreviewJS($theme, $tempSettings);

        return response()->json([
            'success' => true,
            'css' => $css,
            'js' => $js,
            'preview_url' => route('theme.preview', $theme)
        ]);
    }

    /**
     * Export theme
     */
    public function exportTheme(Theme $theme)
    {
        $exportData = $theme->export();
        
        return response()->streamDownload(function () use ($exportData) {
            echo $exportData;
        }, $theme->slug . '.json');
    }

    /**
     * Import theme
     */
    public function importTheme(Request $request): JsonResponse
    {
        $request->validate([
            'theme_file' => 'required|file',
            'theme_name' => 'nullable|string|max:255'
        ]);

        try {
            $jsonContent = file_get_contents($request->file('theme_file')->getPath());
            $name = $request->theme_name ?? null;
            
            $theme = Theme::importFromJson($jsonContent, $name);

            return response()->json([
                'success' => true,
                'message' => 'تم استيراد الثيم بنجاح',
                'theme' => $theme
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'فشل في استيراد الثيم: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Clone theme
     */
    public function cloneTheme(Request $request, Theme $theme): JsonResponse
    {
        $request->validate([
            'new_name' => 'required|string|max:255'
        ]);

        $duplicate = $theme->duplicate($request->new_name);

        return response()->json([
            'success' => true,
            'message' => 'تم نسخ الثيم بنجاح',
            'theme' => $duplicate
        ]);
    }

    /**
     * Activate theme
     */
    public function activateTheme(Theme $theme): JsonResponse
    {
        DB::transaction(function () use ($theme) {
            // Deactivate all other themes
            Theme::where('id', '!=', $theme->id)->update(['is_active' => false]);
            
            // Activate this theme
            $theme->update(['is_active' => true]);
            
            // Set as default if not already
            if (!$theme->is_default) {
                $theme->setAsDefault();
            }
            
            // Apply theme
            $this->applyTheme($theme);
        });

        return response()->json([
            'success' => true,
            'message' => 'تم تفعيل الثيم بنجاح',
            'theme' => $theme->fresh()
        ]);
    }

    /**
     * Generate theme files
     */
    private function generateThemeFiles(Theme $theme): void
    {
        $cssPath = public_path("themes/{$theme->slug}.css");
        $jsPath = public_path("themes/{$theme->slug}.js");
        
        File::ensureDirectoryExists(dirname($cssPath));
        
        // Generate CSS
        $css = $this->generateFullCSS($theme);
        File::put($cssPath, $css);
        
        // Generate JavaScript
        $js = $this->generateFullJS($theme);
        File::put($jsPath, $js);
    }

    /**
     * Generate full CSS
     */
    private function generateFullCSS(Theme $theme): string
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
        $css .= "  --font-weight-normal: " . ($typography['font_weight_normal'] ?? '400') . ";\n";
        $css .= "  --font-weight-medium: " . ($typography['font_weight_medium'] ?? '500') . ";\n";
        $css .= "  --font-weight-bold: " . ($typography['font_weight_bold'] ?? '700') . ";\n";
        
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
        
        // Component styles...
        // [Additional CSS generation logic here]
        
        // Custom CSS from theme
        if ($theme->custom_css) {
            $css .= "\n/* Custom CSS */\n";
            $css .= $theme->custom_css;
        }
        
        return $css;
    }

    /**
     * Generate full JavaScript
     */
    private function generateFullJS(Theme $theme): string
    {
        $settings = $theme->settings ?? [];
        
        $js = "// Theme: {$theme->name}\n\n";
        
        // Theme initialization
        $js .= "document.addEventListener('DOMContentLoaded', function() {\n";
        $js .= "  initTheme();\n";
        
        if (($settings['animations_enabled'] ?? true)) {
            $js .= "  initAnimations();\n";
        }
        
        if (($settings['smooth_scroll'] ?? true)) {
            $js .= "  initSmoothScroll();\n";
        }
        
        if (($settings['lazy_load'] ?? true)) {
            $js .= "  initLazyLoading();\n";
        }
        
        $js .= "});\n\n";
        
        // JavaScript functions...
        // [Additional JS generation logic here]
        
        // Custom JS from theme
        if ($theme->custom_js) {
            $js .= "\n// Custom JavaScript\n";
            $js .= $theme->custom_js;
        }
        
        return $js;
    }

    /**
     * Generate preview CSS
     */
    private function generatePreviewCSS(Theme $theme, array $settings, array $typography): string
    {
        // Similar to generateFullCSS but with temporary settings
        return $this->generateFullCSS($theme);
    }

    /**
     * Generate preview JavaScript
     */
    private function generatePreviewJS(Theme $theme, array $settings): string
    {
        // Similar to generateFullJS but with temporary settings
        return $this->generateFullJS($theme);
    }

    /**
     * Apply theme to application
     */
    private function applyTheme(Theme $theme): void
    {
        // Clear application cache
        cache()->forget('current_theme');
        cache()->forget('theme_settings');
        cache()->forget('custom_css');
        cache()->forget('custom_js');
        
        // Update settings
        $settings = app('settings');
        if ($settings) {
            $settings->update([
                'current_theme' => $theme->slug,
                'theme_settings' => json_encode($theme->settings),
                'theme_colors' => $theme->color_scheme,
                'layout_type' => $theme->layout_type
            ]);
        }
    }

    /**
     * Detect color scheme from primary color
     */
    private function detectColorScheme(string $primaryColor): string
    {
        // Simple color detection based on hue
        $hues = [
            'blue' => [190, 250],
            'green' => [120, 160],
            'purple' => [270, 310],
            'red' => [350, 20] // Red wraps around 0
        ];
        
        // Convert hex to HSL (simplified)
        $hex = ltrim($primaryColor, '#');
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        
        $r /= 255;
        $g /= 255;
        $b /= 255;
        
        $max = max($r, $g, $b);
        $min = min($r, $g, $b);
        $l = ($max + $min) / 2;
        
        if ($max == $min) {
            $h = $s = 0; // achromatic
        } else {
            $d = $max - $min;
            $s = $l > 0.5 ? $d / (2 - $max - $min) : $d / ($max + $min);
            
            switch ($max) {
                case $r: $h = ($g - $b) / $d + ($g < $b ? 6 : 0); break;
                case $g: $h = ($b - $r) / $d + 2; break;
                case $b: $h = ($r - $g) / $d + 4; break;
            }
            $h /= 6;
        }
        
        $hue = $h * 360;
        
        // Check which range the hue falls into
        foreach ($hues as $scheme => [$start, $end]) {
            if ($start > $end) {
                // Range wraps around (like red)
                if ($hue >= $start || $hue <= $end) {
                    return $scheme;
                }
            } else {
                if ($hue >= $start && $hue <= $end) {
                    return $scheme;
                }
            }
        }
        
        return 'custom';
    }
}