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

    protected $casts = [
    'is_active' => 'boolean',
    ];
    public function mount(){
        $this->authorize('viewAny', User::class);
    }


    #[On('toggleStatus')]
    public function toggleStatus($userId)
    {
        $user = User::findOrFail($userId);
        $this->authorize('update', $user);

        try{
            $user->is_active = !$user->is_active;
            $user->save();

            $this->banner($user->is_active ? 'Usuario activado correctamente.' : 'Usuario desactivado correctamente.');
        }
        catch(\Exception $e){
            $this->warningBanner('Error al cambiar el estado del usuario. ' . $e->getMessage());
        }

    }

    public function delete($userId)
    {
        $user = User::findOrFail($userId);
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
