<?php

namespace App\Livewire\PhysicalStates;

use App\Models\PhysicalState;
use App\Traits\WithSearch;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\WireUiActions;

class PhysicalStateIndex extends Component
{
    use WithPagination, AuthorizesRequests, WithSearch, WireUiActions;
    public bool $physicalStateModal=false;
    public ?PhysicalState $physicalState = null;
    public bool $isEditing = false;
    public $name, $description;

    #[Locked]
    public $physicalStateId;


    public function mount(){
        $this->authorize('viewAny', PhysicalState::class);
    }

    #[Computed]
    public function physicalStates(){
        return PhysicalState::query()->with(['creator:id,name', 'updater:id,name'])
            ->when($this->search, function ($query){
                $query->where('name', 'like', "%{$this->search}%");
            })->latest()->paginate(10);
    }

    public function create(){
        $this->reset(['name', 'description', 'isEditing', 'physicalStateId']);
        $this->physicalStateModal= true;
    }

    public function edit($id){
        $physicalState = PhysicalState::findOrFail($id);
        $this->physicalStateId = $id;
        $this->name = $physicalState->name;
        $this->description = $physicalState->description;
        $this->isEditing = true;
        $this->physicalStateModal = true;
    }

    public function save(){
        $this->validate([
            'name' => ['required', 'min:3', 'max:50',
            Rule::unique(PhysicalState::class, 'name')->ignore( $this->isEditing ? $this->physicalStateId : null)],
            'description' => ['min:5', 'max:50', 'nullable']
        ]);

        if($this->isEditing){
            $physicalState = PhysicalState::findOrFail($this->physicalStateId);
            $this->authorize('update', $physicalState);

            $physicalState->update([
                'name' => $this->name,
                'description' => $this->description
            ]);
            $this->notification()->success('Actualizado', 'Los cambios se guardaron con éxito');
        } else {
            $this->authorize('create', PhysicalState::class);
            PhysicalState::create(['name' => $this->name, 'description' => $this->description]);
            $this->notification()->success('Estado creado', 'Nuevo estado fisico registrado con éxito');
        }

        $this->physicalStateModal = false;
        unset($this->physicalStates);
        $this->dispatch('modal-updated');
    }

    public function confirmDelete($physicalStateId){
        $this->dialog()->confirm([
        'title'       => '¿Eliminar la regional?',
        'description' => 'Esta acción no se puede deshacer.',
        'icon'        => 'error',
        'accept'      => [
        'label'  => 'Eliminar',
        'method' => 'delete', // Llama a tu función delete existente
        'params' => $physicalStateId,
        ],
        'reject' => [
            'label' => 'Cancelar',
        ],
        ]);
    }

    public function delete($physicalStateId){
        try{
            $physicalState = PhysicalState::withCount('devices')->findOrFail($physicalStateId);
            $this->authorize('delete', $physicalState);

            if($physicalState->devices_count > 0){
                $this->notification()->error('Accion denegada', "No puedes eliminar este estado porque tiene {$physicalState->devices_count} dispositivos asociados");
                return;
            }

            $physicalState->delete();
            $this->notification()->success('Éxito', 'Estado eliminado correctamente');
            unset($this->physicalStates);

        } catch(\Illuminate\Auth\Access\AuthorizationException $e){
            $this->notification()->error('Acceso denegado', 'No tienes permisos para realizar esta acción.');
        } catch(\Exception $e){
            $this->notification()->error('Error', 'Ocurrio un error inesperado' . $e);
        }
    }

    public function render()
    {
        return view('livewire.physical-states.physical-state-index');
    }
}
