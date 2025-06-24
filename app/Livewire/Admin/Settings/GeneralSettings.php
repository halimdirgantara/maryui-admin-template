<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;
use App\Models\Setting;
use Livewire\Attributes\Rule;

class GeneralSettings extends Component
{
    #[Rule('required|string|max:255')]
    public string $app_name = '';

    #[Rule('nullable|string|max:500')]
    public string $app_description = '';

    #[Rule('required|string')]
    public string $app_timezone = '';

    #[Rule('required|string|max:10')]
    public string $app_locale = '';

    #[Rule('required|url')]
    public string $app_url = '';

    public bool $app_debug = false;

    public array $timezones = [];
    public array $locales = [
        'en' => 'English',
        'es' => 'Spanish',
        'fr' => 'French',
        'de' => 'German',
        'it' => 'Italian',
        'pt' => 'Portuguese',
        'ru' => 'Russian',
        'ja' => 'Japanese',
        'ko' => 'Korean',
        'zh' => 'Chinese',
    ];

    public function mount()
    {
        $this->loadSettings();
        $this->loadTimezones();
    }

    public function loadSettings()
    {
        $this->app_name = Setting::getValue('app_name', config('app.name'));
        $this->app_description = Setting::getValue('app_description', '');
        $this->app_timezone = Setting::getValue('app_timezone', config('app.timezone'));
        $this->app_locale = Setting::getValue('app_locale', config('app.locale'));
        $this->app_url = Setting::getValue('app_url', config('app.url'));
        $this->app_debug = Setting::getValue('app_debug', config('app.debug'));
    }

    public function loadTimezones()
    {
        $this->timezones = [
            'UTC' => 'UTC',
            'America/New_York' => 'Eastern Time',
            'America/Chicago' => 'Central Time',
            'America/Denver' => 'Mountain Time',
            'America/Los_Angeles' => 'Pacific Time',
            'Europe/London' => 'London',
            'Europe/Paris' => 'Paris',
            'Europe/Berlin' => 'Berlin',
            'Asia/Tokyo' => 'Tokyo',
            'Asia/Shanghai' => 'Shanghai',
            'Australia/Sydney' => 'Sydney',
        ];
    }

    public function save()
    {
        $this->validate();

        try {
            Setting::setValue('app_name', $this->app_name);
            Setting::setValue('app_description', $this->app_description);
            Setting::setValue('app_timezone', $this->app_timezone);
            Setting::setValue('app_locale', $this->app_locale);
            Setting::setValue('app_url', $this->app_url);
            Setting::setValue('app_debug', $this->app_debug);

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'General settings updated successfully!'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Failed to update general settings: ' . $e->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.admin.settings.general-settings');
    }
} 