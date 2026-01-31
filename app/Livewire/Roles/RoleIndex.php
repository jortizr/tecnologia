<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use WireUi\Traits\WireUiActions;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\Auth;

class RoleIndex extends Component
{
    use WireUiActions;

    public bool $roleModal = false;
    public bool $isEditing = false;
    public $name;
    public $canManage;
    public array $selectedPermissions = [];

    #[Locked]
    public $roleId;

    #[Computed]
    public function roles(){
        return Role::with('permissions')->paginate(10);
    }

    public function create(){
        $this->reset(['name', 'roleId', 'selectedPermissions', 'isEditing']);
        $this->roleModal = true;
    }

    public function edit($id){
        $role = Role::where('id', $id)->firstOrFail();
        $this->reset(['name', 'roleId', 'selectedPermissions']);
        $this->roleId = $id;
        $this->name = $role->name;
        $this->selectedPermissions = $role->permissions->pluck('name')->toArray();
        $this->isEditing = true;
        $this->roleModal = true;
    }

    public function delete($id){
        $role = Role::where('id', $id)->firstOrFail();

        if($role->name === 'Superadmin'){
            $this->notification()->error('No puedes eliminar el rol Superadmin');
            return;
        }

        $role->delete();
        unset($this->roles);
        $this->notification()->success('Rol eliminado con éxito');
    }

    public function save(){
        $rules = [
            'name' => 'required|string|max:255|unique:roles,name,' . $this->roleId,
            'selectedPermissions' => 'array'
        ];

        $this->validate($rules);

        if ($this->isEditing) {
            $role = Role::where('id', $this->roleId)->firstOrFail();
            $role->update(['name' => $this->name]);
            $this->notification()->success('Rol actualizado');
        } else {
            $role = Role::create([
                'name' => $this->name,
                'guard_name' => 'web' // Forzamos guard web para evitar errores de Sanctum
            ]);
            $this->notification()->success('Rol creado');
        }

        $permissions = Permission::whereIn('name', $this->selectedPermissions)
                             ->where('guard_name', 'web')
                             ->get();
        $role->syncPermissions($permissions);
        $this->roleModal = false;
        unset($this->roles);
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
