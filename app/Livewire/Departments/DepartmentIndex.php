<?php

namespace App\Livewire\Departments;

use Livewire\Component;
use WireUI\Traits\WireUiActions;
use App\Models\Department;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Traits\WithSearch;

class DepartmentIndex extends Component
{
    use WireUiActions, WithSearch;
    public bool $departmentModal = false;
    public ?Department $department = null;
    public $name;
    public bool $isEditing = false;
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

    public function create(){
        $this->reset(['name', 'isEditing']);
        $this->departmentModal = true;
    }

    public function edit(Department $department){
        $this->department = $department;
        $this->name = $department->name;
        $this->isEditing = true;
        $this->departmentModal = true;
    }

    public function store(){
        $rules =[
        'name'=> 'required|min:3|max:50|unique:departments,name',
        ];

        $this->validate($rules);
        $data = ['name' => $this->name];

        if($this->isEditing){
            $department = Department::findOrFail($this->departmentId);
            $this->authorize('update', $department);
            $data['updated_by'] = Auth::user()->id;
            $this->department->update($data);
            $this->notification()->success('Actualizado', 'Departamento actualizado con éxito');
        } else {
            $this->authorize('create', Department::class);
            $data['created_by'] = Auth::user()->id;
            Department::create($data);
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


    public function render()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $this->canManage = $user?->hasAnyRole(['Superadmin', 'Manage', 'Viewer']) ?? false;
        return view('livewire.departments.department-index');
    }
}
