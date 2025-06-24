<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General Settings
            [
                'key' => 'app_name',
                'value' => config('app.name'),
                'type' => 'string',
                'group' => 'general',
                'label' => 'Application Name',
                'description' => 'The name of your application',
                'is_public' => true,
            ],
            [
                'key' => 'app_description',
                'value' => 'A modern Laravel admin template with Mary UI',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Application Description',
                'description' => 'A brief description of your application',
                'is_public' => true,
            ],
            [
                'key' => 'app_timezone',
                'value' => config('app.timezone'),
                'type' => 'string',
                'group' => 'general',
                'label' => 'Timezone',
                'description' => 'The default timezone for your application',
                'is_public' => false,
            ],
            [
                'key' => 'app_locale',
                'value' => config('app.locale'),
                'type' => 'string',
                'group' => 'general',
                'label' => 'Default Locale',
                'description' => 'The default locale for your application',
                'is_public' => false,
            ],
            [
                'key' => 'app_url',
                'value' => config('app.url'),
                'type' => 'string',
                'group' => 'general',
                'label' => 'Application URL',
                'description' => 'The URL of your application',
                'is_public' => false,
            ],
            [
                'key' => 'app_debug',
                'value' => config('app.debug') ? '1' : '0',
                'type' => 'boolean',
                'group' => 'general',
                'label' => 'Debug Mode',
                'description' => 'Enable debug mode for development',
                'is_public' => false,
            ],

            // Security Settings
            [
                'key' => 'password_min_length',
                'value' => '8',
                'type' => 'integer',
                'group' => 'security',
                'label' => 'Minimum Password Length',
                'description' => 'Minimum number of characters required for passwords',
                'is_public' => false,
            ],
            [
                'key' => 'password_require_uppercase',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'security',
                'label' => 'Require Uppercase Letters',
                'description' => 'Passwords must contain at least one uppercase letter',
                'is_public' => false,
            ],
            [
                'key' => 'password_require_lowercase',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'security',
                'label' => 'Require Lowercase Letters',
                'description' => 'Passwords must contain at least one lowercase letter',
                'is_public' => false,
            ],
            [
                'key' => 'password_require_numbers',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'security',
                'label' => 'Require Numbers',
                'description' => 'Passwords must contain at least one number',
                'is_public' => false,
            ],
            [
                'key' => 'password_require_symbols',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'security',
                'label' => 'Require Special Characters',
                'description' => 'Passwords must contain at least one special character',
                'is_public' => false,
            ],
            [
                'key' => 'session_lifetime',
                'value' => '120',
                'type' => 'integer',
                'group' => 'security',
                'label' => 'Session Lifetime (minutes)',
                'description' => 'How long user sessions remain active',
                'is_public' => false,
            ],
            [
                'key' => 'max_login_attempts',
                'value' => '5',
                'type' => 'integer',
                'group' => 'security',
                'label' => 'Maximum Login Attempts',
                'description' => 'Maximum number of failed login attempts before lockout',
                'is_public' => false,
            ],
            [
                'key' => 'lockout_duration',
                'value' => '15',
                'type' => 'integer',
                'group' => 'security',
                'label' => 'Lockout Duration (minutes)',
                'description' => 'How long to lock out users after max login attempts',
                'is_public' => false,
            ],
            [
                'key' => 'require_email_verification',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'security',
                'label' => 'Require Email Verification',
                'description' => 'Users must verify their email address before accessing the system',
                'is_public' => false,
            ],

            // Notification Settings
            [
                'key' => 'email_notifications_enabled',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'notifications',
                'label' => 'Enable Email Notifications',
                'description' => 'Send email notifications for system events',
                'is_public' => false,
            ],
            [
                'key' => 'welcome_email_enabled',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'notifications',
                'label' => 'Welcome Email',
                'description' => 'Send welcome email to new users',
                'is_public' => false,
            ],
            [
                'key' => 'password_reset_enabled',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'notifications',
                'label' => 'Password Reset Email',
                'description' => 'Allow users to request password reset emails',
                'is_public' => false,
            ],
            [
                'key' => 'user_registration_notification',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'notifications',
                'label' => 'New User Registration Notification',
                'description' => 'Notify administrators when new users register',
                'is_public' => false,
            ],
            [
                'key' => 'system_alerts_enabled',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'notifications',
                'label' => 'System Alerts',
                'description' => 'Show system alerts and notifications in the admin panel',
                'is_public' => false,
            ],

            // System Settings
            [
                'key' => 'maintenance_mode',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'system',
                'label' => 'Maintenance Mode',
                'description' => 'Put the application in maintenance mode',
                'is_public' => false,
            ],
            [
                'key' => 'maintenance_message',
                'value' => 'We are currently performing maintenance. Please check back soon.',
                'type' => 'string',
                'group' => 'system',
                'label' => 'Maintenance Message',
                'description' => 'Message to display when in maintenance mode',
                'is_public' => false,
            ],
            [
                'key' => 'cache_enabled',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'system',
                'label' => 'Enable Caching',
                'description' => 'Enable application caching for better performance',
                'is_public' => false,
            ],
            [
                'key' => 'cache_duration',
                'value' => '3600',
                'type' => 'integer',
                'group' => 'system',
                'label' => 'Cache Duration (seconds)',
                'description' => 'How long to cache data',
                'is_public' => false,
            ],
            [
                'key' => 'log_level',
                'value' => 'info',
                'type' => 'string',
                'group' => 'system',
                'label' => 'Log Level',
                'description' => 'The minimum log level to record',
                'is_public' => false,
            ],
            [
                'key' => 'backup_enabled',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'system',
                'label' => 'Enable Automatic Backups',
                'description' => 'Automatically backup the database and files',
                'is_public' => false,
            ],
            [
                'key' => 'backup_frequency',
                'value' => 'daily',
                'type' => 'string',
                'group' => 'system',
                'label' => 'Backup Frequency',
                'description' => 'How often to perform automatic backups',
                'is_public' => false,
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
} 