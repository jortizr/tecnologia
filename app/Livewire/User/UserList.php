<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User;

class UserList extends Component
{
    public function render()
    {
        $users = User::with('roles')->get();
        return view('livewire.user.user-list', [
            'users' => $users,
        ]);
    }
}
