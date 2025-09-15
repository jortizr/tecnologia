<?php

namespace App\Livewire\Superadmin\User;

use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\On;
use Spatie\Permission\Models\Role;

class UserList extends Component
{
    public $roles = [];
    public $users;
    public function mount()
    {
        $this->loadUsers();
    }

    #[On(['userCreated', 'user-updated'])]
    public function loadUsers()
    {
        $this->users = User::with('roles')->get();
    }

    public function delete($userId)
    {
        try {
            $user = User::findOrFail($userId);
            $user->delete();

            // Recargar la lista
            $this->users = User::with('roles')->get();

            // Mensaje de éxito (opcional)
            session()->flash('message', 'Usuario eliminado correctamente.');

        } catch (\Exception $e) {
            session()->flash('error', 'Error al eliminar el usuario.');
        }
    }

    public function render()
    {
        return view('livewire.superadmin.user.user-list', [
            'users' => $this->users,
        ]);
    }
}
