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
    public $name;
    public $last_name;
    public $email;
    public $confirm_email;
    public $password;
    public $confirm_password;
    public $role;

    public $roles= [];
    public $is_active = false;

    protected $messages = [
    'email.unique' => 'Este correo ya está registrado.',
    'confirm_email.same' => 'Los correos no coinciden.',
    'confirm_password.same' => 'Las contraseñas no coinciden.',
    ];

    public function mount()
    {
        //autorizacion de la accion create con el form
        $this->authorize("create", User::class);
    }

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

    public function resetForm()
    {
        $this->reset(['name', 'last_name', 'email', 'password', 'confirm_password', 'role']);


    }

    //funcion para generar passwored aleatorio y seguros
    public function generatePassword()
    {
        $this->password = bin2hex(random_bytes(8)); // Genera un password aleatorio de 16 caracteres
        $this->confirm_password = $this->password; // Asegura que la confirmación del password sea igual
    }

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
