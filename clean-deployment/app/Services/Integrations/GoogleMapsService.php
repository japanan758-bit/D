<?php

namespace App\Services\Integrations;

use App\Services\BaseIntegrationService;

class GoogleMapsService extends BaseIntegrationService
{
    public function initialize(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $this->log('initialized', [
            'api_key' => $this->getApiKey('api_key')
        ]);
        
        return true;
    }

    public function validate(): bool
    {
        $apiKey = $this->getApiKey('api_key');
        return !empty($apiKey);
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
            $apiKey = $this->getApiKey('api_key');
            
            // Test geocoding API
            $response = $this->makeRequest('GET', "https://maps.googleapis.com/maps/api/geocode/json", [
                'address' => 'Riyadh, Saudi Arabia',
                'key' => $apiKey
            ]);

            return [
                'success' => $response['success'] && isset($response['data']['results']),
                'message' => $response['success'] ? 'Google Maps API connection successful' : 'Failed to connect to Google Maps API',
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
     * Get clinic location data
     */
    public function getClinicLocation(): array
    {
        $address = $this->getConfig('clinic_address');
        $latitude = $this->getConfig('clinic_latitude');
        $longitude = $this->getConfig('clinic_longitude');
        $placeId = $this->getConfig('clinic_place_id');

        return [
            'address' => $address,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'place_id' => $placeId
        ];
    }

    /**
     * Get directions to clinic
     */
    public function getDirections(string $destination): array
    {
        $apiKey = $this->getApiKey('api_key');
        $clinicLocation = $this->getClinicLocation();

        $response = $this->makeRequest('GET', 'https://maps.googleapis.com/maps/api/directions/json', [
            'origin' => $destination,
            'destination' => $clinicLocation['address'],
            'key' => $apiKey,
            'language' => 'ar',
            'region' => 'SA'
        ]);

        if ($response['success']) {
            $this->log('directions_requested', [
                'destination' => $destination,
                'route_count' => count($response['data']['routes'] ?? [])
            ]);
        }

        return $response;
    }

    /**
     * Search for nearby places
     */
    public function searchNearbyPlaces(string $type, float $latitude = null, float $longitude = null): array
    {
        $apiKey = $this->getApiKey('api_key');
        
        if (!$latitude || !$longitude) {
            $clinicLocation = $this->getClinicLocation();
            $latitude = $clinicLocation['latitude'];
            $longitude = $clinicLocation['longitude'];
        }

        $response = $this->makeRequest('GET', 'https://maps.googleapis.com/maps/api/place/nearbysearch/json', [
            'location' => "{$latitude},{$longitude}",
            'radius' => $this->getConfig('search_radius', 5000),
            'type' => $type,
            'key' => $apiKey,
            'language' => 'ar'
        ]);

        return $response;
    }

    /**
     * Get place details by place ID
     */
    public function getPlaceDetails(string $placeId): array
    {
        $apiKey = $this->getApiKey('api_key');

        $response = $this->makeRequest('GET', 'https://maps.googleapis.com/maps/api/place/details/json', [
            'place_id' => $placeId,
            'fields' => 'name,formatted_address,geometry,rating,formatted_phone_number,opening_hours,website',
            'key' => $apiKey,
            'language' => 'ar'
        ]);

        return $response;
    }

    /**
     * Calculate distance between two points
     */
    public function calculateDistance(float $lat1, float $lng1, float $lat2, float $lng2): array
    {
        // Use Haversine formula for distance calculation
        $earthRadius = 6371; // Earth's radius in kilometers

        $lat1 = deg2rad($lat1);
        $lat2 = deg2rad($lat2);
        $deltaLat = deg2rad($lat2 - $lat1);
        $deltaLng = deg2rad($lng2 - $lng1);

        $a = sin($deltaLat/2) * sin($deltaLat/2) +
             cos($lat1) * cos($lat2) * sin($deltaLng/2) * sin($deltaLng/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));

        $distanceKm = $earthRadius * $c;
        $distanceMiles = $distanceKm * 0.621371;

        return [
            'distance_km' => round($distanceKm, 2),
            'distance_miles' => round($distanceMiles, 2),
            'distance_meters' => round($distanceKm * 1000)
        ];
    }

    /**
     * Get static map image URL
     */
    public function getStaticMapUrl(float $lat = null, float $lng = null, int $zoom = 15): string
    {
        $apiKey = $this->getApiKey('api_key');
        
        if (!$lat || !$lng) {
            $clinicLocation = $this->getClinicLocation();
            $lat = $clinicLocation['latitude'];
            $lng = $clinicLocation['longitude'];
        }

        $size = $this->getConfig('map_size', '600x400');
        $markers = $this->getConfig('map_markers', 'color:red');

        return "https://maps.googleapis.com/maps/api/staticmap?center={$lat},{$lng}&zoom={$zoom}&size={$size}&markers={$markers}&key={$apiKey}";
    }

    /**
     * Get embed map HTML
     */
    public function getEmbedMap(float $lat = null, float $lng = null, int $zoom = 15): string
    {
        $apiKey = $this->getApiKey('api_key');
        
        if (!$lat || !$lng) {
            $clinicLocation = $this->getClinicLocation();
            $lat = $clinicLocation['latitude'];
            $lng = $clinicLocation['longitude'];
        }

        $size = $this->getConfig('map_size', '600x400');

        return <<<HTML
<iframe 
    width="{$size}" 
    height="{$size}" 
    style="border:0;" 
    loading="lazy" 
    allowfullscreen 
    referrerpolicy="no-referrer-when-downgrade" 
    src="https://www.google.com/maps/embed/v1/place?key={$apiKey}&q={$lat},{$lng}&zoom={$zoom}">
</iframe>
HTML;
    }

    /**
     * Validate clinic location
     */
    public function validateClinicLocation(): array
    {
        $clinicLocation = $this->getClinicLocation();
        
        if (empty($clinicLocation['address']) || 
            empty($clinicLocation['latitude']) || 
            empty($clinicLocation['longitude'])) {
            return [
                'valid' => false,
                'message' => 'Clinic location is not properly configured'
            ];
        }

        // Verify the location using reverse geocoding
        $apiKey = $this->getApiKey('api_key');
        $response = $this->makeRequest('GET', "https://maps.googleapis.com/maps/api/geocode/json", [
            'latlng' => "{$clinicLocation['latitude']},{$clinicLocation['longitude']}",
            'key' => $apiKey,
            'language' => 'ar'
        ]);

        $valid = $response['success'] && !empty($response['data']['results']);

        return [
            'valid' => $valid,
            'formatted_address' => $response['data']['results'][0]['formatted_address'] ?? '',
            'message' => $valid ? 'Location validated successfully' : 'Location validation failed'
        ];
    }
}