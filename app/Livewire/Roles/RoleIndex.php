<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use WireUi\Traits\WireUiActions;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;

class RoleIndex extends Component
{
    use WireUiActions;

    public bool $roleModal = false;
    public $name;
    public $roleId;
    public $canManage;
    public array $selectedPermissions = [];

    protected function rules(){
        return ['name' => 'required|unique:roles,name',
        'selectedPermissions' => 'array'];
    }

    #[Computed]
    public function roles(){
        return Role::with('permissions')->paginate(10);
    }

    public function create(){
        $this->reset(['name', 'roleId', 'selectedPermissions']);
        $this->roleModal = true;
    }

    public function edit($id){
        $role = Role::findById($id);
        $this->roleId = $id;
        $this->name = $role->name;
        $this->selectedPermissions = $role->permissions->pluck('name')->toArray();
        $this->roleModal = true;
    }

    public function delete($id){
        $role = Role::findById($id);

        if($role->name === 'Superadmin'){
            $this->notification()->error('No puedes eliminar el rol Superadmin');
            return;
        }

        $role->delete();
        $this->notification()->success('Rol eliminado con éxito');
    }

    public function save(){
        $this->validate();

        if($this->roleId){
            $role = Role::findById($this->roleId);
            $role->update(['name' => $this->name]);
        } else {
            $role = Role::create(['name' => $this->name]);
        }
        // Antes de syncPermissions, filtra solo los que sí existen en DB
        $validPermissions = Permission::whereIn('name', $this->selectedPermissions)->pluck('name');
        $role->syncPermissions($validPermissions);
        $this->roleModal = false;
        $this->notification()->success('Rol guardado correctamente');
    }
    public function render()
    {
        /** @var \App\Models\User $user */
        $user            = Auth::user();
        $this->canManage = $user?->hasAnyRole(['Superadmin']) ?? false;

        $groupedPermissions = Permission::all()->groupBy(function($perm) {
        $parts = explode('.', $perm->name);
        return $parts[1] ?? 'otros';
        });

        return view('livewire.roles.role-index', [
            'permissions' => $groupedPermissions,
            'canManage' =>$this->canManage,
        ]);
    }
}
