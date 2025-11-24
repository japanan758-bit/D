<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SystemHealthReport;
use Carbon\Carbon;

class SystemHealthCheck extends Command
{
    protected $signature = 'system:health-check {--email=admin@clinic.com}';
    protected $description = 'فحص صحة النظام وإرسال تقرير';

    public function handle()
    {
        $this->info('🔍 بدء فحص صحة النظام...');

        $healthData = [
            'timestamp' => now()->toDateTimeString(),
            'database' => $this->checkDatabaseHealth(),
            'memory' => $this->checkMemoryUsage(),
            'disk' => $this->checkDiskSpace(),
            'tables' => $this->checkDatabaseTables(),
            'users' => $this->checkUserAccounts(),
            'appointments' => $this->checkAppointmentHealth(),
            'email' => $this->checkEmailService(),
            'log_files' => $this->checkLogFiles(),
        ];

        $healthScore = $this->calculateHealthScore($healthData);
        $healthData['overall_score'] = $healthScore;

        // حفظ التقرير في قاعدة البيانات
        DB::table('system_health_reports')->insert([
            'created_at' => now(),
            'health_data' => json_encode($healthData),
            'score' => $healthScore,
        ]);

        // إرسال تقرير عبر البريد الإلكتروني إذا كان معرفاً
        $email = $this->option('email');
        if ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            try {
                Mail::to($email)->send(new SystemHealthReport($healthData));
                $this->info('✅ تم إرسال تقرير صحة النظام إلى: ' . $email);
            } catch (\Exception $e) {
                $this->error('❌ فشل إرسال البريد الإلكتروني: ' . $e->getMessage());
            }
        }

        // عرض النتائج في وحدة التحكم
        $this->displayHealthReport($healthData);

