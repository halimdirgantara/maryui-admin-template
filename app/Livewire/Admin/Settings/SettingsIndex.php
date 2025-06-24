<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;
use App\Models\Setting;

class SettingsIndex extends Component
{
    public string $activeTab = 'general';
    public array $tabs = [
        'general' => [
            'name' => 'General',
            'icon' => 'o-cog-8-tooth',
            'description' => 'Basic application settings',
        ],
        'security' => [
            'name' => 'Security',
            'icon' => 'o-shield-check',
            'description' => 'Security and authentication settings',
        ],
        'notifications' => [
            'name' => 'Notifications',
            'icon' => 'o-bell',
            'description' => 'Email and notification settings',
        ],
        'system' => [
            'name' => 'System',
            'icon' => 'o-server',
            'description' => 'System maintenance and performance settings',
        ],
    ];

    public function mount()
    {
        // Set default tab if none is active
        if (!array_key_exists($this->activeTab, $this->tabs)) {
            $this->activeTab = 'general';
        }
    }

    public function setTab(string $tab)
    {
        if (array_key_exists($tab, $this->tabs)) {
            $this->activeTab = $tab;
        }
    }

    public function render()
    {
        return view('livewire.admin.settings.settings-index')
            ->layout('components.layouts.app');
    }
} 