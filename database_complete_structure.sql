-- =====================================================
-- CLINIC MANAGEMENT SYSTEM DATABASE STRUCTURE
-- Complete MySQL/MariaDB Database for Hostinger
-- Generated: 2025-11-24 21:30:54
-- Author: MiniMax Agent
-- =====================================================

-- Create database (run this first if needed)
-- CREATE DATABASE IF NOT EXISTS `clinic_system` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USE `clinic_system`;

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

-- =====================================================
-- 1. USERS TABLE (Core User Management)
-- =====================================================
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'user' COMMENT 'admin, doctor, patient, user',
  `status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'active' COMMENT 'active, inactive, suspended',
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `current_team_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_index` (`role`),
  KEY `users_status_index` (`status`),
  KEY `users_team_id_index` (`current_team_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 2. PERSONAL ACCESS TOKENS (for API access)
-- =====================================================
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_last_used_at_index` (`last_used_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 3. CACHE TABLE (for caching system)
-- =====================================================
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 4. JOBS AND JOB BATCHES (Queue System)
-- =====================================================
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancelled_at` int(10) unsigned DEFAULT NULL,
  `created_at` int(10) unsigned NOT NULL,
  `finished_at` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 5. SESSIONS TABLE (Session Management)
-- =====================================================
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 6. DOCTORS TABLE (Medical Staff)
-- =====================================================
DROP TABLE IF EXISTS `doctors`;
CREATE TABLE `doctors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `specialty` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `license_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `experience_years` int(11) DEFAULT 0,
  `qualifications` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `consultation_fee` decimal(10,2) DEFAULT 0.00,
  `available_days` json DEFAULT NULL COMMENT '["sunday", "monday", "tuesday"]',
  `working_hours_start` time DEFAULT '09:00:00',
  `working_hours_end` time DEFAULT '17:00:00',
  `is_available` tinyint(1) DEFAULT 1,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `doctors_license_number_unique` (`license_number`),
  KEY `doctors_specialty_index` (`specialty`),
  KEY `doctors_user_id_index` (`user_id`),
  CONSTRAINT `doctors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 7. SERVICES TABLE (Medical Services)
-- =====================================================
DROP TABLE IF EXISTS `services`;
CREATE TABLE `services` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_ar` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) DEFAULT 0.00,
  `duration_minutes` int(11) DEFAULT 30,
  `category` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `requires_appointment` tinyint(1) DEFAULT 1,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `features` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `services_category_index` (`category`),
  KEY `services_is_active_index` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 8. APPOINTMENTS TABLE (Core Booking System)
-- =====================================================
DROP TABLE IF EXISTS `appointments`;
CREATE TABLE `appointments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `patient_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patient_phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patient_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doctor_id` bigint(20) unsigned DEFAULT NULL,
  `service_id` bigint(20) unsigned DEFAULT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `duration_minutes` int(11) DEFAULT 30,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'pending' COMMENT 'pending, confirmed, cancelled, completed, no_show',
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `patient_notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doctor_notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reminder_sent` tinyint(1) DEFAULT 0,
  `confirmation_sent` tinyint(1) DEFAULT 0,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `cancellation_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `appointments_doctor_id_index` (`doctor_id`),
  KEY `appointments_service_id_index` (`service_id`),
  KEY `appointments_appointment_date_index` (`appointment_date`),
  KEY `appointments_status_index` (`status`),
  KEY `appointments_patient_phone_index` (`patient_phone`),
  CONSTRAINT `appointments_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE SET NULL,
  CONSTRAINT `appointments_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 9. PATIENTS TABLE (Patient Records)
-- =====================================================
DROP TABLE IF EXISTS `patients`;
CREATE TABLE `patients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `patient_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'male, female',
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_contact_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_contact_phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blood_type` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `allergies` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `medical_conditions` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `medications` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `insurance_provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `insurance_number` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `patients_patient_number_unique` (`patient_number`),
  KEY `patients_user_id_index` (`user_id`),
  KEY `patients_phone_index` (`phone`),
  KEY `patients_email_index` (`email`),
  CONSTRAINT `patients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 10. ARTICLES TABLE (Blog/News System)
