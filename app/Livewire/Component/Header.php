<?php

namespace App\Livewire\Component;

use Livewire\Component;

class Header extends Component
{
    public $title;
    public $subTitle;
    public bool $searchBar = false;

    public function showDrawerPage()
    {
        $this->dispatch('show-drawer');
    }

    public function create()
    {
        $this->dispatch('create');
    }

    public function render()
    {
        return view('livewire.component.header');
    }
}
