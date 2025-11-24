<?php

namespace App\Services\Integrations;

use App\Services\BaseIntegrationService;
use Stripe\StripeClient;

class PaymentService extends BaseIntegrationService
{
    public function initialize(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $this->log('initialized', [
            'provider' => $this->getConfig('provider'),
            'environment' => $this->getConfig('environment', 'test')
        ]);
        
        return true;
    }

    public function validate(): bool
    {
        $provider = $this->getConfig('provider');
        
        switch ($provider) {
            case 'stripe':
                return !empty($this->getApiKey('stripe_secret_key'));
            case 'paymob':
                return !empty($this->getApiKey('paymob_api_key'));
            case 'fawry':
                return !empty($this->getApiKey('fawry_security_key')) && 
                       !empty($this->getConfig('fawry_merchant_code'));
            default:
                return false;
        }
    }

    public function test(): array
    {
        if (!$this->isReady()) {
            return [
                'success' => false,
                'message' => 'Integration is not ready. Check configuration.'
            ];
        }

        $provider = $this->getConfig('provider');
        
        switch ($provider) {
            case 'stripe':
                return $this->testStripe();
            case 'paymob':
                return $this->testPaymob();
            case 'fawry':
                return $this->testFawry();
            default:
                return [
                    'success' => false,
                    'message' => 'Unknown payment provider'
                ];
        }
    }

    /**
     * Create payment intent
     */
    public function createPayment(array $paymentData): array
    {
        $provider = $this->getConfig('provider');
        
        switch ($provider) {
            case 'stripe':
                return $this->createStripePayment($paymentData);
            case 'paymob':
                return $this->createPaymobPayment($paymentData);
            case 'fawry':
                return $this->createFawryPayment($paymentData);
            default:
                return [
                    'success' => false,
                    'error' => 'Unknown payment provider'
                ];
        }
    }

    /**
     * Verify payment status
     */
    public function verifyPayment(string $paymentId): array
    {
        $provider = $this->getConfig('provider');
        
        switch ($provider) {
            case 'stripe':
                return $this->verifyStripePayment($paymentId);
            case 'paymob':
                return $this->verifyPaymobPayment($paymentId);
            case 'fawry':
                return $this->verifyFawryPayment($paymentId);
            default:
                return [
                    'success' => false,
                    'error' => 'Unknown payment provider'
                ];
        }
    }

    /**
     * Process refund
     */
    public function refundPayment(string $paymentId, float $amount = null): array
    {
        $provider = $this->getConfig('provider');
        
        switch ($provider) {
            case 'stripe':
                return $this->refundStripePayment($paymentId, $amount);
            case 'paymob':
                return $this->refundPaymobPayment($paymentId, $amount);
            case 'fawry':
                return $this->refundFawryPayment($paymentId, $amount);
            default:
                return [
                    'success' => false,
                    'error' => 'Unknown payment provider'
                ];
        }
    }

