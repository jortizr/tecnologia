<?php

namespace App\Livewire\Superadmin\User;

use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\On;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;
use Laravel\Jetstream\InteractsWithBanner;

class UserList extends Component
{
    use WithPagination, InteractsWithBanner;
    public $roles = [];

    public function delete($userId)
    {
        try {
            $user = User::findOrFail($userId);
            $user->delete();

            // Mensaje de éxito (opcional)
            $this->Banner('Usuario eliminado correctamente.');

        } catch (\Exception $e) {
            $this->warningBanner('Error al eliminar el usuario.' . $e->getMessage());

        }
    }

    #[On(['userCreated', 'user-updated'])]
    public function render()
    {
        $users = User::with('roles')->paginate(12);
        return view('livewire.superadmin.user.user-list', [
            'users' => $users,
        ]);
    }
}
