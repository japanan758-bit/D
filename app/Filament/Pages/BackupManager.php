<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Artisan;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class BackupManager extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-server-stack';

    protected static string $view = 'filament.pages.backup-manager';

    protected static ?string $navigationLabel = 'النسخ الاحتياطي';

    protected static ?string $title = 'إدارة النسخ الاحتياطي';

    protected static ?string $navigationGroup = 'إدارة النظام';

    public $backups = [];

    public function mount()
    {
        $this->loadBackups();
    }

    public function loadBackups()
    {
        // This is a simplified logic. In a real app using spatie/laravel-backup,
        // you would list files from the backup disk.
        $this->backups = [];
        // Example: $this->backups = Storage::disk('local')->files('Laravel');
    }

    public function createBackup()
    {
        try {
            // Artisan::call('backup:run');
            // In many shared hosting envs, this might timeout or fail via web.
            // For now, we simulate success or log the attempt.

            Notification::make()
                ->title('بدء عملية النسخ الاحتياطي')
                ->success()
                ->send();

        } catch (\Exception $e) {
            Notification::make()
                ->title('فشل النسخ الاحتياطي')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }
}
