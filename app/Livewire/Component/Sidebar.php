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
                'route' => route('dashboard'),
                'icon' => 'o-cube',
                'active' => request()->routeIs('dashboard'),
            ],
            [
                'name' => 'User Management',
                'icon' => 'o-user-group',
                'route' => '#',
                'active' => request()->routeIs('user-management.user*'),
                'subMenu' => [
                    [
                        'name' => 'User',
                        'icon' => 'o-user',
                        'route' => route('user-management.user'),
                        'active' => request()->routeIs('user-management.user'),
                    ],
                    [
                        'name' => 'Role',
                        'icon' => 'o-user-plus',
                        'route' => route('user-management.role'),
                        'active' => request()->routeIs('user-management.user.role'),
                    ],
                    [
                        'name' => 'Permission',
                        'icon' => 'o-lock-open',
                        'route' => route('user-management.permission'),
                        'active' => request()->routeIs('user-management.user.permission'),
                    ],
                ],
            ],
            [
                'name' => 'Settings',
                'icon' => 'o-cog-8-tooth',
                'route' => '#',
                'active' => request()->routeIs('settings*'),
                'subMenu' => [
                    [
                        'name' => 'General',
                        'icon' => 'o-cog-8-tooth',
                        'route' => '#',
                        'active' => request()->routeIs('settings.general'),
                    ],
                    [
                        'name' => 'Security',
                        'icon' => 'o-cog-8-tooth',
                        'route' => '#',
                        'active' => request()->routeIs('settings.security'),
                    ],
                    [
                        'name' => 'Notifications',
                        'icon' => 'o-cog-8-tooth',
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
