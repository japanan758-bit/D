<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntegrationStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'integration_name',
        'date',
        'metrics'
    ];

    protected $casts = [
        'metrics' => 'array',
        'date' => 'date'
    ];

    /**
     * Get statistics for an integration in a date range
     */
    public static function getRange(string $integrationName, string $startDate, string $endDate): \Illuminate\Database\Eloquent\Collection
    {
        return static::where('integration_name', $integrationName)
                    ->whereBetween('date', [$startDate, $endDate])
                    ->orderBy('date')
                    ->get();
    }

    /**
     * Get today's statistics for all integrations
     */
    public static function getTodayStats(): \Illuminate\Database\Eloquent\Collection
    {
        return static::where('date', now()->toDateString())->get();
    }

    /**
     * Increment a metric
     */
    public function incrementMetric(string $metricKey, int $value = 1): void
    {
        $metrics = $this->metrics;
        $metrics[$metricKey] = ($metrics[$metricKey] ?? 0) + $value;
        $this->metrics = $metrics;
        $this->save();
    }

    /**
     * Update a metric value
     */
    public function updateMetric(string $metricKey, $value): void
    {
        $metrics = $this->metrics;
        $metrics[$metricKey] = $value;
        $this->metrics = $metrics;
        $this->save();
    }
}