-- =====================================================
DROP TABLE IF EXISTS `articles`;
CREATE TABLE `articles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `excerpt_ar` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_ar` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `featured_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_id` bigint(20) unsigned DEFAULT NULL,
  `category` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` json DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'draft' COMMENT 'draft, published, archived',
  `is_featured` tinyint(1) DEFAULT 0,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keywords` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `view_count` int(11) DEFAULT 0,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `articles_slug_unique` (`slug`),
  KEY `articles_status_index` (`status`),
  KEY `articles_category_index` (`category`),
  KEY `articles_author_id_index` (`author_id`),
  KEY `articles_is_featured_index` (`is_featured`),
  KEY `articles_published_at_index` (`published_at`),
  CONSTRAINT `articles_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 11. TESTIMONIALS TABLE (Patient Reviews)
-- =====================================================
DROP TABLE IF EXISTS `testimonials`;
CREATE TABLE `testimonials` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `patient_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patient_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` tinyint(1) NOT NULL COMMENT '1 to 5 stars',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_id` bigint(20) unsigned DEFAULT NULL,
  `doctor_id` bigint(20) unsigned DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT 0,
  `is_approved` tinyint(1) DEFAULT 0,
  `patient_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `testimonials_rating_index` (`rating`),
  KEY `testimonials_service_id_index` (`service_id`),
  KEY `testimonials_doctor_id_index` (`doctor_id`),
  KEY `testimonials_is_featured_index` (`is_featured`),
  KEY `testimonials_is_approved_index` (`is_approved`),
  CONSTRAINT `testimonials_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE SET NULL,
  CONSTRAINT `testimonials_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 12. FAQ TABLE (Frequently Asked Questions)
-- =====================================================
DROP TABLE IF EXISTS `faqs`;
CREATE TABLE `faqs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `question` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `question_ar` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer_ar` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `is_featured` tinyint(1) DEFAULT 0,
  `view_count` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `faqs_category_index` (`category`),
  KEY `faqs_is_active_index` (`is_active`),
  KEY `faqs_is_featured_index` (`is_featured`),
  KEY `faqs_display_order_index` (`display_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 13. CONTACT MESSAGES TABLE
-- =====================================================
DROP TABLE IF EXISTS `contact_messages`;
CREATE TABLE `contact_messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'new' COMMENT 'new, read, replied, closed',
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `replied_at` timestamp NULL DEFAULT NULL,
  `replied_by` bigint(20) unsigned DEFAULT NULL,
  `reply_message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_messages_email_index` (`email`),
  KEY `contact_messages_status_index` (`status`),
  KEY `contact_messages_replied_by_index` (`replied_by`),
  CONSTRAINT `contact_messages_replied_by_foreign` FOREIGN KEY (`replied_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 14. SETTINGS TABLE (System Configuration)
-- =====================================================
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value_ar` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'text' COMMENT 'text, textarea, number, boolean, json',
  `group` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT 'general',
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_public` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`),
  KEY `settings_group_index` (`group`),
  KEY `settings_is_public_index` (`is_public`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 15. MEDICAL RECORDS TABLE (Patient Records)
-- =====================================================
DROP TABLE IF EXISTS `medical_records`;
CREATE TABLE `medical_records` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` bigint(20) unsigned NOT NULL,
  `doctor_id` bigint(20) unsigned NOT NULL,
  `appointment_id` bigint(20) unsigned DEFAULT NULL,
  `record_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'diagnosis, prescription, treatment, note, lab_result',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diagnosis` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prescription` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `treatment_notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vital_signs` json DEFAULT NULL COMMENT 'blood_pressure, heart_rate, temperature, weight',
  `lab_results` json DEFAULT NULL,
  `follow_up_date` date DEFAULT NULL,
  `attachments` json DEFAULT NULL,
  `confidential` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `medical_records_patient_id_index` (`patient_id`),
  KEY `medical_records_doctor_id_index` (`doctor_id`),
  KEY `medical_records_appointment_id_index` (`appointment_id`),
  KEY `medical_records_record_type_index` (`record_type`),
  KEY `medical_records_follow_up_date_index` (`follow_up_date`),
  CONSTRAINT `medical_records_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `medical_records_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE,
  CONSTRAINT `medical_records_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 16. API INTEGRATIONS TABLE (Advanced Integration System)
