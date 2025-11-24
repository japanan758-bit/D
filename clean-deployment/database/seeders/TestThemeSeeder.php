<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Theme;
use App\Models\PageTemplate;
use App\Models\PageBuilderComponent;

class TestThemeSeeder extends Seeder
{
    public function run(): void
    {
        echo "Starting theme seeder...\n";
        
        // Create themes
        echo "Creating default medical theme...\n";
        $defaultTheme = Theme::create([
            'name' => 'الثيم الطبي الافتراضي',
            'slug' => 'default-medical',
            'description' => 'ثيم طبي احترافي مُحسن للعيادات والمستشفيات',
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
            ],
            'typography' => [
                'font_family' => 'Cairo',
                'font_family_fallback' => 'sans-serif',
                'font_size_base' => '16px',
                'line_height' => '1.5',
            ],
        ]);
        
        echo "Default theme created with ID: " . $defaultTheme->id . "\n";
        
        // Create some components
        echo "Creating page builder components...\n";
        $heroComponent = PageBuilderComponent::create([
            'name' => 'قسم رئيسي',
            'type' => 'layout',
            'category' => 'hero',
            'html_template' => '<section class="hero">{{$title}}</section>',
            'settings' => ['title', 'subtitle'],
            'is_reusable' => true,
            'is_active' => true,
        ]);
        
        echo "Hero component created with ID: " . $heroComponent->id . "\n";
        
        // Create a template
        echo "Creating page template...\n";
        $homeTemplate = PageTemplate::create([
            'name' => 'صفحة رئيسية طبية',
            'slug' => 'medical-home',
            'description' => 'قالب شامل للصفحة الرئيسية للعيادات الطبية',
            'category' => 'home',
            'content' => '<div class="home-page"><h1>{{$clinic_name}}</h1></div>',
            'is_active' => true,
            'is_premium' => false,
        ]);
        
        echo "Template created with ID: " . $homeTemplate->id . "\n";
        
        echo "Theme seeding completed successfully!\n";
    }
}