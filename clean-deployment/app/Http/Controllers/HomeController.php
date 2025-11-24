<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Doctor;
use App\Models\Testimonial;
use App\Models\Article;
use App\Models\PageTemplate;
use App\Models\PageBuilderComponent;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index()
    {
        // Get featured services (limit to 6)
        $featuredServices = Service::where('is_active', true)
            ->limit(6)
            ->get();

        // Get the main doctor (if you want to display a specific doctor)
        $doctor = Doctor::first();

        // Get featured testimonials
        $featuredTestimonials = Testimonial::where('is_approved', true)
            ->where('is_featured', true)
            ->limit(6)
            ->get();

        // Get latest articles
        $latestArticles = Article::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        return view('pages.home', compact('featuredServices', 'doctor', 'featuredTestimonials', 'latestArticles'));
    }

    /**
     * Display the about page.
     */
    public function about()
    {
        $doctor = Doctor::first();
        return view('pages.about', compact('doctor'));
    }

    /**
     * Display testimonials page.
     */
    public function testimonials()
    {
        $testimonials = Testimonial::where('is_approved', true)
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        
        return view('pages.testimonials', compact('testimonials'));
    }

    /**
     * Display FAQ page.
     */
    public function faq()
    {
        $faqs = \App\Models\Faq::where('is_active', true)
            ->orderBy('order', 'asc')
            ->get();
        
        return view('pages.faq', compact('faqs'));
    }

    /**
     * Display blog page (alias for articles).
     */
    public function blog()
    {
        $articles = Article::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->paginate(12);
        
        return view('pages.blog', compact('articles'));
    }

    /**
     * Display booking page.
     */
    public function booking()
    {
        return view('pages.booking');
    }

    /**
     * Display contact page.
     */
    public function contact()
    {
        $settings = \App\Models\Setting::getSettings();
        return view('pages.contact', compact('settings'));
    }

    /**
     * Display privacy policy page.
     */
    public function privacy()
    {
        return view('pages.privacy');
    }

    /**
     * Display terms and conditions page.
     */
    public function terms()
    {
        return view('pages.terms');
    }

    /**
     * Generate sitemap
     */
    public function sitemap()
    {
        $content = '<?xml version="1.0" encoding="UTF-8"?>';
        $content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        
        // Add main pages
        $routes = ['home', 'about', 'services', 'articles', 'testimonials', 'faq', 'contact', 'booking'];
        
        foreach ($routes as $route) {
            $content .= '<url>';
            $content .= '<loc>' . url(route($route)) . '</loc>';
            $content .= '<changefreq>weekly</changefreq>';
            $content .= '<priority>0.8</priority>';
            $content .= '</url>';
        }

        // Add services to sitemap
        $services = Service::where('is_active', true)->get();
        foreach ($services as $service) {
            $content .= '<url>';
            $content .= '<loc>' . route('service-detail', $service->id) . '</loc>';
            $content .= '<changefreq>monthly</changefreq>';
            $content .= '<priority>0.6</priority>';
            $content .= '</url>';
        }

        // Add articles to sitemap
        $articles = Article::where('is_published', true)->get();
        foreach ($articles as $article) {
            $content .= '<url>';
            $content .= '<loc>' . route('article-detail', $article->slug) . '</loc>';
            $content .= '<changefreq>monthly</changefreq>';
            $content .= '<priority>0.6</priority>';
            $content .= '</url>';
        }
        
        $content .= '</urlset>';
        
        return response($content, 200, [
            'Content-Type' => 'application/xml'
        ]);
    }

    /**
     * Page Builder Methods
     */
    
    public function pageBuilder()
    {
        $themes = Theme::all();
        $templates = PageTemplate::where('is_active', true)->get();
        return view('admin.page-builder', compact('themes', 'templates'));
    }

    public function createPage()
    {
        $themes = Theme::where('is_active', true)->get();
        $components = PageBuilderComponent::where('is_active', true)->orderBy('sort_order')->get();
        return view('admin.create-page', compact('themes', 'components'));
    }

    public function editPage($pageId = null)
    {
        $page = $pageId ? PageTemplate::find($pageId) : null;
        $themes = Theme::where('is_active', true)->get();
        $components = PageBuilderComponent::where('is_active', true)->orderBy('sort_order')->get();
        return view('admin.edit-page', compact('page', 'themes', 'components'));
    }

    public function pageTemplates()
    {
        $templates = PageTemplate::where('is_active', true)->paginate(12);
        $categories = PageTemplate::distinct('category')->pluck('category');
        return view('admin.page-templates', compact('templates', 'categories'));
    }

    public function loadTemplate($templateId)
    {
        $template = PageTemplate::find($templateId);
        if ($template) {
            return response()->json([
                'success' => true,
                'template' => [
                    'id' => $template->id,
                    'name' => $template->name,
                    'content' => json_decode($template->content, true),
                    'description' => $template->description
                ]
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Template not found'], 404);
    }

    public function previewPage($pageId)
    {
        $page = PageTemplate::findOrFail($pageId);
        $components = json_decode($page->content, true) ?? [];
        return view('admin.preview-page', compact('page', 'components'));
    }

    public function savePage(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:page_templates,slug',
            'content' => 'required',
            'description' => 'nullable|string'
        ]);

        $page = PageTemplate::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'content' => json_encode($request->content),
            'category' => 'custom',
            'is_premium' => false,
            'is_active' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Page saved successfully',
            'page' => $page
        ]);
    }

    public function saveAsTemplate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:page_templates,slug',
            'content' => 'required',
            'description' => 'nullable|string'
        ]);

        $template = PageTemplate::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'content' => json_encode($request->content),
            'category' => 'custom',
            'is_premium' => true,
            'is_active' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Template saved successfully',
            'template' => $template
        ]);
    }

    public function exportPage($pageId)
    {
        $page = PageTemplate::findOrFail($pageId);
        
        $exportData = [
            'name' => $page->name,
            'slug' => $page->slug,
            'description' => $page->description,
            'content' => json_decode($page->content, true),
            'exported_at' => now()->toISOString(),
            'version' => '1.0'
        ];

        $filename = 'page_export_' . $page->slug . '_' . time() . '.json';
        
        return response()->json($exportData)
            ->header('Content-Type', 'application/json')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    public function importPage(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:json'
        ]);

        $file = $request->file('file');
        $content = json_decode(file_get_contents($file), true);

        if (!$content) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid JSON file'
            ], 400);
        }

        $importedPage = PageTemplate::create([
            'name' => $content['name'] . ' (استيراد)',
            'slug' => Str::slug($content['slug'] . '_imported_' . time()),
            'description' => 'Page imported from file',
            'content' => json_encode($content['content']),
            'category' => 'imported',
            'is_premium' => false,
            'is_active' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Page imported successfully',
            'page' => $importedPage
        ]);
    }

    public function deletePage($pageId)
    {
        $page = PageTemplate::findOrFail($pageId);
        $page->delete();

        return response()->json([
            'success' => true,
            'message' => 'Page deleted successfully'
        ]);
    }

    /**
     * API Methods for Page Builder
     */

    public function getComponents()
    {
        $components = PageBuilderComponent::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'components' => $components
        ]);
    }

    public function getComponent($type)
    {
        $component = PageBuilderComponent::where('type', $type)
            ->where('is_active', true)
            ->first();

        if ($component) {
            return response()->json([
                'success' => true,
                'component' => $component
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Component not found'
        ], 404);
    }

    public function getThemes()
    {
        $themes = Theme::where('is_active', true)->get();

        return response()->json([
            'success' => true,
            'themes' => $themes
        ]);
    }

    public function getPages()
    {
        $pages = PageTemplate::where('is_active', true)
            ->select('id', 'name', 'slug', 'description', 'category', 'is_premium', 'created_at')
            ->get();

        return response()->json([
            'success' => true,
            'pages' => $pages
        ]);
    }

    public function getPage($pageId)
    {
        $page = PageTemplate::findOrFail($pageId);

        return response()->json([
            'success' => true,
            'page' => [
                'id' => $page->id,
                'name' => $page->name,
                'slug' => $page->slug,
                'description' => $page->description,
                'content' => json_decode($page->content, true),
                'category' => $page->category,
                'is_premium' => $page->is_premium
            ]
        ]);
    }

    public function addComponent(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'content' => 'array',
            'settings' => 'array'
        ]);

        $component = PageBuilderComponent::where('type', $request->type)
            ->where('is_active', true)
            ->first();

        if (!$component) {
            return response()->json([
                'success' => false,
                'message' => 'Component type not found'
            ], 404);
        }

        $newComponent = [
            'id' => 'comp_' . time() . '_' . uniqid(),
            'type' => $request->type,
            'content' => $request->content ?? ($component->default_content ?? []),
            'settings' => $request->settings ?? ($component->schema ?? []),
            'name' => $component->name,
            'icon' => $component->icon,
            'sort_order' => 0
        ];

        return response()->json([
            'success' => true,
            'component' => $newComponent,
            'message' => 'Component added successfully'
        ]);
    }

    public function updateComponent(Request $request, $componentId)
    {
        $request->validate([
            'updates' => 'required|array'
        ]);

        // In a real implementation, you would save this to the database
        // For now, we'll just return the updated component data

        return response()->json([
            'success' => true,
            'component_id' => $componentId,
            'updates' => $request->updates,
            'message' => 'Component updated successfully'
        ]);
    }

    public function deleteComponent($componentId)
    {
        // In a real implementation, you would delete from database
        return response()->json([
            'success' => true,
            'component_id' => $componentId,
            'message' => 'Component deleted successfully'
        ]);
    }

    public function reorderComponents(Request $request)
    {
        $request->validate([
            'dragged_id' => 'required|string',
            'target_id' => 'required|string',
            'position' => 'required|in:before,after'
        ]);

        // In a real implementation, you would update the order in database
        return response()->json([
            'success' => true,
            'message' => 'Components reordered successfully'
        ]);
    }

    public function duplicateComponent(Request $request)
    {
        $request->validate([
            'component_id' => 'required|string'
        ]);

        // In a real implementation, you would create a duplicate in database
        return response()->json([
            'success' => true,
            'component_id' => $request->component_id,
            'message' => 'Component duplicated successfully'
        ]);
    }
}