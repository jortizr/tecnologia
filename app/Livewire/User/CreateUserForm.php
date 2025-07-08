<?php

namespace App\Livewire\User;

use Livewire\Component;

class CreateUserForm extends Component
{
    public bool $isOpen = false;
    public $name;
    public $last_name;
    public $email;
    public $confirm_email;
    public $password;
    public $password_confirmation;
    public $role;

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
        $this->reset(['name', 'last_name', 'email', 'password', 'password_confirmation', 'role']);
    }

    public function render()
    {
        return view('livewire.user.create-user-form');
    }


}
