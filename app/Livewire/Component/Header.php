<?php

namespace App\Livewire\Component;

use Livewire\Component;

class Header extends Component
{
    public $title;
    public $subTitle;
    public bool $searchBar = true;
    public bool $filterButton = true;
    public bool $createButton = true;
    public bool $customButton = true;

    public string $search = '';

    public function showDrawerPage()
    {
        $this->dispatch('show-drawer');
    }

    public function create()
    {
        $this->dispatch('create');
    }

    public function updatedSearch()
    {
        $this->dispatch('searching', search: $this->search);
    }

    public function render()
    {
        return view('livewire.component.header');
    }
}