-- =====================================================
DROP TABLE IF EXISTS `api_integrations`;
CREATE TABLE `api_integrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'unique identifier for each integration',
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'human readable name',
  `category` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'analytics, security, communication, storage, payment, marketing, monitoring',
  `configuration` json DEFAULT NULL COMMENT 'stores all configuration keys and values',
  `api_keys` json DEFAULT NULL COMMENT 'encrypted API keys using Laravel cast',
  `is_active` tinyint(1) DEFAULT 0,
  `is_testing` tinyint(1) DEFAULT 1,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `settings` json DEFAULT NULL COMMENT 'additional settings',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `api_integrations_name_unique` (`name`),
  KEY `api_integrations_category_index` (`category`),
  KEY `api_integrations_is_active_index` (`is_active`),
  KEY `api_integrations_is_testing_index` (`is_testing`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 17. INTEGRATION LOGS TABLE (Track Integration Usage)
-- =====================================================
DROP TABLE IF EXISTS `integration_logs`;
CREATE TABLE `integration_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `integration_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'activated, deactivated, updated, used, error, success',
  `data` json DEFAULT NULL COMMENT 'additional data for the action',
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'who performed the action',
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `response_code` int(11) DEFAULT NULL COMMENT 'HTTP response code',
  `response_time` decimal(8,3) DEFAULT NULL COMMENT 'response time in seconds',
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `integration_logs_integration_name_index` (`integration_name`),
  KEY `integration_logs_action_index` (`action`),
  KEY `integration_logs_user_id_index` (`user_id`),
  KEY `integration_logs_created_at_index` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 18. INTEGRATION STATS TABLE (Performance Metrics)
-- =====================================================
DROP TABLE IF EXISTS `integration_stats`;
CREATE TABLE `integration_stats` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `integration_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `metrics` json NOT NULL COMMENT 'usage counts, response times, success rate, error count, etc.',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `integration_stats_integration_name_date_unique` (`integration_name`,`date`),
  KEY `integration_stats_date_index` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 19. THEMES TABLE (Theme Management)
-- =====================================================
DROP TABLE IF EXISTS `themes`;
CREATE TABLE `themes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '1.0.0',
  `author` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 0,
  `is_default` tinyint(1) DEFAULT 0,
  `configuration` json DEFAULT NULL,
  `css_variables` json DEFAULT NULL,
  `preview_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `themes_name_unique` (`name`),
  KEY `themes_is_active_index` (`is_active`),
  KEY `themes_is_default_index` (`is_default`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 20. PAGE TEMPLATES TABLE (Page Builder)
-- =====================================================
DROP TABLE IF EXISTS `page_templates`;
CREATE TABLE `page_templates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'home, about, service, contact, custom',
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `layout_data` json NOT NULL,
  `preview_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `page_templates_type_index` (`type`),
  KEY `page_templates_is_active_index` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 21. PAGE BUILDER COMPONENTS TABLE (Dynamic Content)
-- =====================================================
DROP TABLE IF EXISTS `page_builder_components`;
CREATE TABLE `page_builder_components` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'hero, text, image, button, form, gallery, video',
  `category` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `configuration` json DEFAULT NULL,
  `template_data` json DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `preview_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `page_builder_components_type_index` (`type`),
  KEY `page_builder_components_category_index` (`category`),
  KEY `page_builder_components_is_active_index` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 22. ACTIVITY LOG TABLE (System Activity Tracking)
-- =====================================================
DROP TABLE IF EXISTS `activity_log`;
CREATE TABLE `activity_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `log_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` bigint(20) unsigned DEFAULT NULL,
  `causer_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` bigint(20) unsigned DEFAULT NULL,
  `properties` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_log_log_name_index` (`log_name`),
  KEY `activity_log_subject_type_subject_id_index` (`subject_type`,`subject_id`),
  KEY `activity_log_causer_type_causer_id_index` (`causer_type`,`causer_id`),
  KEY `activity_log_created_at_index` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 23. BACKUP TABLES (System Backups)
-- =====================================================
DROP TABLE IF EXISTS `backup_table`;
CREATE TABLE `backup_table` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` bigint(20) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size_encrypted` bigint(20) DEFAULT NULL,
  `encryption_password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `finished_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `backup_table_items`;
CREATE TABLE `backup_table_items` (
  `backup_table_id` bigint(20) unsigned NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` bigint(20) DEFAULT NULL,
  `count` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`backup_table_id`),
  KEY `backup_table_items_backup_table_id_index` (`backup_table_id`),
  CONSTRAINT `backup_table_items_backup_table_id_foreign` FOREIGN KEY (`backup_table_id`) REFERENCES `backup_table` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- FOREIGN KEY RELATIONS
