<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;
use App\Models\Setting;
use Livewire\Attributes\Rule;

class SecuritySettings extends Component
{
    #[Rule('required|integer|min:6|max:50')]
    public int $password_min_length = 8;

    public bool $password_require_uppercase = true;
    public bool $password_require_lowercase = true;
    public bool $password_require_numbers = true;
    public bool $password_require_symbols = true;

    #[Rule('required|integer|min:30|max:1440')]
    public int $session_lifetime = 120;

    #[Rule('required|integer|min:1|max:20')]
    public int $max_login_attempts = 5;

    #[Rule('required|integer|min:5|max:60')]
    public int $lockout_duration = 15;

    public bool $require_email_verification = true;

    public function mount()
    {
        $this->loadSettings();
    }

    public function loadSettings()
    {
        $this->password_min_length = Setting::getValue('password_min_length', 8);
        $this->password_require_uppercase = Setting::getValue('password_require_uppercase', true);
        $this->password_require_lowercase = Setting::getValue('password_require_lowercase', true);
        $this->password_require_numbers = Setting::getValue('password_require_numbers', true);
        $this->password_require_symbols = Setting::getValue('password_require_symbols', true);
        $this->session_lifetime = Setting::getValue('session_lifetime', 120);
        $this->max_login_attempts = Setting::getValue('max_login_attempts', 5);
        $this->lockout_duration = Setting::getValue('lockout_duration', 15);
        $this->require_email_verification = Setting::getValue('require_email_verification', true);
    }

    public function save()
    {
        $this->validate();

        try {
            Setting::setValue('password_min_length', $this->password_min_length);
            Setting::setValue('password_require_uppercase', $this->password_require_uppercase);
            Setting::setValue('password_require_lowercase', $this->password_require_lowercase);
            Setting::setValue('password_require_numbers', $this->password_require_numbers);
            Setting::setValue('password_require_symbols', $this->password_require_symbols);
            Setting::setValue('session_lifetime', $this->session_lifetime);
            Setting::setValue('max_login_attempts', $this->max_login_attempts);
            Setting::setValue('lockout_duration', $this->lockout_duration);
            Setting::setValue('require_email_verification', $this->require_email_verification);

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Security settings updated successfully!'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Failed to update security settings: ' . $e->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.admin.settings.security-settings');
    }
} 