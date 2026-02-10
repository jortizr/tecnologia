<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use WireUi\Traits\WireUiActions;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class RoleIndex extends Component
{
    use WireUiActions, WithPagination;

    public bool $roleModal = false;
    public bool $isEditing = false;
    public $name;
    public $description;
    public array $selectedPermissions = [];

    #[Locked]
    public $roleId;

    #[Computed]
    public function roles(){
        return Role::with('permissions')->paginate(10);
    }

    public function create(){
        $this->reset(['name', 'description', 'roleId', 'selectedPermissions', 'isEditing']);
        $this->roleModal = true;
    }

    public function edit($id){
        $role = Role::findOrFail($id);
        $this->roleId = $id;
        $this->name = $role->name;
        $this->description = $role->description;
        $this->selectedPermissions = $role->permissions->pluck('name')->toArray();
        $this->isEditing = true;
        $this->roleModal = true;
    }

    public function confirmDelete($id)
    {
        $this->dialog()->confirm([
            'title'       => '¿Eliminar Rol?',
            'description' => 'Esta acción no se puede deshacer.',
            'icon'        => 'error',
            'accept'      => [
                'label'  => 'Eliminar',
                'method' => 'delete',
                'params' => $id,
            ],
            'reject' => [
                'label'  => 'Cancelar',
            ],
        ]);
    }

    public function delete($id)
    {
        try {
            $role = Role::findOrFail($id);

            if($role->name === 'Superadmin'){
                $this->notification()->error('Error', 'No puedes eliminar el rol crítico Superadmin');
                return;
            }

            $role->delete();
            $this->notification()->success('Éxito', 'Rol eliminado correctamente');
            unset($this->roles);

        } catch (\Exception $e) {
            $this->notification()->error('Error', 'No se pudo eliminar el rol.');
        }
    }

    public function save(){
        $this->name = ucfirst(trim(strtolower($this->name)));

        $this->validate([
                'name' => 'required|min:3|max:50|unique:roles,name,' . ($this->isEditing ? $this->roleId : 'NULL'),
                'description' => 'nullable|string|max:255',
        ]);

        if ($this->isEditing) {
            $role = Role::findOrFail($this->roleId);
            $role->update([
                'name' => $this->name,
                'description' => $this->description,
            ]);
            $this->notification()->success('Actualizado', 'Rol actualizado con éxito');
        } else {
            // IMPORTANTE: Spatie requiere 'guard_name', usualmente es 'web'
            Role::create([
                'name' => $this->name,
                'description' => $this->description,
                'guard_name' => 'web'
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
        $groupedPermissions = Permission::all()->groupBy(function($perm) {
            $parts = explode('.', $perm->name);
            return $parts[1] ?? 'otros';
        });

        return view('livewire.roles.role-index', [
            'permissions' => $groupedPermissions,
        ]);
    }
}