-- =====================================================

-- Appointments foreign keys
ALTER TABLE `appointments` 
ADD CONSTRAINT `appointments_doctor_id_foreign` 
FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE SET NULL;

ALTER TABLE `appointments` 
ADD CONSTRAINT `appointments_service_id_foreign` 
FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE SET NULL;

-- Patients foreign keys
ALTER TABLE `patients` 
ADD CONSTRAINT `patients_user_id_foreign` 
FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

-- Articles foreign keys
ALTER TABLE `articles` 
ADD CONSTRAINT `articles_author_id_foreign` 
FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

-- Testimonials foreign keys
ALTER TABLE `testimonials` 
ADD CONSTRAINT `testimonials_service_id_foreign` 
FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE SET NULL;

ALTER TABLE `testimonials` 
ADD CONSTRAINT `testimonials_doctor_id_foreign` 
FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE SET NULL;

-- Contact Messages foreign keys
ALTER TABLE `contact_messages` 
ADD CONSTRAINT `contact_messages_replied_by_foreign` 
FOREIGN KEY (`replied_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

-- Medical Records foreign keys
ALTER TABLE `medical_records` 
ADD CONSTRAINT `medical_records_patient_id_foreign` 
FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;

ALTER TABLE `medical_records` 
ADD CONSTRAINT `medical_records_doctor_id_foreign` 
FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE;

ALTER TABLE `medical_records` 
ADD CONSTRAINT `medical_records_appointment_id_foreign` 
FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE SET NULL;

-- Backup foreign keys
ALTER TABLE `backup_table_items` 
ADD CONSTRAINT `backup_table_items_backup_table_id_foreign` 
FOREIGN KEY (`backup_table_id`) REFERENCES `backup_table` (`id`) ON DELETE CASCADE;

-- =====================================================
-- SEED DATA (Default Records)
-- =====================================================

-- Insert default admin user
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Dr. Abdelnasser Al-Akhras', 'admin@clinic.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'active', NOW(), NOW());

-- Insert default settings
INSERT INTO `settings` (`key`, `value`, `type`, `group`, `label`, `description`, `is_public`, `created_at`, `updated_at`) VALUES
('clinic_name', 'عيادة د. عبدالناصر الأخصور', 'text', 'general', 'اسم العيادة', 'اسم العيادة بالتفصيل', 1, NOW(), NOW()),
('clinic_address', 'الرياض، المملكة العربية السعودية', 'textarea', 'general', 'عنوان العيادة', 'العنوان الكامل للعيادة', 1, NOW(), NOW()),
('clinic_phone', '+966 50 123 4567', 'text', 'general', 'رقم الهاتف', 'رقم الهاتف الرئيسي', 1, NOW(), NOW()),
('clinic_email', 'info@clinic.com', 'text', 'general', 'البريد الإلكتروني', 'البريد الإلكتروني للعيادة', 1, NOW(), NOW()),
('working_hours_start', '09:00', 'text', 'schedule', 'بداية ساعات العمل', 'وقت بداية العمل', 0, NOW(), NOW()),
('working_hours_end', '17:00', 'text', 'schedule', 'نهاية ساعات العمل', 'وقت نهاية العمل', 0, NOW(), NOW()),
('appointment_duration', '30', 'number', 'schedule', 'مدة الموعد بالدقائق', 'مدة كل موعد بالدقائق', 0, NOW(), NOW()),
('currency', 'SAR', 'text', 'general', 'العملة', 'رمز العملة المستخدمة', 0, NOW(), NOW()),
('timezone', 'Asia/Riyadh', 'text', 'general', 'المنطقة الزمنية', 'المنطقة الزمنية للعيادة', 0, NOW(), NOW()),
('appointment_notifications', '1', 'boolean', 'notifications', 'إشعارات المواعيد', 'تفعيل إشعارات المواعيد التلقائية', 0, NOW(), NOW()),
('email_notifications', '1', 'boolean', 'notifications', 'إشعارات البريد', 'تفعيل الإشعارات عبر البريد الإلكتروني', 0, NOW(), NOW()),
('whatsapp_notifications', '1', 'boolean', 'notifications', 'إشعارات WhatsApp', 'تفعيل الإشعارات عبر WhatsApp', 0, NOW(), NOW());

-- Insert default services
INSERT INTO `services` (`name`, `name_ar`, `description`, `description_ar`, `price`, `duration_minutes`, `category`, `is_active`, `created_at`, `updated_at`) VALUES
('General Consultation', 'استشارة عامة', 'Comprehensive medical consultation', 'استشارة طبية شاملة', 150.00, 30, 'consultation', 1, NOW(), NOW()),
('Follow-up Visit', 'متابعة طبية', 'Follow-up consultation visit', 'زيارة متابعة طبية', 100.00, 20, 'consultation', 1, NOW(), NOW()),
('Medical Check-up', 'فحص طبي', 'Complete medical examination', 'فحص طبي شامل', 200.00, 45, 'examination', 1, NOW(), NOW()),
('Specialist Consultation', 'استشارة متخصص', 'Specialist medical consultation', 'استشارة طبية متخصصة', 250.00, 45, 'specialist', 1, NOW(), NOW()),
('Treatment Plan', 'خطة العلاج', 'Detailed treatment plan consultation', 'استشارة خطة علاجية مفصلة', 180.00, 60, 'treatment', 1, NOW(), NOW());

-- Insert default doctor
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Dr. Abdelnasser Al-Akhras', 'doctor@clinic.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'doctor', 'active', NOW(), NOW());

INSERT INTO `doctors` (`id`, `user_id`, `specialty`, `license_number`, `experience_years`, `qualifications`, `bio`, `consultation_fee`, `available_days`, `working_hours_start`, `working_hours_end`, `is_available`, `created_at`, `updated_at`) VALUES
(1, 2, 'General Medicine', 'MD001', 15, 'MD, Board Certified', 'Experienced general practitioner with 15+ years of experience', 150.00, '["sunday","monday","tuesday","wednesday","thursday"]', '09:00:00', '17:00:00', 1, NOW(), NOW());

-- Insert default FAQs
INSERT INTO `faqs` (`question`, `question_ar`, `answer`, `answer_ar`, `category`, `display_order`, `is_active`, `created_at`, `updated_at`) VALUES
('What are your working hours?', 'ما هي ساعات العمل؟', 'We are open Sunday to Thursday from 9:00 AM to 5:00 PM', 'نعمل من الأحد إلى الخميس من 9:00 صباحاً إلى 5:00 مساءً', 'general', 1, 1, NOW(), NOW()),
('How can I book an appointment?', 'كيف يمكنني حجز موعد؟', 'You can book an appointment through our website, phone, or by visiting our clinic', 'يمكنك حجز موعد من خلال موقعنا الإلكتروني أو الهاتف أو زيارة العيادة', 'appointments', 2, 1, NOW(), NOW()),
('What should I bring for my first visit?', 'ماذا أحضر للزيارة الأولى؟', 'Please bring your ID, insurance card, and any previous medical records', 'يرجى إحضار بطاقة الهوية وبطاقة التأمين وأي سجلات طبية سابقة', 'appointments', 3, 1, NOW(), NOW()),
('Do you accept insurance?', 'هل تقبلون التأمين؟', 'Yes, we accept most major insurance plans. Please contact us to verify coverage', 'نعم، نقبل معظم خطط التأمين الرئيسية. يرجى الاتصال بنا للتحقق من التغطية', 'insurance', 4, 1, NOW(), NOW()),
('What is your cancellation policy?', 'ما هي سياسة الإلغاء؟', 'Please cancel at least 24 hours in advance to avoid charges', 'يرجى الإلغاء قبل 24 ساعة على الأقل لتجنب الرسوم', 'appointments', 5, 1, NOW(), NOW());

-- Insert default API integrations (18 integrations)
INSERT INTO `api_integrations` (`name`, `display_name`, `category`, `configuration`, `api_keys`, `is_active`, `is_testing`, `description`, `created_at`, `updated_at`) VALUES
-- Analytics Integrations (4)
('google_analytics_4', 'Google Analytics 4', 'analytics', '{"property_id": "", "measurement_id": ""}', '{"api_key": ""}', 0, 1, 'Google Analytics 4 for website traffic tracking', NOW(), NOW()),
('cloudflare_analytics', 'Cloudflare Analytics', 'analytics', '{"zone_id": "", "api_token": ""}', '{"api_token": ""}', 0, 1, 'Cloudflare Analytics for performance monitoring', NOW(), NOW()),
('google_maps', 'Google Maps', 'analytics', '{"api_key": "", "place_id": ""}', '{"api_key": ""}', 0, 1, 'Google Maps integration for location display', NOW(), NOW()),
('ip_geolocation', 'IP Geolocation', 'analytics', '{"service": "ipapi"}', '{"api_key": ""}', 0, 1, 'IP geolocation service for visitor location', NOW(), NOW()),

-- Security Integrations (3)
('recaptcha_v3', 'reCAPTCHA v3', 'security', '{"site_key": "", "secret_key": ""}', '{"secret_key": ""}', 0, 1, 'Google reCAPTCHA v3 for form protection', NOW(), NOW()),
('hcaptcha', 'hCaptcha', 'security', '{"site_key": "", "secret_key": ""}', '{"secret_key": ""}', 0, 1, 'hCaptcha alternative to reCAPTCHA', NOW(), NOW()),
('cloudflare_turnstile', 'Cloudflare Turnstile', 'security', '{"site_key": "", "secret_key": ""}', '{"secret_key": ""}', 0, 1, 'Cloudflare Turnstile CAPTCHA service', NOW(), NOW()),

-- Communication Integrations (4)
('smtp_email', 'SMTP Email', 'communication', '{"host": "", "port": 587, "encryption": "tls", "username": "", "from_email": "", "from_name": ""}', '{"password": ""}', 0, 1, 'SMTP email service for notifications', NOW(), NOW()),
('whatsapp_cloud_api', 'WhatsApp Cloud API', 'communication', '{"phone_number_id": "", "access_token": ""}', '{"access_token": ""}', 0, 1, 'WhatsApp Cloud API for messaging', NOW(), NOW()),
('sms_gateway', 'SMS Gateway', 'communication', '{"provider": "twilio", "account_sid": "", "auth_token": ""}', '{"auth_token": ""}', 0, 1, 'SMS gateway for appointment reminders', NOW(), NOW()),
('onesignal', 'OneSignal Push', 'communication', '{"app_id": "", "rest_api_key": ""}', '{"rest_api_key": ""}', 0, 1, 'OneSignal push notification service', NOW(), NOW()),

-- Storage Integrations (3)
('firebase_storage', 'Firebase Storage', 'storage', '{"project_id": "", "storage_bucket": ""}', '{"service_account_key": ""}', 0, 1, 'Firebase cloud storage for files', NOW(), NOW()),
('cloudinary', 'Cloudinary', 'storage', '{"cloud_name": "", "api_key": ""}', '{"api_secret": ""}', 0, 1, 'Cloudinary media management service', NOW(), NOW()),
('imagekit', 'ImageKit', 'storage', '{"endpoint": "", "public_key": ""}', '{"private_key": ""}', 0, 1, 'ImageKit for image optimization', NOW(), NOW()),

-- Payment Integrations (1)
('payment_gateway', 'Payment Gateway', 'payment', '{"provider": "stripe", "public_key": "", "webhook_secret": ""}', '{"secret_key": ""}', 0, 1, 'Payment gateway (Stripe, Paymob, Fawry)', NOW(), NOW()),

-- Marketing Integrations (2)
('meta_pixel', 'Meta Pixel', 'marketing', '{"pixel_id": "", "access_token": ""}', '{"access_token": ""}', 0, 1, 'Meta Pixel for Facebook/Instagram tracking', NOW(), NOW()),
('google_tag_manager', 'Google Tag Manager', 'marketing', '{"container_id": "", "gtm_id": ""}', '{"gtm_id": ""}', 0, 1, 'Google Tag Manager for analytics', NOW(), NOW()),

-- Monitoring Integrations (1)
('uptimerobot', 'UptimeRobot', 'monitoring', '{"api_key": "", "monitor_id": ""}', '{"api_key": ""}', 0, 1, 'UptimeRobot for website monitoring', NOW(), NOW());

-- Insert default testimonials
INSERT INTO `testimonials` (`patient_name`, `rating`, `title`, `content`, `is_featured`, `is_approved`, `created_at`, `updated_at`) VALUES
('أحمد محمد', 5, 'خدمة ممتازة', 'كانت الخدمة ممتازة والطبيب محترف جداً. أنصح بشدة بزيارة العيادة.', 1, 1, NOW(), NOW()),
('فاطمة العلي', 5, 'تجربة رائعة', 'تجربة رائعة مع الفريق الطبي. شكراً لكم على الرعاية المتميزة.', 1, 1, NOW(), NOW()),
('محمد السعد', 4, 'طبيب ماهر', 'طبيب ماهر ومتعاون. العيادة منظمة ونظيفة.', 1, 1, NOW(), NOW()),
('نورا المطيري', 5, 'أنصح بها', 'أفضل عيادة في المنطقة. العلاج فعال والمتابعة ممتازة.', 0, 1, NOW(), NOW()),
('خالد الزهراني', 5, 'خدمة متكاملة', 'خدمة متكاملة من البداية للنهاية. النتائج مرضية جداً.', 0, 1, NOW(), NOW());

-- Insert sample articles
INSERT INTO `articles` (`title`, `title_ar`, `slug`, `excerpt`, `excerpt_ar`, `content`, `content_ar`, `status`, `is_featured`, `published_at`, `created_at`, `updated_at`) VALUES
('Understanding Blood Pressure', 'فهم ضغط الدم', 'understanding-blood-pressure', 'Learn about blood pressure and its importance for health.', 'تعلم عن ضغط الدم وأهميته للصحة.', 'Blood pressure is the force of blood pushing against the walls of your arteries...', 'ضغط الدم هو قوة دفع الدم ضد جدران الشرايين...', 'published', 1, NOW(), NOW(), NOW()),
('Healthy Eating Habits', 'عادات غذائية صحية', 'healthy-eating-habits', 'Discover the importance of healthy eating for overall wellness.', 'اكتشف أهمية التغذية الصحية للرفاهية العامة.', 'Maintaining a healthy diet is crucial for your overall well-being...', 'الحفاظ على نظام غذائي صحي أمر بالغ الأهمية لرفاهيتك العامة...', 'published', 1, NOW(), NOW(), NOW()),
('Regular Health Check-ups', 'الفحوصات الصحية الدورية', 'regular-health-checkups', 'Why regular health check-ups are essential for early detection.', 'لماذا الفحوصات الصحية الدورية ضرورية للكشف المبكر.', 'Regular health check-ups help in early detection of potential health issues...', 'تساعد الفحوصات الصحية الدورية في الكشف المبكر عن المشاكل الصحية المحتملة...', 'published', 0, NOW(), NOW(), NOW());

-- Enable foreign key checks
SET FOREIGN_KEY_CHECKS = 1;

-- =====================================================
-- INDEXES FOR PERFORMANCE
-- =====================================================

-- Additional indexes for better performance
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_appointments_date_time ON appointments(appointment_date, appointment_time);
CREATE INDEX idx_appointments_status_date ON appointments(status, appointment_date);
CREATE INDEX idx_patients_phone ON patients(phone);
CREATE INDEX idx_contact_messages_status_created ON contact_messages(status, created_at);
CREATE INDEX idx_articles_published_featured ON articles(status, is_featured);
CREATE INDEX idx_medical_records_patient_date ON medical_records(patient_id, created_at);
CREATE INDEX idx_api_integrations_category_active ON api_integrations(category, is_active);

-- =====================================================
-- COMMENTS AND DOCUMENTATION
-- =====================================================

-- This database structure includes:
-- 1. Core user management with roles (admin, doctor, patient, user)
-- 2. Complete appointment booking system
-- 3. Patient medical records with HIPAA-like privacy
-- 4. Service management with pricing and durations
-- 5. Advanced API integration system with 18+ integrations
-- 6. Blog/articles system with multilingual support
-- 7. Testimonials and feedback system
-- 8. FAQ system with categorization
-- 9. Contact form with reply tracking
-- 10. Theme and page builder system
-- 11. Activity logging and backup systems
-- 12. All tables optimized for MySQL/MariaDB with proper indexes

-- To use this file:
-- 1. Create a new database in Hostinger cPanel
-- 2. Import this SQL file using phpMyAdmin
-- 3. Update your .env file with the new database credentials
-- 4. Run: php artisan migrate --force
-- 5. Run: php artisan db:seed (optional)

-- Default admin credentials:
-- Email: admin@clinic.com
-- Password: password (change after first login)

-- All passwords are hashed using Laravel's bcrypt
-- API keys are encrypted using Laravel's encrypted casting