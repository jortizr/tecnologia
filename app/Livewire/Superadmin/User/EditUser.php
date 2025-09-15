<?php

namespace App\Livewire\Superadmin\User;

use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Laravel\Jetstream\InteractsWithBanner;


class EditUser extends Component
{
    use InteractsWithBanner;
    public User $user;
    public $last_name;
    public $name;
    public $email;
    public $role;
    public $password;
    public $is_cancelled = false;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->role = $user->roles->pluck('name')->first();
    }

    public function update(){
        $this->validate(
            [
                'name'=> 'required',
                'last_name'=> 'required',
                'email'=> 'required|email',
                'role'=> 'required',
                'password'=> 'nullable|min:8',
            ]
        );

        $this->user->update(
            [
                'name'=> $this->name,
                'last_name'=> $this->last_name,
                'email'=> $this->email,
                'password'=> $this->password ? bcrypt($this->password) : $this->user->password,
            ]
        );

        $this->user->syncRoles([$this->role]);
        if(!$this->is_cancelled){
            $this->banner('Usuario actualizado con éxito');
        }

        return redirect()->route('dashboard.users.show');
    }


    public function cancel(){
        $this->is_cancelled = true;
        return redirect()->back();
    }
    public function render()
    {
        $this->is_cancelled = false;
        return view('livewire.superadmin.user.edit-user', [
            'roles' => Role::all(),
            'user' => $this->user,
        ]);
    }
}
