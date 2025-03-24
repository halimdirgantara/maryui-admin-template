<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Mary\Traits\Toast;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class UserList extends Component
{
    use WithPagination;
    use Toast;

    public $title = 'User List';
    public $subTitle = 'List of all users';
    public bool $searchBar = true;

    public string $search = '';
    public bool $showDrawer = false;
    public bool $userForm = false;

    #[On('show-drawer')]
    public function showDrawerPage()
    {
        $this->showDrawer = true;
    }

    #[On('create')]
    public function createUserModal()
    {
        $this->userForm = true;
    }

    public function getUsers()
    {
        $query = User::query();
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%');
        }
        return $query->paginate(10);
    }

    public function edit($id)
    {
        dd($id);
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


    public function render()
    {
        $headers = [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'name', 'label' => 'Nice Name'],
            ['key' => 'email', 'label' => 'Email'],
        ];

        return view('livewire.admin.user.user-list', [
            'users' => $this->getUsers(),
            'headers' => $headers
        ]);
    }
}
