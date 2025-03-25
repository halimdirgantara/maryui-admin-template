<?php

namespace App\Livewire\Admin\Role;

use Mary\Traits\Toast;
use Livewire\Component;
use Livewire\WithPagination;

class RoleList extends Component
{
    use WithPagination;
    use Toast;

    public $title = 'Role List';
    public $subTitle = 'List of all roles';
    public bool $searchBar = true;
    
    public function render()
    {
        return view('livewire.admin.role.role-list');
    }
}
