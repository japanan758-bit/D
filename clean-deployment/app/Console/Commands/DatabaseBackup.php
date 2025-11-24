<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class DatabaseBackup extends Command
{
    protected $signature = 'backup:database {--location=local} {--compress=true} {--retention=30}';
    protected $description = 'إنشاء نسخة احتياطية من قاعدة البيانات';

    public function handle()
    {
        $this->info('💾 بدء عملية النسخ الاحتياطي...');

        $this->createBackupDirectory();
        
        $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
        $filename = "backup_{$timestamp}";
        
        try {
            // إنشاء نسخة احتياطية لقاعدة البيانات
            $this->backupDatabase($filename);
            
            // إنشاء نسخة احتياطية للملفات
            $this->backupFiles($filename);
            
            // ضغط النسخة الاحتياطية
            if ($this->option('compress')) {
                $this->compressBackup($filename);
            }
            
            // تنظيف النسخ القديمة
            $this->cleanupOldBackups($this->option('retention'));
            
            // رفع إلى الموقع المحدد
            $this->uploadBackup($filename);
            
            $this->info("✅ تم إنشاء النسخة الاحتياطية بنجاح: $filename");
            
            // حفظ معلومات النسخة الاحتياطية
            $this->saveBackupInfo($filename);
            
        } catch (\Exception $e) {
            $this->error('❌ فشل في إنشاء النسخة الاحتياطية: ' . $e->getMessage());
            return self::FAILURE;
        }
        
        return self::SUCCESS;
    }

    private function createBackupDirectory(): void
    {
        $backupDir = storage_path('app/backups');
        if (!File::exists($backupDir)) {
            File::makeDirectory($backupDir, 0755, true);
        }
    }

    private function backupDatabase(string $filename): void
    {
        $this->info('📁 نسخ قاعدة البيانات...');
        
        $databasePath = database_path('database.sqlite');
        $backupPath = storage_path("app/backups/{$filename}_database.sqlite");
        
        if (!File::exists($databasePath)) {
            throw new \Exception('ملف قاعدة البيانات غير موجود');
        }
        
        File::copy($databasePath, $backupPath);
        $this->line("تم نسخ قاعدة البيانات إلى: $backupPath");
    }

    private function backupFiles(string $filename): void
    {
        $this->info('📁 نسخ ملفات النظام...');
        
        $directories = [
            storage_path('app/public/uploads') => 'uploads',
            storage_path('app/temp') => 'temp',
            storage_path('logs') => 'logs',
            storage_path('app/page_builder') => 'page_builder',
        ];
        
        foreach ($directories as $sourceDir => $subDir) {
            if (File::exists($sourceDir)) {
                $backupDir = storage_path("app/backups/{$filename}/{$subDir}");
                File::makeDirectory($backupDir, 0755, true);
                File::copyDirectory($sourceDir, $backupDir);
                $this->line("تم نسخ: $subDir");
            }
        }
    }

    private function compressBackup(string $filename): void
    {
        $this->info('🗜️ ضغط النسخة الاحتياطية...');
        
        $backupDir = storage_path("app/backups/{$filename}");
        $zipFile = storage_path("app/backups/{$filename}.zip");
        
        // إنشاء ملف zip
        $zip = new \ZipArchive();
        $result = $zip->open($zipFile, \ZipArchive::CREATE);
        
        if ($result === true) {
            $files = File::allFiles($backupDir);
            
            foreach ($files as $file) {
                $relativePath = $file->getRelativePathname();
                $zip->addFile($file->getRealPath(), $relativePath);
            }
            
            $zip->close();
            
            // حذف المجلد المؤقت بعد الضغط
            File::deleteDirectory($backupDir);
            
            $this->line("تم ضغط النسخة الاحتياطية: $zipFile");
        } else {
            throw new \Exception("فشل في إنشاء ملف الضغط: $result");
        }
    }

    private function uploadBackup(string $filename): void
    {
        $location = $this->option('location');
        
        switch ($location) {
            case 'local':
                // النسخة موجودة محلياً بالفعل
                $this->line("النسخة الاحتياطية محفوظة محلياً");
                break;
                
            case 'google_drive':
                $this->uploadToGoogleDrive($filename);
                break;
                
            case 'dropbox':
                $this->uploadToDropbox($filename);
                break;
                
            case 's3':
                $this->uploadToS3($filename);
                break;
                
            default:
                $this->warn("موقع النسخ الاحتياطي غير مدعوم: $location");
        }
    }

    private function uploadToGoogleDrive(string $filename): void
    {
        // تنفيذ رفع إلى Google Drive (يتطلب إعداد)
        $this->line("رفع إلى Google Drive - يتم التطوير");
    }

    private function uploadToDropbox(string $filename): void
    {
        // تنفيذ رفع إلى Dropbox (يتطلب إعداد)
        $this->line("رفع إلى Dropbox - يتم التطوير");
    }

    private function uploadToS3(string $filename): void
    {
        // تنفيذ رفع إلى Amazon S3
        $storage = Storage::disk('s3');
        $backupPath = storage_path("app/backups/{$filename}.zip");
        
        if (file_exists($backupPath)) {
            $storage->putFileAs("backups", new \Illuminate\Http\File($backupPath), "{$filename}.zip");
            $this->line("تم رفع النسخة الاحتياطية إلى Amazon S3");
        }
    }

    private function cleanupOldBackups(int $retentionDays): void
    {
        $this->info('🧹 تنظيف النسخ القديمة...');
        
        $backupDir = storage_path('app/backups');
        $cutoffDate = Carbon::now()->subDays($retentionDays);
        
        $files = glob($backupDir . "/*.zip");
        $deletedCount = 0;
        
        foreach ($files as $file) {
            if (filemtime($file) < $cutoffDate->timestamp) {
                unlink($file);
                $deletedCount++;
            }
        }
        
        $this->line("تم حذف $deletedCount نسخة احتياطية قديمة");
    }

    private function saveBackupInfo(string $filename): void
    {
        $backupInfo = [
            'filename' => $filename,
            'created_at' => now()->toDateTimeString(),
            'size' => $this->getBackupSize($filename),
            'compression' => $this->option('compress'),
            'location' => $this->option('location'),
            'database_tables' => $this->getDatabaseTableCount(),
            'files_backed_up' => $this->getFileCount($filename),
        ];
        
        DB::table('backup_logs')->insert([
            'created_at' => now(),
            'backup_info' => json_encode($backupInfo),
            'status' => 'completed',
        ]);
        
        $this->line("تم حفظ معلومات النسخة الاحتياطية");
    }

    private function getBackupSize(string $filename): string
    {
        $backupDir = storage_path("app/backups/{$filename}");
        
        if (file_exists($backupDir)) {
            $size = $this->formatBytes($this->getDirectorySize($backupDir));
        } else {
            $zipFile = storage_path("app/backups/{$filename}.zip");
            $size = file_exists($zipFile) ? $this->formatBytes(filesize($zipFile)) : '0 B';
        }
        
        return $size;
    }

    private function getDirectorySize(string $directory): int
    {
        $size = 0;
        $files = File::allFiles($directory);
        
        foreach ($files as $file) {
            $size += $file->getSize();
        }
        
        return $size;
    }

    private function getFileCount(string $filename): int
    {
        $backupDir = storage_path("app/backups/{$filename}");
        
        if (!file_exists($backupDir)) {
            return 0;
        }
        
        $files = File::allFiles($backupDir);
        return count($files);
    }

    private function getDatabaseTableCount(): int
    {
        $tables = DB::connection()->getPdo()->exec("SELECT name FROM sqlite_master WHERE type='table'");
        return $tables;
    }

    private function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}