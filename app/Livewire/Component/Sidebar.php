<?php

namespace App\Livewire\Component;

use Livewire\Component;

class Sidebar extends Component
{
    public array $menu = [];

    public function mount()
    {
        $this->getMenu();
    }

    public function getMenu()
    {
        $this->menu = [
            [
                'name' => 'Dashboard',
                'route' => '/dashboard',
                'icon' => 'o-cube',
                'active' => request()->routeIs('dashboard'),
            ],
            [
                'name' => 'Settings',
                'icon' => 'o-cog',
                'route' => '#',
                'active' => request()->routeIs('settings*'),
                'subMenu' => [
                    [
                        'name' => 'General',
                        'icon' => 'o-cog',
                        'route' => '#',
                        'active' => request()->routeIs('settings.general'),
                    ],
                    [
                        'name' => 'Security',
                        'icon' => 'o-cog',
                        'route' => '#',
                        'active' => request()->routeIs('settings.security'),
                    ],
                    [
                        'name' => 'Notifications',
                        'icon' => 'o-cog',
                        'route' => '#',
                        'active' => request()->routeIs('settings.notifications'),
                    ],
                ],
            ],
        ];
    }

    public function render()
    {
        return view('livewire.component.sidebar');
    }
}
