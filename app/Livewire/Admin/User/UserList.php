<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class UserList extends Component
{
    use WithPagination;
    
    public $title = 'User List';
    public $subTitle = 'List of all users';
    public bool $searchBar = true;

    public string $search = '';
    public bool $showDrawer = false;

    #[On('show-drawer')] 
    public function showDrawerPage()
    {
        $this->showDrawer = true;
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

    public function render()
    {
        $headers = [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'name', 'label' => 'Nice Name'],
            ['key' => 'email', 'label' => 'Email']
        ];

        return view('livewire.admin.user.user-list',[
            'users' => $this->getUsers(),
            'headers' => $headers]);
    }
}