    /**
     * Test Stripe connection
     */
    private function testStripe(): array
    {
        try {
            $stripe = new StripeClient($this->getApiKey('stripe_secret_key'));
            $balance = $stripe->balance->retrieve();
            
            return [
                'success' => true,
                'message' => 'Stripe connection successful',
                'data' => ['available_balance' => $balance->available[0]->amount ?? 0]
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Stripe test failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Create Stripe payment
     */
    private function createStripePayment(array $paymentData): array
    {
        try {
            $stripe = new StripeClient($this->getApiKey('stripe_secret_key'));
            
            $paymentIntent = $stripe->paymentIntents->create([
                'amount' => $paymentData['amount'] * 100, // Convert to cents
                'currency' => $paymentData['currency'] ?? 'sar',
                'metadata' => [
                    'appointment_id' => $paymentData['appointment_id'] ?? '',
                    'patient_name' => $paymentData['patient_name'] ?? '',
                    'service_type' => $paymentData['service_type'] ?? ''
                ],
                'description' => $paymentData['description'] ?? 'Clinic Appointment Payment',
                'receipt_email' => $paymentData['patient_email'] ?? null
            ]);

            $this->log('payment_created', [
                'payment_id' => $paymentIntent->id,
                'amount' => $paymentData['amount'],
                'currency' => $paymentData['currency'] ?? 'sar'
            ]);

            return [
                'success' => true,
                'client_secret' => $paymentIntent->client_secret,
                'payment_id' => $paymentIntent->id,
                'status' => $paymentIntent->status
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Verify Stripe payment
     */
    private function verifyStripePayment(string $paymentId): array
    {
        try {
            $stripe = new StripeClient($this->getApiKey('stripe_secret_key'));
            $paymentIntent = $stripe->paymentIntents->retrieve($paymentId);

            return [
                'success' => true,
                'status' => $paymentIntent->status,
                'amount' => $paymentIntent->amount / 100,
                'currency' => $paymentIntent->currency,
                'paid' => $paymentIntent->status === 'succeeded',
                'data' => $paymentIntent->toArray()
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Refund Stripe payment
     */
    private function refundStripePayment(string $paymentId, float $amount = null): array
    {
        try {
            $stripe = new StripeClient($this->getApiKey('stripe_secret_key'));
            
            $refundData = [
                'payment_intent' => $paymentId,
                'metadata' => [
                    'refund_reason' => 'Clinic cancellation'
                ]
            ];

            if ($amount) {
                $refundData['amount'] = $amount * 100;
            }

            $refund = $stripe->refunds->create($refundData);

            $this->log('payment_refunded', [
                'payment_id' => $paymentId,
                'refund_id' => $refund->id,
                'amount' => $amount
            ]);

            return [
                'success' => true,
                'refund_id' => $refund->id,
                'status' => $refund->status
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Test Paymob connection
     */
    private function testPaymob(): array
    {
        try {
            $apiKey = $this->getApiKey('paymob_api_key');
            
            // Get authentication token
            $authResponse = $this->makeRequest('POST', 'https://accept.paymob.com/api/auth/tokens', [
                'api_key' => $apiKey
            ]);

            if (!$authResponse['success']) {
                throw new \Exception('Failed to authenticate with Paymob');
            }

            $this->log('test_paymob', ['authenticated' => true]);

            return [
                'success' => true,
                'message' => 'Paymob connection successful',
                'data' => ['auth_token' => $authResponse['data']['token'] ?? '']
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Paymob test failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Create Paymob payment
     */
    private function createPaymobPayment(array $paymentData): array
    {
        $apiKey = $this->getApiKey('paymob_api_key');
        $integrationId = $this->getConfig('paymob_integration_id');
        $billingData = $paymentData['billing_data'] ?? [];

        // First, get authentication token
        $authResponse = $this->makeRequest('POST', 'https://accept.paymob.com/api/auth/tokens', [
            'api_key' => $apiKey
        ]);

        if (!$authResponse['success']) {
            return [
                'success' => false,
                'error' => 'Authentication failed'
            ];
        }

        $authToken = $authResponse['data']['token'];

        // Prepare billing data
        $billingData = array_merge([
            'apartment' => 'NA',
            'email' => $paymentData['patient_email'] ?? 'customer@example.com',
            'floor' => 'NA',
            'street' => 'NA',
            'building' => 'NA',
            'phone_number' => $paymentData['patient_phone'] ?? '+2000000000000',
            'shipping_method' => 'NA',
            'postal_code' => 'NA',
            'city' => 'NA',
            'country' => 'SA',
            'last_name' => $paymentData['patient_name'] ?? 'Customer',
            'first_name' => $paymentData['patient_name'] ?? 'Customer',
            'description' => $paymentData['description'] ?? 'Clinic Appointment'
        ], $billingData);

        // Create order
        $orderData = [
            'auth_token' => $authToken,
            'amount_cents' => $paymentData['amount'] * 100,
            'expiration' => 3600,
            'billing_data' => $billingData,
            'currency' => 'EGP',
            'items' => [[
                'name' => 'Clinic Appointment',
                'amount' => $paymentData['amount'],
                'description' => $paymentData['description'] ?? 'Medical consultation'
            ]]
        ];

        $orderResponse = $this->makeRequest('POST', 'https://accept.paymob.com/api/ecommerce/orders', $orderData);

        if (!$orderResponse['success']) {
            return [
                'success' => false,
                'error' => 'Failed to create order'
            ];
        }

        $orderId = $orderResponse['data']['id'];

        // Create payment key
        $paymentKeyData = [
            'auth_token' => $authToken,
            'amount_cents' => $paymentData['amount'] * 100,
            'expiration' => 3600,
            'order_id' => $orderId,
            'billing_data' => $billingData,
            'integration_id' => $integrationId
        ];

        $paymentKeyResponse = $this->makeRequest('POST', 'https://accept.paymob.com/api/acceptance/payment_keys', $paymentKeyData);

        if (!$paymentKeyResponse['success']) {
            return [
                'success' => false,
                'error' => 'Failed to create payment key'
            ];
        }

        return [
            'success' => true,
            'payment_token' => $paymentKeyResponse['data']['token'],
            'order_id' => $orderId
        ];
    }

    /**
     * Verify Paymob payment
     */
    private function verifyPaymobPayment(string $paymentId): array
    {
        $apiKey = $this->getApiKey('paymob_api_key');

        $response = $this->makeRequest('GET', "https://accept.paymob.com/api/acceptance/transaction/{$paymentId}", [
            'api_key' => $apiKey
        ]);

        if (!$response['success']) {
            return [
                'success' => false,
                'error' => 'Failed to verify payment'
            ];
        }

        $transaction = $response['data'];
        $success = in_array($transaction['data']['status'], ['CAPTURED', 'SUCCESS']);

        return [
            'success' => $success,
            'status' => $transaction['data']['status'],
            'amount' => $transaction['data']['amount'] / 100,
            'currency' => $transaction['data']['currency'] ?? 'EGP',
            'paid' => $success,
            'data' => $transaction
        ];
    }

    /**
     * Refund Paymob payment
     */
    private function refundPaymobPayment(string $paymentId, float $amount = null): array
    {
        $apiKey = $this->getApiKey('paymob_api_key');

        $refundData = [
            'api_key' => $apiKey,
            'transaction_id' => $paymentId
        ];

        if ($amount) {
            $refundData['amount_cents'] = $amount * 100;
        }

        $response = $this->makeRequest('POST', 'https://accept.paymob.com/api/acceptance/void_refund/refund', $refundData);

        if ($response['success']) {
            $this->log('payment_refunded', [
                'payment_id' => $paymentId,
                'amount' => $amount
            ]);
        }

        return [
            'success' => $response['success'],
            'data' => $response['data'] ?? []
        ];
    }

    /**
     * Test Fawry connection
     */
    private function testFawry(): array
    {
        // Fawry doesn't have a simple test API, so we'll just check if the configuration is valid
        return [
            'success' => true,
            'message' => 'Fawry configuration is valid',
            'data' => ['merchant_code' => $this->getConfig('fawry_merchant_code')]
        ];
    }

    /**
     * Create Fawry payment
     */
    private function createFawryPayment(array $paymentData): array
    {
        $merchantCode = $this->getConfig('fawry_merchant_code');
        $securityKey = $this->getApiKey('fawry_security_key');

        $timestamp = time() * 1000;
        $signatureString = $merchantCode . 
                          $paymentData['amount'] . 
                          $paymentData['appointment_id'] . 
                          'appointment' . 
                          $timestamp . 
                          $securityKey;
        $signature = hash('sha256', $signatureString);

        $requestData = [
            'merchantCode' => $merchantCode,
            'merchantRefNum' => $paymentData['appointment_id'],
            'paymentMethodId' => 'PAYATFAWRY',
            'amount' => $paymentData['amount'],
            'currency' => 'SAR',
            'language' => 'en-gb',
            'customerProfileId' => $paymentData['patient_email'] ?? 'guest',
            'customerEmail' => $paymentData['patient_email'] ?? '',
            'customerMobile' => $paymentData['patient_phone'] ?? '',
            'items' => [[
                'itemCode' => 'appointment',
                'description' => $paymentData['description'] ?? 'Clinic Appointment',
                'quantity' => 1,
                'price' => $paymentData['amount']
            ]],
            'signature' => $signature,
            'timestamp' => $timestamp
        ];

        $response = $this->makeRequest('POST', 'https://atfawry.fawrystaging.com/ECommerceWeb/Fawry/payments/Pay', $requestData, [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ]);

        return [
            'success' => $response['success'],
            'payment_data' => $response['data'] ?? [],
            'reference_number' => $response['data']['merchantRefNum'] ?? $paymentData['appointment_id']
        ];
    }

    /**
     * Verify Fawry payment
     */
    private function verifyFawryPayment(string $paymentId): array
    {
        $merchantCode = $this->getConfig('fawry_merchant_code');
        $securityKey = $this->getApiKey('fawry_security_key');

        $timestamp = time() * 1000;
        $signatureString = $merchantCode . $paymentId . $timestamp . $securityKey;
        $signature = hash('sha256', $signatureString);

        $response = $this->makeRequest('GET', 'https://atfawry.fawrystaging.com/ECommerceWeb/Fawry/payments/Pay', [
            'merchantCode' => $merchantCode,
            'merchantRefNum' => $paymentId,
            'signature' => $signature,
            'timestamp' => $timestamp
        ]);

        $status = $response['data']['status'] ?? 'UNKNOWN';
        $success = in_array($status, ['PAID', 'SUCCESS']);

        return [
            'success' => $success,
            'status' => $status,
            'paid' => $success,
            'data' => $response['data'] ?? []
        ];
    }

    /**
     * Refund Fawry payment
     */
    private function refundFawryPayment(string $paymentId, float $amount = null): array
    {
        // Fawry refunds are typically handled through their dashboard or separate API
        // This is a simplified implementation
        return [
            'success' => false,
            'error' => 'Refund functionality not implemented for Fawry'
        ];
    }

    /**
     * Get supported currencies
     */
    public function getSupportedCurrencies(): array
    {
        $provider = $this->getConfig('provider');
        
        switch ($provider) {
            case 'stripe':
                return ['SAR', 'USD', 'EUR', 'AED'];
            case 'paymob':
                return ['EGP', 'SAR', 'USD'];
            case 'fawry':
                return ['SAR'];
            default:
                return ['SAR'];
        }
    }
}