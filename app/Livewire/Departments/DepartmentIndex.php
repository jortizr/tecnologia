<?php

namespace App\Livewire\Departments;

use Livewire\Component;
use WireUi\Traits\WireUiActions;
use App\Models\Department;
use Livewire\Attributes\{Locked, Computed};
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Traits\WithSearch;

class DepartmentIndex extends Component
{
    use WithPagination, AuthorizesRequests, WireUiActions, WithSearch;
    public bool $departmentModal = false;
    public bool $isEditing = false;
    public ?Department $department = null;
    public $name;
    #[Locked]
    public $departmentId;
    public $canManage;


    #[Computed]
    public function departments()
    {
        return Department::query()->with(['creator:id,name', 'updater:id,name'])
            ->when($this->search, function($query){
                $query->where('name', 'like', "%{$this->search}%");
            })
            ->paginate(10);
    }

    public function render()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $this->canManage = $user?->hasAnyRole(['Superadmin', 'Manage']) ?? false;
        return view('livewire.departments.department-index');
    }

    public function create(){
        $this->reset(['name', 'isEditing', 'departmentId']);
        $this->departmentModal = true;
    }

    public function edit($id){
        $department = Department::findOrFail($id);
        $this->departmentId = $id;
        $this->name = $department->name;
        $this->isEditing = true;
        $this->departmentModal = true;
    }

    public function store(){
        $rules =[
        'name'=> 'required|min:3|max:50|unique:departments,name' . ($this->isEditing ? $this->department->id : 'NULL'),
        ];

        $this->validate($rules);

        if($this->isEditing){
            $department = Department::findOrFail($this->departmentId);
            $this->authorize('update', $department);
            $this->department->update([
                'name' => $this->name,
                'updated_by' => Auth::id()
            ]);
            $this->notification()->success('Actualizado', 'Departamento actualizado con éxito');
        } else {
            $this->authorize('create', Department::class);
            Department::create([
                'name'=> $this->name,
                'created_by' => Auth::id()
            ]);
            $this->notification()->success('Creado', 'Nuevo departamento registrado');
        }

        $this->departmentModal = false;
        unset($this->departments);
        $this->dispatch('model-updated');
    }

    public function confirmDelete($departmentId){
        $this->dialog()->confirm([
            'title'       => '¿Eliminar departamento?',
            'description' => 'Esta acción no se puede deshacer.',
            'icon'        => 'error',
            'accept'      => [
                'label'  => 'Eliminar',
                'method' => 'delete',
                'params' => $departmentId,
            ],
            'reject' => [
                'label'  => 'Cancelar',
            ],
        ]);
    }

    public function delete($departmentId){
        try{
            $department = Department::findOrFail($departmentId);
            $this->authorize('delete', $department);
            $department->delete();
            $this->notification()->success('Eliminado', 'Departamento eliminado con éxito');
            unset($this->departments);

        } catch (\Exception $e){
            $this->notification()->send([
                'icon'        => 'error',
                'title'       => 'Notificacion de Error',
                'description' => 'No se pudo eliminar: ' . $e->getMessage(),
            ]);
        }
    }
}
