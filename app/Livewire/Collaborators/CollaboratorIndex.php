<?php

namespace App\Livewire\Collaborators;

use App\Models\Collaborator;
use App\Models\Occupation;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use WireUi\Traits\WireUiActions;
use App\Traits\WithSearch;
use Livewire\Attributes\{On, Computed, Locked};
use App\Models\Department;
use App\Models\Regional;

class CollaboratorIndex extends Component
{
    use WithPagination, AuthorizesRequests, WireUiActions, WithSearch;
    public bool $collaboratorModal = false;
    public bool $importModal = false;
    protected $listeners=[
        'import-finished' => 'handleImportFinished'
    ];

    public bool $isEditing = false;
    public ?Collaborator $collaborator;
    public $canManage;
    public $names, $last_name, $identification, $payroll_code, $department_id, $regional_id, $occupation_id, $is_active;
    protected $casts = ['is_active' => 'boolean',];

    #[Locked]
    public $collaboratorId;

    protected $rules = [
        'names' => 'required|string|min:3|max:50',
        'last_name'  => 'required|string|min:3|max:50',
        'identification' => 'required|min:5|max:10|unique:collaborators,identification',
        'payroll_code' => 'required|min:3|max:50|unique:collaborators,payroll_code',
        'department_id' => 'required|exists:departments,id',
        'regional_id' => 'required|exists:regionals,id',
        'occupation_id'  => 'required|exists:occupations,id',
        'is_active' => 'required|boolean',
    ];

    #[Computed]
    public function collaborators(){
        return Collaborator::query()->with(['department:id,name','regional:id,name','occupation:id,name'])
        ->when($this->search, function($query){
            $query->where('names', 'like', "%{$this->search}%")
            ->orWhere('last_name', 'like', "%{$this->search}%")
            ->orWhere('payroll_code', 'like', "%{$this->search}%")
            ->orWhere('identification', 'like', "%{$this->search}%")
            ;
        })
        ->latest()
        ->paginate(10);
    }

    #[Computed]
    public function departments(){
        return Department::select('id', 'name')->orderBy('name','asc')->get();
    }

    #[Computed]
    public function regionals(){
        return Regional::select('id', 'name')->orderby('name', 'asc')->get();
    }

    #[Computed]
    public function occupations(){
        return Occupation::select('id', 'name')->orderby('name', 'asc')->get();
    }

    public function mount(){
        $this->authorize('viewAny', Collaborator::class);
    }

    public function create(){
        $this->authorize('create', Collaborator::class);

        $this->reset(['names', 'last_name', 'identification', 'payroll_code', 'department_id', 'regional_id', 'occupation_id', 'is_active']);
        $this->is_active = true;
        $this->collaboratorModal = true;
    }

    public function edit($id){
        $collaborator = Collaborator::findOrFail($id);
        $this->collaboratorId = $id;
        $this->names = $collaborator->names;
        $this->last_name = $collaborator->last_name;
        $this->identification = $collaborator->identification;
        $this->payroll_code = $collaborator->payroll_code;
        $this->department_id = $collaborator->department_id;
        $this->regional_id = $collaborator->regional_id;
        $this->occupation_id = $collaborator->occupation_id;
        $this->is_active = $collaborator->is_active;
        $this->isEditing = true;
        $this->collaboratorModal = true;
    }

    public function handleImportFinished(){
        $this->importModal = false;
        unset($this->collaborators);
        $this->dispatch('model-updated');
    }

    public function save()
    {
        $rules = [
            'names'         => 'required|string|min:3|max:50',
            'last_name'     => 'required|string|min:3|max:50',
            'department_id' => 'required|exists:departments,id',
            'regional_id'   => 'required|exists:regionals,id',
            'occupation_id' => 'required|exists:occupations,id',
            // Validaciones unique ignorando el ID actual si es edición
            'identification'=> 'required|min:5|max:15|unique:collaborators,identification,' . ($this->collaboratorId ?? 'NULL'),
            'payroll_code'  => 'required|min:3|max:50|unique:collaborators,payroll_code,' . ($this->collaboratorId ?? 'NULL'),
        ];

        $this->validate($rules);

        $data = [
            'names'         => $this->names,
            'last_name'     => $this->last_name,
            'identification'=> $this->identification,
            'payroll_code'  => $this->payroll_code,
            'department_id' => $this->department_id,
            'regional_id'   => $this->regional_id,
            'occupation_id' => $this->occupation_id,
            'is_active'     => $this->is_active,
        ];

        if ($this->isEditing) {
            $collaborator = Collaborator::findOrFail($this->collaboratorId);
            $this->authorize('update', $collaborator);
            $data['updated_by'] = Auth::id();
            $collaborator->update($data);
            $this->notification()->success('Actualizado', 'Colaborador actualizado con éxito');
        } else {
            $this->authorize('create', Collaborator::class);
            $data['created_by'] = Auth::id();
            Collaborator::create($data);
            $this->notification()->success('Creado', 'Nuevo colaborador registrado');
        }

        $this->collaboratorModal = false;
        unset($this->collaborators); // Limpiar caché
        $this->dispatch('model-updated');
    }

    public function confirmDelete($collaboratorId)
    {
        $this->dialog()->confirm([
            'title'       => '¿Eliminar colaborador?',
            'description' => 'Esta acción no se puede deshacer.',
            'icon'        => 'error',
            'accept'      => [
                'label'  => 'Eliminar',
                'method' => 'delete', // Llama a tu función delete existente
                'params' => $collaboratorId,
            ],
            'reject' => [
                'label'  => 'Cancelar',
            ],
        ]);
    }
    public function delete($collaboratorId)
    {
        $collaborator = Collaborator::findOrFail($collaboratorId);
        $this->authorize('delete', $collaborator);

        try {
            $collaborator->delete();
            unset($this->collaborators);
            $this->notification()->success( 'Eliminado', 'Colaborador eliminado con éxito');
            $this->dispatch('model-updated');
        } catch (\Exception $e) {
            $this->notification()->send([
                'icon'        => 'error',
                'title'       => 'Notificacion de Error',
                'description' => 'No se pudo eliminar: ' . $e->getMessage(),
            ]);
        }
    }


#[On('toggleStatus')]
public function toggleStatus($collaboratorId)
{
    try {
        $collaborator = Collaborator::findOrFail($collaboratorId);
        $this->authorize('update', $collaborator);

        // Invertimos el estado
        $newStatus = !$collaborator->is_active;
        $collaborator->update(['is_active' => $newStatus]);

        // Limpiamos la caché del Computed Property para refrescar la tabla
        unset($this->collaborators);

        // Disparamos la notificación basada en el nuevo estado real
        if ($newStatus) {
            $this->notification()->success(
                title: 'Colaborador Activado',
                description: "{$collaborator->names} ahora está activo."
            );
        } else {
            $this->notification()->warning(
                title: 'Colaborador Desactivado',
                description: "{$collaborator->names} ha sido desactivado."
            );
        }
    } catch (\Exception $e) {
        $this->notification()->error('Error', 'No se pudo actualizar el estado.');
    }
}


    public function render()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $this->canManage = $user?->hasAnyRole(['Superadmin', 'Manage', 'Viewer']) ?? false;

        return view('livewire.collaborators.collaborator-index', [
            'canManage'=> $this->canManage,
        ]);
    }
}
