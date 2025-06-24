<?php

namespace App\Livewire\Admin\Role;

use Mary\Traits\Toast;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
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

    public array $selectedPermissions = [];
    public $allPermissions = [];

    // New properties for permissions modal
    public bool $permissionsModal = false;
    public $rolePermissions = [];
    public string $selectedRoleName = '';

    // Properties for edit permissions modal
    public bool $editPermissionsModal = false;
    public ?int $editingPermissionsRoleId = null;
    public array $selectedPermissionsForEdit = [];

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

                $role = Role::findOrFail($this->editingRoleId);
                $role->name = $this->name;
                $role->save();

                $this->success(
                    'Role Updated Successfully!',
                    timeout: 5000,
                    position: 'toast-top toast-end'
                );
            } else {

                $role = Role::create([
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
            $role = Role::findOrFail($id);

            $this->editingRoleId = $role->id;
            $this->name = $role->name;
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


    public function showPermissions($id)
    {
        try {
            $role = Role::findOrFail($id);
            $this->selectedRoleName = $role->name;
            $this->rolePermissions = $role->permissions->toArray();
            $this->permissionsModal = true;
        } catch (\Exception $e) {
            $this->error(
                'Role not found!',
                timeout: 5000,
                position: 'toast-top toast-end'
            );
        }
    }

    public function editPermissions($id)
    {
        try {
            $role = Role::findOrFail($id);
            $this->editingPermissionsRoleId = $role->id;
            $this->selectedRoleName = $role->name;
            $this->allPermissions = Permission::all()->toArray();
            $this->selectedPermissionsForEdit = $role->permissions->pluck('name')->toArray();
            $this->editPermissionsModal = true;
        } catch (\Exception $e) {
            $this->error(
                'Role not found!',
                timeout: 5000,
                position: 'toast-top toast-end'
            );
        }
    }

    public function savePermissions()
    {
        try {
            $role = Role::findOrFail($this->editingPermissionsRoleId);
            $role->syncPermissions($this->selectedPermissionsForEdit);

            $this->success(
                'Permissions updated successfully!',
                timeout: 5000,
                position: 'toast-top toast-end'
            );

            $this->reset(['editPermissionsModal', 'editingPermissionsRoleId', 'selectedPermissionsForEdit', 'allPermissions']);
        } catch (\Exception $e) {
            $this->error(
                'Error updating permissions: ' . $e->getMessage(),
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
