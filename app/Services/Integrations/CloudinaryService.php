<?php

namespace App\Services\Integrations;

use App\Services\BaseIntegrationService;

class CloudinaryService extends BaseIntegrationService
{
    public function initialize(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $this->log('initialized', [
            'cloud_name' => $this->getConfig('cloud_name'),
            'upload_preset' => $this->getConfig('upload_preset')
        ]);
        
        return true;
    }

    public function validate(): bool
    {
        $apiKey = $this->getApiKey('api_key');
        $apiSecret = $this->getApiKey('api_secret');
        $cloudName = $this->getConfig('cloud_name');

        return !empty($apiKey) && !empty($apiSecret) && !empty($cloudName);
    }

    public function test(): array
    {
        if (!$this->isReady()) {
            return [
                'success' => false,
                'message' => 'Integration is not ready. Check configuration.'
            ];
        }

        try {
            $cloudName = $this->getConfig('cloud_name');
            $apiKey = $this->getApiKey('api_key');
            
            // Test by getting account info
            $response = $this->makeRequest('GET', "https://api.cloudinary.com/v1_1/{$cloudName}/account.json", [], [
                'Authorization' => 'Basic ' . base64_encode($apiKey . ':' . $this->getApiKey('api_secret'))
            ]);

            return [
                'success' => $response['success'],
                'message' => $response['success'] ? 'Cloudinary connection successful' : 'Failed to connect to Cloudinary',
                'data' => $response['data'] ?? []
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Test failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Upload image
     */
    public function uploadImage(string $filePath, array $options = []): array
    {
        $cloudName = $this->getConfig('cloud_name');
        $apiKey = $this->getApiKey('api_key');
        $apiSecret = $this->getApiKey('api_secret');
        
        $defaultOptions = [
            'folder' => $this->getConfig('upload_folder', 'clinic_uploads'),
            'transformation' => $this->getConfig('default_transformation', 'w_1200,q_auto,f_auto'),
            'quality' => 'auto',
            'format' => 'auto'
        ];
        
        $options = array_merge($defaultOptions, $options);

        // For file uploads, we need to use multipart form data
        $curl = curl_init();
        
        $postFields = array_merge([
            'file' => new \CURLFile($filePath),
            'api_key' => $apiKey,
            'timestamp' => time(),
            'folder' => $options['folder']
        ], $options);

        // Generate signature for security
        $toSign = $this->generateSignature($postFields, $apiSecret);
        $postFields['signature'] = $toSign;

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.cloudinary.com/v1_1/{$cloudName}/image/upload",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postFields,
            CURLOPT_TIMEOUT => 30
        ));

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $result = json_decode($response, true);
        $success = $httpCode === 200;

        if ($success) {
            $this->log('image_uploaded', [
                'public_id' => $result['public_id'],
                'url' => $result['secure_url'],
                'format' => $result['format'],
                'size' => $result['bytes']
            ]);
        }

        return [
            'success' => $success,
            'data' => $result,
            'url' => $result['secure_url'] ?? '',
            'public_id' => $result['public_id'] ?? '',
            'error' => $success ? null : $result['error']['message'] ?? 'Upload failed'
        ];
    }

    /**
     * Upload image from URL
     */
    public function uploadFromUrl(string $imageUrl, array $options = []): array
    {
        $cloudName = $this->getConfig('cloud_name');
        $apiKey = $this->getApiKey('api_key');
        $apiSecret = $this->getApiKey('api_secret');
        
        $defaultOptions = [
            'folder' => $this->getConfig('upload_folder', 'clinic_uploads'),
            'transformation' => 'w_1200,q_auto,f_auto',
            'quality' => 'auto',
            'format' => 'auto'
        ];
        
        $options = array_merge($defaultOptions, $options);

        $postFields = array_merge([
            'file' => $imageUrl,
            'api_key' => $apiKey,
            'timestamp' => time(),
            'folder' => $options['folder']
        ], $options);

        $toSign = $this->generateSignature($postFields, $apiSecret);
        $postFields['signature'] = $toSign;

        $response = $this->makeRequest('POST', "https://api.cloudinary.com/v1_1/{$cloudName}/image/upload", $postFields);

        if ($response['success']) {
            $this->log('image_uploaded_from_url', [
                'source_url' => $imageUrl,
                'public_id' => $response['data']['public_id'],
                'url' => $response['data']['secure_url']
            ]);
        }

        return [
            'success' => $response['success'],
            'data' => $response['data'],
            'url' => $response['data']['secure_url'] ?? '',
            'public_id' => $response['data']['public_id'] ?? '',
            'error' => $response['success'] ? null : 'Upload failed'
        ];
    }

    /**
     * Generate optimized image URL
     */
    public function generateUrl(string $publicId, array $transformations = []): string
    {
        $cloudName = $this->getConfig('cloud_name');
        
        $defaultTransforms = [
            'w' => 800,
            'q' => 'auto',
            'f' => 'auto',
            'dpr' => 'auto'
        ];
        
        $transforms = array_merge($defaultTransforms, $transformations);
        
        $transformString = implode(',', array_map(function($key, $value) {
            return "{$key}_{$value}";
        }, array_keys($transforms), $transforms));
        
        return "https://res.cloudinary.com/{$cloudName}/image/upload/{$transformString}/{$publicId}";
    }

    /**
     * Generate thumbnail URL
     */
    public function generateThumbnail(string $publicId, int $width = 150, int $height = 150): string
    {
        return $this->generateUrl($publicId, [
            'w' => $width,
            'h' => $height,
            'c' => 'thumb',
            'g' => 'face'
        ]);
    }

    /**
     * Delete image
     */
    public function deleteImage(string $publicId): array
    {
        $cloudName = $this->getConfig('cloud_name');
        $apiKey = $this->getApiKey('api_key');
        $apiSecret = $this->getApiKey('api_secret');
        
        $timestamp = time();
        $toSign = 'public_id=' . $publicId . '&timestamp=' . $timestamp . $apiSecret;
        $signature = sha1($toSign);
        
        $postFields = [
            'public_id' => $publicId,
            'api_key' => $apiKey,
            'timestamp' => $timestamp,
            'signature' => $signature
        ];

        $response = $this->makeRequest('POST', "https://api.cloudinary.com/v1_1/{$cloudName}/image/destroy", $postFields);

        if ($response['success']) {
            $this->log('image_deleted', ['public_id' => $publicId]);
        }

        return [
            'success' => $response['success'],
            'data' => $response['data'],
            'error' => $response['success'] ? null : 'Delete failed'
        ];
    }

    /**
     * Search images
     */
    public function searchImages(string $query, array $options = []): array
    {
        $cloudName = $this->getConfig('cloud_name');
        $apiKey = $this->getApiKey('api_key');
        $apiSecret = $this->getApiKey('api_secret');
        
        $defaultOptions = [
            'max_results' => 50,
            'sort_by' => 'created_at',
            'direction' => 'desc'
        ];
        
        $options = array_merge($defaultOptions, $options);

        // For search, we need to use the Search API
        $curl = curl_init();
        
        $searchData = [
            'expression' => $query,
            'max_results' => $options['max_results'],
            'sort_by' => [[$options['sort_by'] => $options['direction']]]
        ];

        $jsonData = json_encode($searchData);
        $timestamp = time();
        $toSign = $jsonData . $timestamp . $apiSecret;
        $signature = hash('sha256', $toSign);

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.cloudinary.com/v1_1/{$cloudName}/resources/search",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $jsonData,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'X-Cld-Timestamp: ' . $timestamp,
                'X-Cld-Signature: ' . $signature,
                'Authorization' => 'Basic ' . base64_encode($apiKey)
            ),
            CURLOPT_TIMEOUT => 30
        ));

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $result = json_decode($response, true);
        $success = $httpCode === 200;

        return [
            'success' => $success,
            'data' => $result,
            'images' => $result['resources'] ?? [],
            'total_count' => $result['total_count'] ?? 0,
            'error' => $success ? null : 'Search failed'
        ];
    }

    /**
     * Generate video URL
     */
    public function generateVideoUrl(string $publicId, array $transformations = []): string
    {
        $cloudName = $this->getConfig('cloud_name');
        
        $defaultTransforms = [
            'w' => 800,
            'q' => 'auto',
            'f' => 'mp4'
        ];
        
        $transforms = array_merge($defaultTransforms, $transformations);
        
        $transformString = implode(',', array_map(function($key, $value) {
            return "{$key}_{$value}";
        }, array_keys($transforms), $transforms));
        
        return "https://res.cloudinary.com/{$cloudName}/video/upload/{$transformString}/{$publicId}";
    }

    /**
     * Add image overlay/watermark
     */
    public function addWatermark(string $publicId, string $watermarkPublicId, array $position = []): string
    {
        $defaultPosition = [
            'gravity' => 'south_east',
            'x' => 10,
            'y' => 10
        ];
        
        $position = array_merge($defaultPosition, $position);
        
        $positionString = "g_{$position['gravity']}";
        if (isset($position['x'])) $positionString .= ",x_{$position['x']}";
        if (isset($position['y'])) $positionString .= ",y_{$position['y']}";
        
        return $this->generateUrl($publicId, [
            'l' => $watermarkPublicId,
            'fl' => 'layer_apply',
            'e' => $positionString
        ]);
    }

    /**
     * Generate signature for API calls
     */
    private function generateSignature(array $params, string $apiSecret): string
    {
        // Remove file and signature from parameters for signing
        $paramsToSign = array_diff_key($params, ['file' => '', 'signature' => '']);
        
        // Sort parameters alphabetically
        ksort($paramsToSign);
        
        // Create signature string
        $signatureString = '';
        foreach ($paramsToSign as $key => $value) {
            if ($value !== '') {
                $signatureString .= $key . $value;
            }
        }
        
        // Add API secret and hash
        return sha1($signatureString . $apiSecret);
    }

    /**
     * Get image metadata
     */
    public function getImageMetadata(string $publicId): array
    {
        $cloudName = $this->getConfig('cloud_name');
        $apiKey = $this->getApiKey('api_key');
        $apiSecret = $this->getApiKey('api_secret');
        
        $timestamp = time();
        $toSign = 'public_id=' . $publicId . '&timestamp=' . $timestamp . $apiSecret;
        $signature = sha1($toSign);

        $response = $this->makeRequest('GET', "https://api.cloudinary.com/v1_1/{$cloudName}/resources/image/upload", [
            'public_id' => $publicId,
            'api_key' => $apiKey,
            'timestamp' => $timestamp,
            'signature' => $signature
        ]);

        return [
            'success' => $response['success'],
            'data' => $response['data'] ?? [],
            'metadata' => $response['data']['image'] ?? []
        ];
    }

    /**
     * Auto-optimize image
     */
    public function optimizeImage(string $publicId, array $options = []): string
    {
        $defaultOptions = [
            'q' => 'auto:good',
            'f' => 'auto',
            'w' => 1200,
            'h' => 800,
            'c' => 'limit'
        ];
        
        $options = array_merge($defaultOptions, $options);
        
        return $this->generateUrl($publicId, $options);
    }
}