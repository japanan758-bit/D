<?php

namespace App\Services;

use App\Models\ApiIntegration;
use App\Models\IntegrationLog;
use App\Models\IntegrationStat;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

abstract class BaseIntegrationService
{
    protected ApiIntegration $integration;
    protected array $config;
    protected array $apiKeys;

    public function __construct(string $integrationName)
    {
        $this->integration = ApiIntegration::getByName($integrationName);
        
        if (!$this->integration) {
            throw new \Exception("Integration {$integrationName} not found");
        }

        $this->config = $this->integration->configuration;
        $this->apiKeys = $this->integration->getDecryptedApiKeys();
    }

    /**
     * Initialize the integration (to be implemented by child classes)
     */
    abstract public function initialize(): bool;

    /**
     * Validate API keys and configuration
     */
    abstract public function validate(): bool;

    /**
     * Perform integration test
     */
    abstract public function test(): array;

    /**
     * Get integration specific configuration
     */
    protected function getConfig(string $key, $default = null)
    {
        return $this->config[$key] ?? $default;
    }

    /**
     * Get API key
     */
    protected function getApiKey(string $key)
    {
        return $this->apiKeys[$key] ?? null;
    }

    /**
     * Make HTTP request with error handling
     */
    protected function makeRequest(string $method, string $url, array $data = [], array $headers = []): array
    {
        try {
            $startTime = microtime(true);
            
            $response = Http::withHeaders($headers)
                ->timeout(30)
                ->{$method}($url, $data);

            $responseTime = round((microtime(true) - $startTime) * 1000, 2);
            
            $result = [
                'success' => $response->successful(),
                'status' => $response->status(),
                'data' => $response->json(),
                'response_time' => $responseTime,
                'timestamp' => now()
            ];

            // Log the request
            $this->log('api_request', [
                'method' => $method,
                'url' => $url,
                'status' => $result['status'],
                'response_time' => $responseTime
            ]);

            // Update statistics
            $this->updateStats([
                'requests_count' => 1,
                'successful_requests' => $result['success'] ? 1 : 0,
                'failed_requests' => $result['success'] ? 0 : 1,
                'average_response_time' => $responseTime
            ]);

            return $result;

        } catch (\Exception $e) {
            Log::error("Integration API request failed: {$e->getMessage()}", [
                'integration' => $this->integration->name,
                'method' => $method,
                'url' => $url,
                'error' => $e->getMessage()
            ]);

            $this->log('api_error', [
                'method' => $method,
                'url' => $url,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'timestamp' => now()
            ];
        }
    }

    /**
     * Log activity
     */
    protected function log(string $action, array $data = []): void
    {
        IntegrationLog::create([
            'integration_name' => $this->integration->name,
            'action' => $action,
            'data' => $data,
            'user_id' => auth()->id(),
            'ip_address' => request()->ip()
        ]);
    }

    /**
     * Update statistics
     */
    protected function updateStats(array $metrics): void
    {
        $stat = IntegrationStat::firstOrCreate([
            'integration_name' => $this->integration->name,
            'date' => now()->toDateString()
        ]);

        $currentMetrics = $stat->metrics ?? [];
        $newMetrics = array_merge($currentMetrics, $metrics);

        $stat->update(['metrics' => $newMetrics]);
    }

    /**
     * Check if integration is ready
     */
    public function isReady(): bool
    {
        return $this->integration->isReady() && $this->validate();
    }
}