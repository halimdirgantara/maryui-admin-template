<?php

namespace App\Livewire\Admin\Role;

use Mary\Traits\Toast;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

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

    public function edit($id)
    {
        try {
            $user = Role::findOrFail($id);

            $this->editingRoleId = $user->id;
            $this->name = $user->name;
            $this->roleForm = true;
        } catch (\Exception $e) {
            $this->error(
                'Role not found!',
                timeout: 5000,
                position: 'toast-top toast-end'
            );
        }
    }

    public function delete($id)
    {
        LivewireAlert::title('Do you want to delete this data?')
            ->withConfirmButton('Delete')
            ->withCancelButton('Cancel')
            ->question()
            ->timer(0)
            ->onConfirm('deleteData', ['id' => $id])
            ->toast()
            ->show();
    }

    public function deleteData($data)
    {
        $roleId = $data['id'];

        $role = Role::find($roleId);

        if (!$role) {
            $this->error(
                'Role not found!',
                timeout: 5000,
                position: 'toast-top toast-end'
            );
            return;
        }
    

        if ($role->users()->exists()) {
            $this->error(
                'Role is assigned to users and cannot be deleted!',
                timeout: 5000,
                position: 'toast-top toast-end'
            );
            return;
        }


        $role = Role::find($roleId);
        if ($role) {
            $role->delete();
        }

        $this->success(
            'User Deleted!',
            timeout: 5000,
            position: 'toast-top toast-end'
        );

        $this->getRoles();
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
