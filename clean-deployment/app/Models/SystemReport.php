<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SystemReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'data',
        'type',
    ];

    protected $casts = [
        'data' => 'array',
        'date' => 'date',
    ];

    public static function createDailyReport(array $data): self
    {
        return self::create([
            'date' => Carbon::now()->toDateString(),
            'data' => $data,
            'type' => 'daily',
        ]);
    }

    public static function createWeeklyReport(array $data): self
    {
        return self::create([
            'date' => Carbon::now()->startOfWeek()->toDateString(),
            'data' => $data,
            'type' => 'weekly',
        ]);
    }

    public static function createMonthlyReport(array $data): self
    {
        return self::create([
            'date' => Carbon::now()->startOfMonth()->toDateString(),
            'data' => $data,
            'type' => 'monthly',
        ]);
    }

    public function getDataAttribute($value): array
    {
        return is_array($value) ? $value : json_decode($value, true) ?? [];
    }

    public function setDataAttribute($value): void
    {
        $this->attributes['data'] = is_array($value) ? json_encode($value) : $value;
    }

    public function scopeDaily($query)
    {
        return $query->where('type', 'daily');
    }

    public function scopeWeekly($query)
    {
        return $query->where('type', 'weekly');
    }

    public function scopeMonthly($query)
    {
        return $query->where('type', 'monthly');
    }

    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('date', '>=', Carbon::now()->subDays($days)->toDateString());
    }

    public function getTotalAppointmentsAttribute(): int
    {
        return $this->data['total_appointments'] ?? 0;
    }

    public function getCompletedAppointmentsAttribute(): int
    {
        return $this->data['completed_appointments'] ?? 0;
    }

    public function getNewPatientsAttribute(): int
    {
        return $this->data['new_patients'] ?? 0;
    }

    public function getTotalRevenueAttribute(): float
    {
        return $this->data['total_revenue'] ?? 0.0;
    }
}