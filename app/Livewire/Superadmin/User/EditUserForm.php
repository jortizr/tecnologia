<?php

namespace App\Livewire\Superadmin\User;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Laravel\Jetstream\InteractsWithBanner;
use App\Models\User;

class EditUserForm extends Component
{
    use InteractsWithBanner;

    public bool $isOpen = false;
    public $name;
    public $last_name;
    public $email;
    public $password;
    public $role;

    public $roles= [];

        public function openModal()
    {
        $this->resetForm();
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetValidation();
    }

    public function resetForm()
    {
        $this->reset(['name', 'last_name', 'email', 'password', 'roles', 'is_active']);
    }

    // Aquí iría tu método 'update' para guardar los cambios
    public function update()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'role' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($this->userId);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $user->syncRoles($this->role); // Sincroniza el rol

        session()->flash('success', 'Usuario actualizado con éxito.');
        $this->closeModal();
    }



    public function render()
    {
        $this->roles = Role::all();
        return view('livewire.superadmin.user.edit-user-form',[
            'roles' => $this->roles,
        ]);
    }
}
