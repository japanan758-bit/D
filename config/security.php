<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Security Configuration
    |--------------------------------------------------------------------------
    |
    | إعدادات الأمان لنظام إدارة العيادة
    |
    */

    'password_policy' => [
        'min_length' => 8,
        'require_uppercase' => true,
        'require_lowercase' => true,
        'require_numbers' => true,
        'require_symbols' => false,
    ],

    'session_security' => [
        'timeout' => 7200, // 2 hours
        'regenerate_on_login' => true,
        'invalidate_on_logout' => true,
    ],

    'rate_limiting' => [
        'login_attempts' => 5,
        'login_window' => 15, // minutes
        'api_requests' => 100,
        'api_window' => 60, // minutes
    ],

    'file_upload' => [
        'max_size' => 10 * 1024 * 1024, // 10MB
        'allowed_extensions' => ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'],
        'allowed_mime_types' => [
            'image/jpeg',
            'image/png',
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ],
    ],

    'data_encryption' => [
        'enabled' => true,
        'key_rotation_days' => 90,
        'fields_to_encrypt' => [
            'patients.phone',
            'patients.email',
            'patients.address',
            'appointments.notes',
        ],
    ],

    'audit_logging' => [
        'enabled' => true,
        'track_user_actions' => true,
        'track_data_changes' => true,
        'retention_days' => 365,
    ],

    'backup_security' => [
        'encrypt_backups' => true,
        'compress_backups' => true,
        'delete_old_backups' => true,
        'backup_retention_days' => 30,
    ],

    'api_security' => [
        'require_api_keys' => true,
        'api_key_expiry_days' => 365,
        'https_only' => true,
        'cors_enabled' => true,
    ],

    'maintenance_mode' => [
        'allowed_ips' => [], // Allow from all IPs
        'allowed_users' => [], // Allow specific user IDs
        'maintenance_message' => 'الموقع تحت الصيانة حالياً. يرجى المحاولة لاحقاً.',
    ],

    'content_security' => [
        'enable_xss_protection' => true,
        'enable_csrf_protection' => true,
        'allowed_html_tags' => ['<p>', '<br>', '<strong>', '<em>', '<ul>', '<ol>', '<li>'],
        'blocked_html_attributes' => ['style', 'onload', 'onclick', 'onerror'],
    ],

    'database_security' => [
        'enable_query_logging' => false, // Only enable in development
        'sanitize_inputs' => true,
        'validate_foreign_keys' => true,
    ],

    'notification_security' => [
        'encrypt_sensitive_data' => true,
        'limit_notification_frequency' => true,
        'rate_limit_per_hour' => 10,
    ],

    'account_security' => [
        'enable_two_factor' => false, // Will be enabled in future versions
        'enable_password_reset' => true,
        'enable_account_lockout' => true,
        'lockout_attempts' => 3,
        'lockout_duration' => 30, // minutes
    ],

    'system_security' => [
        'hide_server_information' => true,
        'disable_server_signature' => true,
        'block_suspicious_requests' => true,
        'enable_firewall' => true,
    ],

];