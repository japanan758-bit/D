<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // إعدادات خاصة للتطبيق
        $this->registerAppSettings();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // إعداد اللغة الافتراضية
        $this->app->setLocale('ar');
        
        // تحسين الأداء للإنتاج
        $this->optimizeForProduction();
        
        // إعدادات الأمان
        $this->configureSecurity();
        
        // إعدادات قاعدة البيانات
        $this->configureDatabase();
        
        // إعدادات التخزين
        $this->configureStorage();
        
        // إعداد البث المباشر
        $this->configureBroadcasting();
    }

    /**
     * Register application-specific settings
     */
    private function registerAppSettings(): void
    {
        // إعدادات خاصة بالتطبيق
    }

    /**
     * Optimize application for production
     */
    private function optimizeForProduction(): void
    {
        // تحسينات الإنتاج
        Model::shouldBeStrict(false);
    }

    /**
     * Configure security settings
     */
    private function configureSecurity(): void
    {
        // إعدادات الأمان للتطبيق - استخدام المُشفِر المدمج في Laravel
        // إزالة المُشفِر المخصص لتجنب التضارب
    }

    /**
     * Configure database settings
     */
    private function configureDatabase(): void
    {
        // تحسين إعدادات قاعدة البيانات
        Schema::defaultStringLength(191);
    }

    /**
     * Configure storage settings
     */
    private function configureStorage(): void
    {
        // إعداد التخزين المحلي - مبسط
    }

    /**
     * Configure broadcasting settings
     */
    private function configureBroadcasting(): void
    {
        // إعداد البث المباشر للـ notifications
        // مبسط للتجنب الأخطاء
    }
}
