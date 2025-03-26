<?php

namespace App\Livewire\Admin\Permission;

use Mary\Traits\Toast;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;

class PermissionList extends Component
{
    use WithPagination;
    use Toast;

    public $title = 'Permission List';
    public $subTitle = 'List of all permissions';
    public bool $searchBar = true;

    public string $search = '';

    public bool $showDrawer = false;
    public bool $form = false;
    public ?int $editingId = null;

    #[Validate('required|string|min:2|max:255|unique:permission,name')]
    public string $name = '';

    #[On('show-drawer')]
    public function showDrawerPage()
    {
        $this->showDrawer = true;
    }

    #[On('create')]
    public function createModal()
    {
        $this->reset();
        $this->form = true;
    }

    #[On('searching')]
    public function updatedSearch($search)
    {
        $this->search = $search;
        $this->getPermissions();
    }

    
    public function render()
    {
        return view('livewire.admin.permission.permission-list');
    }
}
