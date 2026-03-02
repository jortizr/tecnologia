<?php

namespace App\Livewire\OperationalStates;

use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\{Locked, Computed};
use App\Models\OperationalState;
use App\Traits\WithSearch;
use Livewire\WithPagination;
use WireUi\Traits\WireUiActions;
use Illuminate\Validation\Rule;

class OperationalStateIndex extends Component
{
    use WithPagination, AuthorizesRequests, WithSearch, WireUiActions;

    public bool $operationalStateModal = false;
    public ?OperationalState $operationalState = null;
    public $isEditing = false;
    public $name, $description;

    #[Locked]
    public $operationalStateId;

    public function mount(){
        $this->authorize('viewAny', OperationalState::class);
    }

    #[Computed]
    public function operationalStates(){
        return OperationalState::query()->with(['creator:id,name', 'updater:id,name'])
        ->when($this->search, function ($query) {
            $query->where('name', 'like', "%{$this->search}%");
        })->latest()->paginate(10);
    }

    public function create(){
        $this->reset('name', 'description', 'isEditing', 'operationalStateId');
        $this->operationalStateModal =true;
    }

    public function edit($id){
        $operationalState = OperationalState::findOrFail($id);
        $this->operationalStateId = $id;
        $this->name = $operationalState->name;
        $this->description = $operationalState->description;
        $this->isEditing=true;
        $this->operationalStateModal = true;
    }

    public function save(){
        $this->validate([
            'name' => ['required', 'min:3', 'max:50',
            Rule::unique('operational_states', 'name')->ignore($this->isEditing ? $this->operationalStateId : null)],
            'description' => ['required', 'min:10', 'max:80']
        ]);

        if($this->isEditing){
            $operationalState = OperationalState::findOrFail($this->operationalStateId);
            $this->authorize('update', $operationalState);

            $operationalState->update(['name'=>$this->name, 'description'=>$this->description]);
            $this->notification()->success('Actualizado', 'Los cambios se guardaron con éxito');
        } else {
            $this->authorize('create', OperationalState::class);
            OperationalState::create([
                'name' => $this->name,
                'description' =>$this->description
            ]);
            $this->notification()->success('Estado Operativo', 'Nuevo estado operativo registrado con éxito');
        }

        $this->operationalStateModal =false;
        unset($this->operationalStates);
        $this->dispatch('modal-updated');
    }

    public function confirmDelete($operationalStateId){

        $this->dialog()->confirm([
            'title'       => '¿Eliminar el Estado Operativo?',
            'description' => 'Esta acción no se puede deshacer.',
            'icon'        => 'error',
            'accept'      => [
                'label'  => 'Eliminar',
                'method' => 'delete', // Llama a tu función delete existente
                'params' => $operationalStateId,
            ],
            'reject'      => [
                'label' => 'Cancelar',
            ],
        ]);
    }

    public function delete($operationalStateId){
        try{
            $operationalState = OperationalState::withCount('devices')->findOrFail($operationalStateId);
            $this->authorize('delete', $operationalState);

            if($operationalState->devices_count > 0){
                $this->notification()->error('Accion denegada', "No puedes eliminar este Estado porque tiene {$operationalState->devices_count} colaboradores asociados.");
                return;
            }

            $operationalState->delete();
            $this->notification()->success('Eliminando', 'Estado operativo eliminado correctamente');
            unset($this->operationalStates);

        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            $this->notification()->error('Acceso denegado', 'No tienes permisos para realizar esta acción.');
        } catch (\Exception $e) {
            $this->notification()->error('Error', 'Ocurrió un error inesperado.'. $e);
        }
    }

    public function render()
    {
        return view('livewire.operational-states.operational-state-index');
    }
}
