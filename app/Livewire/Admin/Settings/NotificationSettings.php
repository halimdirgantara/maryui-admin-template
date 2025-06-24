<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;
use App\Models\Setting;

class NotificationSettings extends Component
{
    public bool $email_notifications_enabled = true;
    public bool $welcome_email_enabled = true;
    public bool $password_reset_enabled = true;
    public bool $user_registration_notification = true;
    public bool $system_alerts_enabled = true;

    public function mount()
    {
        $this->loadSettings();
    }

    public function loadSettings()
    {
        $this->email_notifications_enabled = Setting::getValue('email_notifications_enabled', true);
        $this->welcome_email_enabled = Setting::getValue('welcome_email_enabled', true);
        $this->password_reset_enabled = Setting::getValue('password_reset_enabled', true);
        $this->user_registration_notification = Setting::getValue('user_registration_notification', true);
        $this->system_alerts_enabled = Setting::getValue('system_alerts_enabled', true);
    }

    public function save()
    {
        try {
            Setting::setValue('email_notifications_enabled', $this->email_notifications_enabled);
            Setting::setValue('welcome_email_enabled', $this->welcome_email_enabled);
            Setting::setValue('password_reset_enabled', $this->password_reset_enabled);
            Setting::setValue('user_registration_notification', $this->user_registration_notification);
            Setting::setValue('system_alerts_enabled', $this->system_alerts_enabled);

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Notification settings updated successfully!'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Failed to update notification settings: ' . $e->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.admin.settings.notification-settings');
    }
} 