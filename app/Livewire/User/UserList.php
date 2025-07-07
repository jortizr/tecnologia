<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\On;

class UserList extends Component
{
    public $users;
    public function mount()
    {
        $this->loadUsers();
    }

    #[On('userCreated')]
    public function loadUsers()
    {
        $this->users = User::with('roles')->get();
    }

    public function render()
    {
        return view('livewire.user.user-list', [
            'users' => $this->users,
        ]);
    }
}
