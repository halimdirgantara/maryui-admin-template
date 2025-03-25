<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Mary\Traits\Toast;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class UserList extends Component
{
    use WithPagination;
    use Toast;

    public $title = 'User List';
    public $subTitle = 'List of all users';
    public bool $searchBar = true;

    public string $search = '';
    public bool $isNotVerified = false;

    public bool $showDrawer = false;
    public bool $userForm = false;
    public ?int $editingUserId = null;
    
    #[Validate('required|string|min:2|max:255')]
    public string $name = '';
    
    #[Validate('required|email|unique:users,email')]
    public string $email = '';

    #[Validate('nullable|string|min:6')]
    public ?string $password = null;


    #[On('show-drawer')]
    public function showDrawerPage()
    {
        $this->showDrawer = true;
    }

    #[On('create')]
    public function createUserModal()
    {
        $this->reset();
        $this->userForm = true;
    }

    #[On('searching')]
    public function updatedSearch($search)
    {
        $this->search = $search;
        $this->getUsers();
    }

    public function updatedIsNotVerified()
    {
        $this->getUsers();
    }

    public function save()
    {
        if ($this->editingUserId) {
            $this->validate([
                'name' => 'required|string|min:2|max:255',
                'email' => 'required|email|unique:users,email,' . $this->editingUserId,
                'password' => 'nullable|string|min:6'
            ]);
        } else {
            $this->validate();
        }

        try {
            if ($this->editingUserId) {

                $user = User::findOrFail($this->editingUserId);
                $user->name = $this->name;
                $user->email = $this->email;

                if ($this->password) {
                    $user->password = Hash::make($this->password);
                }

                $user->save();

                $this->success(
                    'User Updated Successfully!',
                    timeout: 5000,
                    position: 'toast-top toast-end'
                );
            } else {

                User::create([
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => Hash::make($this->password ?? 'password')
                ]);

                $this->success(
                    'User Created Successfully!',
                    timeout: 5000,
                    position: 'toast-top toast-end'
                );
            }

            $this->reset(['name', 'email', 'password', 'userForm', 'editingUserId']);
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
            $user = User::findOrFail($id);
            
            $this->editingUserId = $user->id;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->password = null; // Reset password field
            $this->userForm = true;
        } catch (\Exception $e) {
            $this->error(
                'User not found!',
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
        $userId = $data['id'];

        if(Auth::user()->id === $userId)
        {
            $this->error(
                'Cannot Delete Yourself!',
                timeout: 5000,
                position: 'toast-top toast-end'
            );

            return;
        }

        $user = User::find($userId);
        if ($user) {
            $user->delete();
        }

        $this->success(
            'User Deleted!',
            timeout: 5000,
            position: 'toast-top toast-end'
        );

        $this->getUsers();
    }

    public function getUsers()
    {
        $query = User::query();

        if ($this->isNotVerified) {
            $query->whereNull('email_verified_at');
        }
        
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%');
        }

        return $query->paginate(10);
    }


    public function render()
    {
        $headers = [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'email', 'label' => 'Email'],
            ['key' => 'email_verified_at', 'label' => 'Verified At'],
        ];

        return view('livewire.admin.user.user-list', [
            'users' => $this->getUsers(),
            'headers' => $headers
        ]);
    }
}