        return self::SUCCESS;
    }

    private function checkDatabaseHealth(): array
    {
        try {
            DB::connection()->getPdo();
            return [
                'status' => 'healthy',
                'connection' => 'connected',
                'response_time' => $this->measureQueryTime(),
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'error' => $e->getMessage(),
            ];
        }
    }

    private function checkMemoryUsage(): array
    {
        $memoryUsage = memory_get_usage(true);
        $memoryLimit = ini_get('memory_limit');
        $memoryLimitBytes = $this->parseMemoryLimit($memoryLimit);
        $percentage = ($memoryUsage / $memoryLimitBytes) * 100;

        return [
            'current_usage' => $this->formatBytes($memoryUsage),
            'limit' => $memoryLimit,
            'percentage' => round($percentage, 2),
            'status' => $percentage > 80 ? 'warning' : 'healthy',
        ];
    }

    private function checkDiskSpace(): array
    {
        $totalSpace = disk_total_space('.');
        $freeSpace = disk_free_space('.');
        $usedSpace = $totalSpace - $freeSpace;
        $percentage = ($usedSpace / $totalSpace) * 100;

        return [
            'total_space' => $this->formatBytes($totalSpace),
            'free_space' => $this->formatBytes($freeSpace),
            'used_space' => $this->formatBytes($usedSpace),
            'percentage' => round($percentage, 2),
            'status' => $percentage > 90 ? 'critical' : ($percentage > 75 ? 'warning' : 'healthy'),
        ];
    }

    private function checkDatabaseTables(): array
    {
        $expectedTables = [
            'users', 'doctors', 'patients', 'appointments', 'medical_records',
            'articles', 'services', 'contact_messages', 'testimonials', 'faqs',
            'settings', 'themes', 'page_templates', 'page_builder_components'
        ];

        $existingTables = [];
        foreach ($expectedTables as $table) {
            $tableExists = DB::connection()->getPdo()->exec("SELECT name FROM sqlite_master WHERE type='table' AND name='{$table}'") !== false;
            $existingTables[$table] = $tableExists;
        }

        $missingTables = array_filter($existingTables, function($exists) {
            return !$exists;
        });

        return [
            'total_expected' => count($expectedTables),
            'existing' => count(array_filter($existingTables)),
            'missing' => array_keys($missingTables),
            'status' => empty($missingTables) ? 'healthy' : 'error',
        ];
    }

    private function checkUserAccounts(): array
    {
        $totalUsers = DB::table('users')->count();
        $adminUsers = DB::table('users')->where('role', 'admin')->count();
        $inactiveUsers = DB::table('users')->where('is_active', false)->count();

        return [
            'total_users' => $totalUsers,
            'admin_users' => $adminUsers,
            'inactive_users' => $inactiveUsers,
            'status' => $adminUsers > 0 ? 'healthy' : 'warning',
        ];
    }

    private function checkAppointmentHealth(): array
    {
        $today = Carbon::now()->toDateString();
        $todayAppointments = DB::table('appointments')->whereDate('appointment_date', $today)->count();
        $pendingAppointments = DB::table('appointments')->where('status', 'pending')->count();
        $expiredAppointments = DB::table('appointments')->where('status', 'expired')->count();

        return [
            'today_appointments' => $todayAppointments,
            'pending_appointments' => $pendingAppointments,
            'expired_appointments' => $expiredAppointments,
            'status' => $pendingAppointments < 100 ? 'healthy' : 'warning',
        ];
    }

    private function checkEmailService(): array
    {
        // فحص إعدادات البريد الإلكتروني
        $config = config('mail');
        
        return [
            'driver' => $config['default'] ?? 'none',
            'status' => $config['default'] !== 'none' ? 'healthy' : 'warning',
            'configured' => !empty($config['mailers'][$config['default']]['host'] ?? ''),
        ];
    }

    private function checkLogFiles(): array
    {
        $logFiles = [
            storage_path('logs/laravel.log'),
            storage_path('logs/queries.log'),
            storage_path('logs/error.log'),
        ];

        $logInfo = [];
        foreach ($logFiles as $file) {
            if (file_exists($file)) {
                $logInfo[basename($file)] = [
                    'size' => $this->formatBytes(filesize($file)),
                    'last_modified' => date('Y-m-d H:i:s', filemtime($file)),
                    'exists' => true,
                ];
            }
        }

        $hasErrors = false;
        if (file_exists($logFiles[0])) {
            $lastLines = array_reverse(explode("\n", file_get_contents($logFiles[0])));
            $hasErrors = $this->hasRecentErrors($lastLines);
        }

        return [
            'files' => $logInfo,
            'has_recent_errors' => $hasErrors,
            'status' => $hasErrors ? 'warning' : 'healthy',
        ];
    }

    private function calculateHealthScore(array $data): int
    {
        $score = 100;
        
        if ($data['database']['status'] === 'error') $score -= 20;
        if ($data['disk']['status'] === 'critical') $score -= 30;
        if ($data['disk']['status'] === 'warning') $score -= 15;
        if ($data['memory']['status'] === 'warning') $score -= 10;
        if (!empty($data['tables']['missing'])) $score -= 25;
        if ($data['users']['status'] === 'warning') $score -= 10;
        if ($data['log_files']['has_recent_errors']) $score -= 15;

        return max(0, $score);
    }

    private function displayHealthReport(array $data): void
    {
        $this->newLine();
        $this->info('📊 تقرير صحة النظام - ' . $data['timestamp']);
        $this->newLine();
        
        // النتيجة الإجمالية
        $score = $data['overall_score'];
        $status = $score >= 80 ? '🟢 ممتاز' : ($score >= 60 ? '🟡 جيد' : '🔴 يحتاج تحسين');
        $this->line("النتيجة الإجمالية: $score% - $status");
        $this->newLine();

        // تفاصيل الفحص
        $components = [
            'قاعدة البيانات' => $data['database'],
            'الذاكرة' => $data['memory'],
            'مساحة القرص' => $data['disk'],
            'جداول قاعدة البيانات' => $data['tables'],
            'حسابات المستخدمين' => $data['users'],
            'المواعيد' => $data['appointments'],
            'خدمة البريد' => $data['email'],
            'ملفات السجل' => $data['log_files'],
        ];

        foreach ($components as $component => $info) {
            $status = $info['status'] ?? 'unknown';
            $icon = $status === 'healthy' ? '🟢' : ($status === 'warning' ? '🟡' : '🔴');
            $this->line($icon . ' ' . $component . ': ' . $status);
            
            if ($status === 'error' && isset($info['error'])) {
                $this->line('   خطأ: ' . $info['error']);
            }
        }

        $this->newLine();
        $this->info('✅ اكتمل فحص صحة النظام');
    }

    private function measureQueryTime(): string
    {
        $start = microtime(true);
        DB::select('SELECT 1');
        $end = microtime(true);
        $time = ($end - $start) * 1000;
        return round($time, 2) . 'ms';
    }

    private function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }

    private function parseMemoryLimit(string $limit): int
    {
        $limit = trim($limit);
        $last = strtolower(substr($limit, -1));
        $value = (int) substr($limit, 0, -1);

        switch ($last) {
            case 'g': return $value * 1024 * 1024 * 1024;
            case 'm': return $value * 1024 * 1024;
            case 'k': return $value * 1024;
            default: return (int) $limit;
        }
    }

    private function hasRecentErrors(array $lines): bool
    {
        foreach (array_slice($lines, 0, 100) as $line) {
            if (strpos($line, 'ERROR') !== false || strpos($line, 'CRITICAL') !== false) {
                return true;
            }
        }
        return false;
    }
}