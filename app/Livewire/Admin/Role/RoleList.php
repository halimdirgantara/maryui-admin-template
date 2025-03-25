<?php

namespace App\Livewire\Admin\Role;

use Mary\Traits\Toast;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;
use Spatie\Permission\Models\Role;

class RoleList extends Component
{
    use WithPagination;
    use Toast;

    public $title = 'Role List';
    public $subTitle = 'List of all roles';
    public bool $searchBar = true;

    public string $search = '';

    public bool $roleForm = false;
    public ?int $editingRoleId = null;

    #[Validate('required|string|min:2|max:255')]
    public string $name = '';

    #[On('create')]
    public function createUserModal()
    {
        $this->reset();
        $this->roleForm = true;
    }


    #[On('searching')]
    public function updatedSearch($search)
    {
        $this->search = $search;
        $this->getRoles();
    }

    public function getRoles()
    {
        $query = Role::query();
        
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        return $query->paginate(10);
    }

    public function save()
    {
        if ($this->editingRoleId) {
            $this->validate([
                'name' => 'required|string|min:2|max:255',
            ]);
        } else {
            $this->validate();
        }

        try {
            if ($this->editingRoleId) {

                $user = Role::findOrFail($this->editingRoleId);
                $user->name = $this->name;

                $user->save();

                $this->success(
                    'User Updated Successfully!',
                    timeout: 5000,
                    position: 'toast-top toast-end'
                );
            } else {

                Role::create([
                    'name' => $this->name
                ]);

                $this->success(
                    'Role Created Successfully!',
                    timeout: 5000,
                    position: 'toast-top toast-end'
                );
            }

            $this->reset(['name', 'roleForm', 'editingRoleId']);
        } catch (\Exception $e) {
            $this->error(
                'Error: ' . $e->getMessage(),
                timeout: 5000,
                position: 'toast-top toast-end'
            );
        }
    }
    
    
    public function render()
    {
        $headers = [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'name', 'label' => 'Name'],
        ];

        return view('livewire.admin.role.role-list', [
            'roles' => $this->getRoles(),
            'headers' => $headers
        ]);
    }
}
