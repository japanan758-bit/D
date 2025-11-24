<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class ApiIntegration extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'category',
        'configuration',
        'api_keys',
        'is_active',
        'is_testing',
        'description',
        'settings'
    ];

    protected $casts = [
        'configuration' => 'array',
        'api_keys' => 'array',
        'settings' => 'array',
        'is_active' => 'boolean',
        'is_testing' => 'boolean'
    ];

    /**
     * Get decrypted API keys
     */
    public function getDecryptedApiKeys(): array
    {
        $keys = $this->api_keys;
        $decrypted = [];
        
        foreach ($keys as $key => $value) {
            try {
                $decrypted[$key] = Crypt::decryptString($value);
            } catch (\Exception $e) {
                $decrypted[$key] = $value; // fallback for testing
            }
        }
        
        return $decrypted;
    }

    /**
     * Set encrypted API keys
     */
    public function setApiKeysAttribute($keys): void
    {
        $encrypted = [];
        
        foreach ($keys as $key => $value) {
            if (!empty($value)) {
                try {
                    $encrypted[$key] = Crypt::encryptString($value);
                } catch (\Exception $e) {
                    $encrypted[$key] = $value; // fallback for testing
                }
            }
        }
        
        $this->attributes['api_keys'] = json_encode($encrypted);
    }

    /**
     * Get configuration value
     */
    public function getConfig(string $key, $default = null)
    {
        return $this->configuration[$key] ?? $default;
    }

    /**
     * Set configuration value
     */
    public function setConfig(string $key, $value): void
    {
        $config = $this->configuration;
        $config[$key] = $value;
        $this->configuration = $config;
    }

    /**
     * Check if integration is ready to use
     */
    public function isReady(): bool
    {
        return $this->is_active && !empty($this->api_keys);
    }

    /**
     * Get integration by name
     */
    public static function getByName(string $name): ?self
    {
        return static::where('name', $name)->first();
    }

    /**
     * Get all active integrations by category
     */
    public static function getActiveByCategory(string $category): \Illuminate\Database\Eloquent\Collection
    {
        return static::where('category', $category)
                    ->where('is_active', true)
                    ->get();
    }

    /**
     * Log integration activity
     */
    public function log(string $action, array $data = [], ?string $userId = null, ?string $ipAddress = null): void
    {
        IntegrationLog::create([
            'integration_name' => $this->name,
            'action' => $action,
            'data' => $data,
            'user_id' => $userId,
            'ip_address' => $ipAddress
        ]);
    }

    /**
     * Update statistics
     */
    public function updateStats(array $metrics): void
    {
        IntegrationStat::updateOrCreate(
            [
                'integration_name' => $this->name,
                'date' => now()->toDateString()
            ],
            [
                'metrics' => $metrics
            ]
        );
    }
}