<?php

namespace App\Services\Integrations;

use App\Services\BaseIntegrationService;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class FirebaseService extends BaseIntegrationService
{
    protected $firebase;
    protected $messaging;
    protected $storage;
    protected $database;

    public function initialize(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        try {
            $credentialsPath = storage_path('app/firebase_credentials.json');
            
            // Create credentials file from config
            $credentialsData = [
                'type' => 'service_account',
                'project_id' => $this->getConfig('project_id'),
                'private_key_id' => $this->getConfig('private_key_id'),
                'private_key' => $this->getApiKey('private_key'),
                'client_email' => $this->getConfig('client_email'),
                'client_id' => $this->getConfig('client_id'),
                'auth_uri' => 'https://accounts.google.com/o/oauth2/auth',
                'token_uri' => 'https://oauth2.googleapis.com/token',
                'auth_provider_x509_cert_url' => 'https://www.googleapis.com/oauth2/v1/certs',
                'client_x509_cert_url' => $this->getConfig('client_x509_cert_url')
            ];

            file_put_contents($credentialsPath, json_encode($credentialsData, JSON_PRETTY_PRINT));

            $factory = (new Factory)
                ->withServiceAccount($credentialsPath)
                ->withDatabaseUri($this->getConfig('database_url'));

            $this->firebase = $factory->create();
            $this->messaging = $this->firebase->getMessaging();
            $this->storage = $this->firebase->getStorage();
            $this->database = $this->firebase->getDatabase();

            $this->log('initialized', [
                'project_id' => $this->getConfig('project_id'),
                'database_url' => $this->getConfig('database_url')
            ]);
            
            return true;

        } catch (\Exception $e) {
            Log::error('Firebase initialization failed', ['error' => $e->getMessage()]);
            return false;
        }
    }

    public function validate(): bool
    {
        $projectId = $this->getConfig('project_id');
        $privateKey = $this->getApiKey('private_key');
        $clientEmail = $this->getConfig('client_email');
        $databaseUrl = $this->getConfig('database_url');

        return !empty($projectId) && !empty($privateKey) && !empty($clientEmail) && !empty($databaseUrl);
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
            // Test database connection
            $testRef = $this->database->getReference('test_connection');
            $testRef->set(['timestamp' => now()->toISOString(), 'test' => true]);
            
            $result = $testRef->getValue();
            $testRef->remove(); // Clean up

            return [
                'success' => true,
                'message' => 'Firebase connection successful',
                'data' => ['connection_test' => $result]
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Firebase test failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Send push notification
     */
    public function sendNotification(array $notificationData): array
    {
        try {
            $message = \Kreait\Firebase\Messaging\Notification::create(
                $notificationData['title'],
                $notificationData['body']
            );

            $config = \Kreait\Firebase\Messaging\AndroidConfig::create([
                'priority' => 'high',
                'notification' => [
                    'icon' => $notificationData['icon'] ?? 'notification_icon',
                    'color' => $notificationData['color'] ?? '#FF6B35',
                    'sound' => $notificationData['sound'] ?? 'default'
                ]
            ]);

            $data = $notificationData['data'] ?? [];
            
            if (isset($notificationData['topic'])) {
                $message = $this->messaging->sendToTopic($notificationData['topic'], $message, $data, $config);
            } elseif (isset($notificationData['token'])) {
                $message = $this->messaging->send($message, $notificationData['token'], $data, $config);
            } elseif (isset($notificationData['tokens'])) {
                $message = $this->messaging->sendMulticast($message, $notificationData['tokens'], $data, $config);
            } else {
                throw new \Exception('No recipient specified (token, tokens, or topic)');
            }

            $this->log('notification_sent', [
                'title' => $notificationData['title'],
                'body' => $notificationData['body'],
                'type' => isset($notificationData['topic']) ? 'topic' : 'token'
            ]);

            return [
                'success' => true,
                'message_id' => $message->messageId(),
                'data' => [
                    'success_count' => $message->successCount(),
                    'failure_count' => $message->failureCount()
                ]
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Send appointment reminder notification
     */
    public function sendAppointmentReminder(array $appointmentData): array
    {
        $notificationData = [
            'title' => 'تذكير بموعدك غداً! ⏰',
            'body' => "موعدك مع د. {$appointmentData['doctor_name']}\n" .
                     "التاريخ: {$appointmentData['appointment_date']}\n" .
                     "الوقت: {$appointmentData['appointment_time']}",
            'data' => [
                'type' => 'appointment_reminder',
                'appointment_id' => $appointmentData['appointment_id'],
                'action' => 'open_appointment'
            ],
            'icon' => 'appointment_icon',
            'color' => '#FF6B35'
        ];

        if (isset($appointmentData['user_token'])) {
            $notificationData['token'] = $appointmentData['user_token'];
        }

        return $this->sendNotification($notificationData);
    }

    /**
     * Subscribe device to topic
     */
    public function subscribeToTopic(string $token, string $topic): array
    {
        try {
            $this->messaging->subscribeToTopic($token, $topic);

            $this->log('subscribed_to_topic', ['token' => $token, 'topic' => $topic]);

            return [
                'success' => true,
                'message' => "Successfully subscribed to {$topic}"
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Unsubscribe device from topic
     */
    public function unsubscribeFromTopic(string $token, string $topic): array
    {
        try {
            $this->messaging->unsubscribeFromTopic($token, $topic);

            $this->log('unsubscribed_from_topic', ['token' => $token, 'topic' => $topic]);

            return [
                'success' => true,
                'message' => "Successfully unsubscribed from {$topic}"
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Store data in Firebase Realtime Database
     */
    public function storeData(string $path, array $data): array
    {
        try {
            $ref = $this->database->getReference($path);
            $result = $ref->set($data);

            $this->log('data_stored', ['path' => $path, 'data_keys' => array_keys($data)]);

            return [
                'success' => true,
                'data' => $result,
                'path' => $path
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get data from Firebase Realtime Database
     */
    public function getData(string $path): array
    {
        try {
            $ref = $this->database->getReference($path);
            $data = $ref->getValue();

            return [
                'success' => true,
                'data' => $data,
                'path' => $path
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Update data in Firebase Realtime Database
     */
    public function updateData(string $path, array $data): array
    {
        try {
            $ref = $this->database->getReference($path);
            $result = $ref->update($data);

            $this->log('data_updated', ['path' => $path, 'updated_keys' => array_keys($data)]);

            return [
                'success' => true,
                'data' => $result,
                'path' => $path
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Delete data from Firebase Realtime Database
     */
    public function deleteData(string $path): array
    {
        try {
            $ref = $this->database->getReference($path);
            $ref->remove();

            $this->log('data_deleted', ['path' => $path]);

            return [
                'success' => true,
                'path' => $path
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Upload file to Firebase Storage
     */
    public function uploadFile(string $localPath, string $firebasePath, array $metadata = []): array
    {
        try {
            $bucket = $this->storage->getBucket();
            $object = $bucket->upload(fopen($localPath, 'r'), [
                'name' => $firebasePath,
                'metadata' => $metadata
            ]);

            $this->log('file_uploaded', [
                'local_path' => $localPath,
                'firebase_path' => $firebasePath,
                'size' => $object->size()
            ]);

            return [
                'success' => true,
                'bucket' => $bucket->name(),
                'name' => $object->name(),
                'size' => $object->size(),
                'public_url' => "https://firebasestorage.googleapis.com/v0/b/{$bucket->name()}/o/" . 
                               urlencode($object->name()) . "?alt=media"
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Delete file from Firebase Storage
     */
    public function deleteFile(string $firebasePath): array
    {
        try {
            $bucket = $this->storage->getBucket();
            $object = $bucket->object($firebasePath);
            $object->delete();

            $this->log('file_deleted', ['firebase_path' => $firebasePath]);

            return [
                'success' => true,
                'path' => $firebasePath
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Generate signed URL for file access
     */
    public function generateSignedUrl(string $firebasePath, int $expiresInSeconds = 3600): array
    {
        try {
            $bucket = $this->storage->getBucket();
            $object = $bucket->object($firebasePath);
            $signedUrl = $object->signedUrl(new \DateTime("+{$expiresInSeconds} seconds"));

            return [
                'success' => true,
                'url' => $signedUrl,
                'expires_at' => now()->addSeconds($expiresInSeconds)->toISOString(),
                'path' => $firebasePath
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Store user session data
     */
    public function storeUserSession(string $userId, array $sessionData): array
    {
        $path = "users/{$userId}/sessions/" . now()->format('Y-m-d_H-i-s');
        
        $data = array_merge($sessionData, [
            'created_at' => now()->toISOString(),
            'user_agent' => request()->userAgent(),
            'ip_address' => request()->ip()
        ]);

        return $this->storeData($path, $data);
    }

    /**
     * Get user notifications history
     */
    public function getUserNotifications(string $userId, int $limit = 50): array
    {
        $path = "users/{$userId}/notifications";
        
        try {
            $ref = $this->database->getReference($path)
                ->orderByChild('timestamp')
                ->limitToLast($limit);
            
            $data = $ref->getValue();

            return [
                'success' => true,
                'notifications' => $data ?: [],
                'count' => is_array($data) ? count($data) : 0
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Store clinic analytics data
     */
    public function storeAnalytics(string $date, array $analyticsData): array
    {
        $path = "analytics/{$date}";
        
        return $this->updateData($path, $analyticsData);
    }

    /**
     * Real-time database listener
     */
    public function listenToPath(string $path, callable $callback): void
    {
        $ref = $this->database->getReference($path);
        $ref->on('value', function ($snapshot) use ($callback) {
            $callback($snapshot->val());
        });
    }
}