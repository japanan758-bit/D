<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThemeBuilderController;

/*
|--------------------------------------------------------------------------
| Theme Builder Routes
|--------------------------------------------------------------------------
|
| Routes for theme customization and page builder functionality
|
*/

// Theme Builder Interface
Route::prefix('theme-builder')->name('theme-builder.')->group(function () {
    // Main builder interface
    Route::get('/', [ThemeBuilderController::class, 'index'])->name('index');
    
    // Theme management
    Route::get('theme/{theme}', [ThemeBuilderController::class, 'getTheme'])->name('theme');
    Route::put('theme/{theme}', [ThemeBuilderController::class, 'updateTheme'])->name('theme.update');
    Route::post('theme/{theme}/colors', [ThemeBuilderController::class, 'updateColors'])->name('theme.colors');
    Route::post('theme/{theme}/typography', [ThemeBuilderController::class, 'updateTypography'])->name('theme.typography');
    Route::post('theme/{theme}/layout', [ThemeBuilderController::class, 'saveLayout'])->name('theme.layout');
    Route::post('theme/{theme}/activate', [ThemeBuilderController::class, 'activateTheme'])->name('theme.activate');
    
    // Preview functionality
    Route::post('theme/{theme}/preview', [ThemeBuilderController::class, 'preview'])->name('theme.preview');
    
    // Export/Import functionality
    Route::get('theme/{theme}/export', [ThemeBuilderController::class, 'exportTheme'])->name('theme.export');
    Route::post('theme/import', [ThemeBuilderController::class, 'importTheme'])->name('theme.import');
    Route::post('theme/{theme}/clone', [ThemeBuilderController::class, 'cloneTheme'])->name('theme.clone');
    
    // Component management
    Route::get('components', [ThemeBuilderController::class, 'getComponents'])->name('components');
    Route::get('component/{component}', [ThemeBuilderController::class, 'getComponent'])->name('component');
    Route::post('component', [ThemeBuilderController::class, 'createComponent'])->name('component.create');
    Route::put('component/{component}', [ThemeBuilderController::class, 'updateComponent'])->name('component.update');
    Route::delete('component/{component}', [ThemeBuilderController::class, 'deleteComponent'])->name('component.delete');
    
    // Template management
    Route::get('templates', [ThemeBuilderController::class, 'getTemplates'])->name('templates');
    Route::post('template/{theme}/apply', [ThemeBuilderController::class, 'applyTemplate'])->name('template.apply');
});

// Admin routes for themes (if not already defined)
Route::middleware(['web', 'auth'])->prefix('admin')->name('admin.')->group(function () {
    // Theme Resource routes are already defined in Filament
    // Additional custom admin routes can be added here
});

// API routes for theme data (public access for preview)
Route::prefix('api/theme')->name('api.theme.')->group(function () {
    Route::get('preview/{theme}', [ThemeBuilderController::class, 'preview'])->name('preview');
    Route::get('components', [ThemeBuilderController::class, 'getComponents'])->name('components');
    Route::get('component/{component}', [ThemeBuilderController::class, 'getComponent'])->name('component');
    Route::get('templates', [ThemeBuilderController::class, 'getTemplates'])->name('templates');
});