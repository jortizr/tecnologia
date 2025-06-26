<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;

class UserRoleManager extends Component
{
    public User $user;
    public $roles;
    public $selectedRole;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->roles = Role::all();
        $this->selectedRole = '';
    }

    public function assignRole()
    {
        // Validar que se haya seleccionado un rol
        if (!$this->selectedRole) {
            session()->flash('error', 'Por favor, selecciona un rol para asignar.');
            return;
        }


        if($this->selectedRole){
            $role = Role::find($this->selectedRole);
            if ($role) {
                $this->user->roles()->sync([$role->id]);
                session()->flash('message', 'Rol asignado correctamente.');
                $this->user->refresh(); // Refresca el modelo para obtener los roles actualizados
            }
        }
    }


    public function render()
    {
        return view('livewire.user-role-manager');
    }
}
