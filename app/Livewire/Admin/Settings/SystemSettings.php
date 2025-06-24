<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;
use App\Models\Setting;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class SystemSettings extends Component
{
    public bool $maintenance_mode = false;
    
    #[Rule('required|string|max:500')]
    public string $maintenance_message = '';

    public bool $cache_enabled = true;
    
    #[Rule('required|integer|min:300|max:86400')]
    public int $cache_duration = 3600;

    #[Rule('required|string|in:debug,info,warning,error')]
    public string $log_level = 'info';

    public bool $backup_enabled = true;
    
    #[Rule('required|string|in:hourly,daily,weekly,monthly')]
    public string $backup_frequency = 'daily';

    public array $logLevels = [
        'debug' => 'Debug',
        'info' => 'Info',
        'warning' => 'Warning',
        'error' => 'Error',
    ];

    public array $backupFrequencies = [
        'hourly' => 'Hourly',
        'daily' => 'Daily',
        'weekly' => 'Weekly',
        'monthly' => 'Monthly',
    ];

    public function mount()
    {
        $this->loadSettings();
    }

    public function loadSettings()
    {
        $this->maintenance_mode = Setting::getValue('maintenance_mode', false);
        $this->maintenance_message = Setting::getValue('maintenance_message', 'We are currently performing maintenance. Please check back soon.');
        $this->cache_enabled = Setting::getValue('cache_enabled', true);
        $this->cache_duration = Setting::getValue('cache_duration', 3600);
        $this->log_level = Setting::getValue('log_level', 'info');
        $this->backup_enabled = Setting::getValue('backup_enabled', true);
        $this->backup_frequency = Setting::getValue('backup_frequency', 'daily');
    }

    public function save()
    {
        $this->validate();

        try {
            Setting::setValue('maintenance_mode', $this->maintenance_mode);
            Setting::setValue('maintenance_message', $this->maintenance_message);
            Setting::setValue('cache_enabled', $this->cache_enabled);
            Setting::setValue('cache_duration', $this->cache_duration);
            Setting::setValue('log_level', $this->log_level);
            Setting::setValue('backup_enabled', $this->backup_enabled);
            Setting::setValue('backup_frequency', $this->backup_frequency);

            // Apply maintenance mode if changed
            if ($this->maintenance_mode) {
                Artisan::call('down', ['--message' => $this->maintenance_message]);
            } else {
                Artisan::call('up');
            }

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'System settings updated successfully!'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Failed to update system settings: ' . $e->getMessage()
            ]);
        }
    }

    public function clearCache()
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('view:clear');
            Artisan::call('route:clear');
            
            // Clear settings cache
            Setting::clearCache();

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Cache cleared successfully!'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Failed to clear cache: ' . $e->getMessage()
            ]);
        }
    }

    public function optimize()
    {
        try {
            Artisan::call('config:cache');
            Artisan::call('route:cache');
            Artisan::call('view:cache');

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Application optimized successfully!'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Failed to optimize application: ' . $e->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.admin.settings.system-settings');
    }
} 