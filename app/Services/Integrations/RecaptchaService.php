<?php

namespace App\Services\Integrations;

use App\Services\BaseIntegrationService;

class RecaptchaService extends BaseIntegrationService
{
    public function initialize(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $this->log('initialized', ['site_key' => $this->getConfig('site_key')]);
        
        return true;
    }

    public function validate(): bool
    {
        $siteKey = $this->getConfig('site_key');
        $secretKey = $this->getApiKey('secret_key');

        return !empty($siteKey) && !empty($secretKey);
    }

    public function test(): array
    {
        if (!$this->isReady()) {
            return [
                'success' => false,
                'message' => 'Integration is not ready. Check configuration.'
            ];
        }

        // Test verification with a dummy token
        $result = $this->verifyToken('test_token_12345');
        
        return [
            'success' => true,
            'message' => 'reCAPTCHA configuration is valid',
            'data' => $result
        ];
    }

    /**
     * Verify reCAPTCHA token
     */
    public function verifyToken(string $token): array
    {
        $secretKey = $this->getApiKey('secret_key');
        $remoteip = request()->ip();

        $result = $this->makeRequest('POST', 'https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secretKey,
            'response' => $token,
            'remoteip' => $remoteip
        ]);

        return $result;
    }

    /**
     * Get the HTML code for reCAPTCHA widget
     */
    public function getWidgetCode(): string
    {
        $siteKey = $this->getConfig('site_key');
        $theme = $this->getConfig('theme', 'light');
        $size = $this->getConfig('size', 'normal');
        
        return <<<HTML
<div class="g-recaptcha" 
     data-sitekey="{$siteKey}" 
     data-theme="{$theme}" 
     data-size="{$size}"></div>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
HTML;
    }

    /**
     * Get invisible reCAPTCHA code
     */
    public function getInvisibleWidgetCode(string $buttonId = 'submit-btn'): string
    {
        $siteKey = $this->getConfig('site_key');
        
        return <<<HTML
<script>
function onSubmit(token) {
    document.getElementById("{$buttonId}").submit();
}
</script>
<button class="g-recaptcha" 
        data-sitekey="{$siteKey}" 
        data-callback='onSubmit' 
        data-size='invisible'>
    Submit
</button>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
HTML;
    }

    /**
     * Validate form with reCAPTCHA
     */
    public function validateForm(): bool
    {
        $token = request()->input('g-recaptcha-response');
        
        if (empty($token)) {
            return false;
        }

        $result = $this->verifyToken($token);
        
        return $result['success'] && ($result['data']['score'] ?? 1) > 0.5;
    }
}