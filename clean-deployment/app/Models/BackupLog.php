<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BackupLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'backup_info',
        'status',
        'error_message',
    ];

    protected $casts = [
        'backup_info' => 'array',
    ];

    public static function createBackup(array $info, string $filename): self
    {
        return self::create([
            'filename' => $filename,
            'backup_info' => $info,
            'status' => 'completed',
        ]);
    }

    public function markAsFailed(string $errorMessage): void
    {
        $this->update([
            'status' => 'failed',
            'error_message' => $errorMessage,
        ]);
    }

    public function getInfoAttribute($value): array
    {
        return is_array($value) ? $value : json_decode($value, true) ?? [];
    }

    public function setInfoAttribute($value): void
    {
        $this->attributes['backup_info'] = is_array($value) ? json_encode($value) : $value;
    }

    public function scopeSuccessful($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('created_at', '>=', Carbon::now()->subDays($days));
    }

    public function getSizeAttribute(): string
    {
        return $this->info['size'] ?? '0 B';
    }

    public function getTypeAttribute(): string
    {
        return $this->info['type'] ?? 'unknown';
    }
}