<?php

namespace App\Services\Integrations;

use App\Services\BaseIntegrationService;

class CloudflareAnalyticsService extends BaseIntegrationService
{
    public function initialize(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $this->log('initialized', ['site_tag' => $this->getConfig('site_tag')]);
        
        return true;
    }

    public function validate(): bool
    {
        $siteTag = $this->getConfig('site_tag');
        return !empty($siteTag);
    }

    public function test(): array
    {
        if (!$this->isReady()) {
            return [
                'success' => false,
                'message' => 'Integration is not ready. Check configuration.'
            ];
        }

        // Cloudflare Analytics doesn't have a test API, so we'll verify the tag is configured
        return [
            'success' => true,
            'message' => 'Cloudflare Analytics is configured correctly',
            'data' => [
                'site_tag' => $this->getConfig('site_tag')
            ]
        ];
    }

    /**
     * Get the JavaScript code to include Cloudflare Analytics
     */
    public function getTrackingCode(): string
    {
        $siteTag = $this->getConfig('site_tag');
        $delayOnload = $this->getConfig('delay_onload', 0);
        
        return <<<HTML
<!-- Cloudflare Web Analytics -->
<script defer src='https://static.cloudflareinsights.com/beacon.min.js' 
        data-cf-beacon='{"token": "{$siteTag}", "spa": true}'
        {if $delayOnload > 0}onload="loadBeacon()"{/if}></script>
<script>
    function loadBeacon() {
        // Add beacon loading logic here if needed
    }
</script>
HTML;
    }
}