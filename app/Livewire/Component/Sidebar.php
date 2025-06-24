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
        $user = auth()->user();
        $menu = [];

        // Dashboard menu
        if ($user && $user->can('dashboard.view')) {
            $menu[] = [
                'name' => 'Dashboard',
                'route' => route('dashboard'),
                'icon' => 'o-cube',
                'active' => request()->routeIs('dashboard'),
            ];
        }

        // User Management menu
        if ($user && $user->can('user-management.view')) {
            $userManagementSubMenu = [];

            if ($user->can('user-management.user.view')) {
                $userManagementSubMenu[] = [
                    'name' => 'User',
                    'icon' => 'o-user',
                    'route' => route('user-management.user'),
                    'active' => request()->routeIs('user-management.user'),
                ];
            }

            if ($user->can('user-management.role.view')) {
                $userManagementSubMenu[] = [
                    'name' => 'Role',
                    'icon' => 'o-user-plus',
                    'route' => route('user-management.role'),
                    'active' => request()->routeIs('user-management.role'),
                ];
            }

            if ($user->can('user-management.permission.view')) {
                $userManagementSubMenu[] = [
                    'name' => 'Permission',
                    'icon' => 'o-lock-open',
                    'route' => route('user-management.permission'),
                    'active' => request()->routeIs('user-management.permission'),
                ];
            }

            // Only add User Management menu if user has access to at least one submenu
            if (!empty($userManagementSubMenu)) {
                $menu[] = [
                    'name' => 'User Management',
                    'icon' => 'o-user-group',
                    'route' => '#',
                    'active' => request()->routeIs('user-management.*'),
                    'subMenu' => $userManagementSubMenu,
                ];
            }
        }

        // Settings menu
        if ($user && $user->can('settings.view')) {
            $settingsSubMenu = [];

            if ($user->can('settings.general.view')) {
                $settingsSubMenu[] = [
                    'name' => 'General',
                    'icon' => 'o-cog-8-tooth',
                    'route' => route('settings.general'),
                    'active' => request()->routeIs('settings.general'),
                ];
            }

            if ($user->can('settings.security.view')) {
                $settingsSubMenu[] = [
                    'name' => 'Security',
                    'icon' => 'o-shield-check',
                    'route' => route('settings.security'),
                    'active' => request()->routeIs('settings.security'),
                ];
            }

            if ($user->can('settings.notifications.view')) {
                $settingsSubMenu[] = [
                    'name' => 'Notifications',
                    'icon' => 'o-bell',
                    'route' => route('settings.notifications'),
                    'active' => request()->routeIs('settings.notifications'),
                ];
            }

            if ($user->can('settings.system.view')) {
                $settingsSubMenu[] = [
                    'name' => 'System',
                    'icon' => 'o-server',
                    'route' => route('settings.system'),
                    'active' => request()->routeIs('settings.system'),
                ];
            }

            // Only add Settings menu if user has access to at least one submenu
            if (!empty($settingsSubMenu)) {
                $menu[] = [
                    'name' => 'Settings',
                    'icon' => 'o-cog-8-tooth',
                    'route' => '#',
                    'active' => request()->routeIs('settings*'),
                    'subMenu' => $settingsSubMenu,
                ];
            }
        }

        $this->menu = $menu;
    }

    public function render()
    {
        return view('livewire.component.sidebar');
    }
}
