<?php

namespace App\Livewire\Superadmin\User;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Laravel\Jetstream\InteractsWithBanner;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use App\Models\User;



class EditUserForm extends Component
{

    use InteractsWithBanner;

    public bool $isOpen = false;
    public ?User $user = null;

    #[Validate('required|string|max:90')]
    public $name = '';
    #[Validate('required|string|max:90')]
    public $last_name = '';
    #[Validate('required|email|max:255|unique:users,email')]
    public $email ='';
    public $role_id ='';

    public $roles = [];

    public function mount()
    {
        $this->roles = Role::all();
    }

    #[On('open-edit-modal')]
    public function openModal(User $user)
    {
        $this->reset(['name', 'last_name', 'email', 'role_id']);
        $this->resetValidation();
        $this->user = $user;
        $this->name = $user->name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->role_id = $user->roles()->first()->id ?? null;
        $this->isOpen = true;

    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetValidation();
    }


    public function update()
    {

        $this->validate([
            'name' => 'required',
            'last_name' => 'required|string|max:90',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'role_id' => 'required|exists:roles,id',
        ]);



        $this->user->update([

            'name' => $this->name,
            'last_name' => $this->last_name,
            'email' => $this->email,
        ]);

        $this->user->roles()->sync([$this->role_id]);
        $this->dispatch('user-updated');
        $this->banner('Usuario actualizado con éxito.');
        $this->closeModal();
    }



    public function render()
    {
        return view('livewire.superadmin.user.edit-user-form');
    }
}
