<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Dashboard extends Component
{
    public $title = 'Dashboard';
    public $subTitle = 'Data, Statistics, and Reports';

    public function render()
    {
        return view('livewire.admin.dashboard')->layout('components.layouts.app');
    }
}
