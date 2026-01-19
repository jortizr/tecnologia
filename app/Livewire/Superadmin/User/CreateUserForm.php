<?php

namespace App\Livewire\Superadmin\User;

use Livewire\Component;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Role;
use Laravel\Jetstream\InteractsWithBanner;

class CreateUserForm extends Component
{
    use InteractsWithBanner;
    use AuthorizesRequests;
    public bool $isOpen = false;









    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required|exists:roles,id',
            'is_active' => 'boolean',
        ];
    }

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



    //funcion para generar passwored aleatorio y seguros


    public function store()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'is_active' => $this->is_active,
        ]);

        // Aquí usas assignRole con el nombre del rol
        $role = Role::find($this->role); // $this->role es el ID
        if ($role) {
            $user->assignRole($role->name);
        }

        $this->banner('Usuario creado exitosamente');
        $this->closeModal();
        $this->resetForm();
        $this->dispatch('userCreated');

    }

    public function render()
    {
        $this->roles = Role::all();
        return view('livewire.superadmin.user.create-user-form', [
            'roles' => $this->roles,
        ]);
    }


}
