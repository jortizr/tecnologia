<?php

namespace App\Livewire\Superadmin\User;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;

class CreateUserForm extends Component
{
    public bool $isOpen = false;
    public $name;
    public $last_name;
    public $email;
    public $confirm_email;
    public $password;
    public $confirm_password;
    public $role;

    public $roles= [];

    public function mount()
    {

    }

    public function loadRoles()
    {

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

    public function resetForm()
    {
        $this->reset(['name', 'last_name', 'email', 'password', 'confirm_password', 'roles']);


    }

    //funcion para generar passwored aleatorio y seguros
    public function generatePassword()
    {
        $this->password = bin2hex(random_bytes(8)); // Genera un password aleatorio de 16 caracteres
        $this->confirm_password = $this->password; // Asegura que la confirmación del password sea igual
    }

    public function store()
    {
        $user = User::create([
            'name' => $this->name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'role' => $this->role,
        ]);
        //agrega el id del usuario creado y el rol seleccionado
        $user->roles()->attach($this->role);



        session()->flash('message', 'Usuario creado exitosamente');
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
