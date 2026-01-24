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
use Livewire\Attributes\Computed;
use App\Models\Department;
use App\Models\Regional;

class CollaboratorIndex extends Component
{
    use WithPagination, AuthorizesRequests, WireUiActions, WithSearch;
    public bool $collaboratorModal = false;
    public ?Collaborator $collaborator = null;
    public $names;
    public $last_name;
    public $identification;
    public $payroll_code;
    public $department_id;
    public $regional_id;
    public $occupation_id;
    public $isEditing = false;
    public $is_active;

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
        return Collaborator::query()->with(['department:id,name','regional:id,name','occupation:id,name','creator:id,name','updater:id,name'])
        ->when($this->search, function($query){
            $query->where('names', 'like', '%' . $this->search . '%');
        })
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

    public function render()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $canManage = $user ? $user->hasAnyRole(['Superadmin', 'Manage']) : false;

        return view('livewire.collaborators.collaborator-index', [
            'canManage'=> $canManage,
        ]);
    }

    public function create(){
        $this->reset(['names', 'last_name', 'identification', 'payroll_code', 'department_id', 'regional_id', 'occupation_id', 'is_active']);
        $this->collaboratorModal = true;
    }

    public function edit(Collaborator $collaborator){
        $this->collaborator = $collaborator;
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

        public function store()
    {
        // Validamos: si editamos, ignoramos el nombre del modelo actual en el unique
        $this->validate([
            'names' => 'required|string|min:3|max:50|' . ($this->isEditing ? $this->collaborator->id : 'NULL'),
            'last_name'  => 'required|string|min:3|max:50',
            'identification' => 'required|min:5|max:10|unique:collaborators,identification',
            'payroll_code' => 'required|min:3|max:50|unique:collaborators,payroll_code',
            'department_id' => 'required|exists:departments,id',
            'regional_id' => 'required|exists:regionals,id',
            'occupation_id'  => 'required|exists:occupations,id',
            'is_active' => 'required|boolean',
        ]);
        $data = [
            'name' => $this->name,
            'last_name' => $this->last_name,
            'identification' => $this->identification,
            'payroll_code' => $this->payroll_code,
            'department_id' => $this->department_id,
            'regional_id' => $this->regional_id,
            'occupation_id'  => $this->occupation_id,
            'is_active' => $this->is_active,
            'updated_by' => Auth::user()->id,
        ];

        if ($this->isEditing) {
            $this->collaborator->update($data);
            $this->notification()->success( 'Modelo actualizado.', 'Modelo actualizado con éxito');
        } else {
            $data['created_by'] = Auth::user()->id;
            Collaborator::create($data);
            $this->notification()->success('Modelo creado.', 'Nuevo modelo registrado');
        }

        $this->collaboratorModal = false;
        $this->reset(['names', 'last_name', 'identification', 'payroll_code', 'department_id', 'regional_id', 'occupation_id', 'is_active']);
    }

    public function delete($collaboratorId)
    {
        $collaborator = Collaborator::findOrFail($collaboratorId);
        $this->authorize('delete', $collaborator);

        try {
            $collaborator->delete();
            $this->notification()->success( 'Notificacion', 'Colaborador eliminado con éxito');
        } catch (\Exception $e) {
            $this->notification()->send([
                'icon'        => 'error',
                'title'       => 'Notificacion de Error',
                'description' => 'No se pudo eliminar: ' . $e->getMessage(),
            ]);
        }
    }
}
