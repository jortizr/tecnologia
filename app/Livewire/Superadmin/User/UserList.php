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

    public function mount(){
        $this->authorize('viewAny', User::class);
    }

    public function delete($userId)
    {
        $user = User::findOrFail($userId);
        //verifica la autorizacion especifica para eliminar el usuario
        $this->authorize('delete', $user);

        try {
            $user->delete();
            $this->Banner('Usuario eliminado correctamente.');
            $this->resetPage();

        } catch (\Exception $e) {
            $this->warningBanner('Error al eliminar el usuario.' . $e->getMessage());

        }
    }

    #[On(['userCreated', 'user-updated'])]
    public function render()
    {
        return view('livewire.superadmin.user.user-list', [
            'users' => User::with('roles')->paginate(10),
        ]);
    }
}
