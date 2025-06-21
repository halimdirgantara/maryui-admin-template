<?php

namespace App\Livewire\Admin\Permission;

use Mary\Traits\Toast;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

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

    #[Validate('required|string|min:2|max:255|unique:permissions,name')]
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

    public function getPermissions()
    {
        $query = Permission::query();
        
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        return $query->paginate(10);
    }

    public function save()
    {
        if ($this->editingId) {
            $this->validate([
                'name' => 'required|string|min:2|max:255|unique:permissions,name,' . $this->editingId,
            ]);
        } else {
            $this->validate();
        }

        try {
            if ($this->editingId) {
                $permission = Permission::findOrFail($this->editingId);
                $permission->update([
                    'name' => $this->name,
                ]);
                $this->success('Permission updated successfully!');
            } else {
                Permission::create([
                    'name' => $this->name,
                ]);
                $this->success('Permission created successfully!');
            }

            $this->reset(['name', 'editingId']);
            $this->form = false;
        } catch (\Exception $e) {
            $this->error('An error occurred: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        $this->editingId = $id;
        $this->name = $permission->name;
        $this->form = true;
    }

    public function delete($id)
    {
        try {
            $permission = Permission::findOrFail($id);
            $permission->delete();
            $this->success('Permission deleted successfully!');
        } catch (\Exception $e) {
            $this->error('An error occurred: ' . $e->getMessage());
        }
    }

    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'w-1'],
            ['key' => 'name', 'label' => 'Name', 'class' => 'w-64'],
            ['key' => 'created_at', 'label' => 'Created At', 'class' => 'w-32'],
        ];
    }

    public function render()
    {
        return view('livewire.admin.permission.permission-list', [
            'permissions' => $this->getPermissions(),
            'headers' => $this->headers(),
        ]);
    }
}
