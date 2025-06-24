<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class Dashboard extends Component
{
    public $title = 'Dashboard';
    public $subTitle = 'Data, Statistics, and Reports';

    public $userRole;
    public $stats = [];

    public function mount()
    {
        $user = Auth::user();
        $this->userRole = $user->roles->pluck('name')->first();

        // Example: Fetch stats based on role
        if ($this->userRole === 'admin') {
            $this->stats = [
                'totalUsers' => User::count(),
                'activeToday' => User::whereDate('last_login_at', now()->toDateString())->count(),
                'newRegistrations' => User::whereDate('created_at', now()->toDateString())->count(),
                // ...other admin stats
            ];
        } elseif ($this->userRole === 'manager') {
            $this->stats = [
                'teamMembers' => User::where('manager_id', $user->id)->count(),
                // ...other manager stats
            ];
        } else {
            $this->stats = [
                // ...basic stats for regular users
            ];
        }
    }

    public function render()
    {
        return view('livewire.admin.dashboard', [
            'userRole' => $this->userRole,
            'stats' => $this->stats,
        ])->layout('components.layouts.app');
    }
}
