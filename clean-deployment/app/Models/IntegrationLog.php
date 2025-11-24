<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntegrationLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'integration_name',
        'action',
        'data',
        'user_id',
        'ip_address'
    ];

    protected $casts = [
        'data' => 'array'
    ];

    /**
     * Get recent logs for an integration
     */
    public static function getRecent(string $integrationName, int $limit = 50): \Illuminate\Database\Eloquent\Collection
    {
        return static::where('integration_name', $integrationName)
                    ->latest()
                    ->limit($limit)
                    ->get();
    }

    /**
     * Get logs by action type
     */
    public static function getByAction(string $action, int $limit = 100): \Illuminate\Database\Eloquent\Collection
    {
        return static::where('action', $action)
                    ->latest()
                    ->limit($limit)
                    ->get();
    }
}