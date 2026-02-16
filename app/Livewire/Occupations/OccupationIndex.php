<?php

namespace App\Livewire\Occupations;

use Livewire\Component;
use App\Models\Occupation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\WithPagination;
use WireUi\Traits\WireUiActions;
use App\Traits\WithSearch;
use Livewire\Attributes\{Locked, Computed};
use Illuminate\Validation\Rule;

class OccupationIndex extends Component
{
    use WithPagination, AuthorizesRequests, WithSearch, WireUiActions;
    public bool $occupationModal = false;
    public ?Occupation $occupation = null;
    public bool $isEditing = false;
    public $name;

    #[Locked]
    public $occupationId;

    public function mount(){
        $this->authorize('viewAny', Occupation::class);
    }

    #[Computed]
    public function occupations(){
        return Occupation::query()->with(['creator:id,name', 'updater:id,name'])
            ->when($this->search, function($query){
                $query->where('name', 'like', "%{$this->search}%");
            })->latest()->paginate(10);
    }

    public function create(){
        $this->reset(['name', 'isEditing', 'occupationId']);
        $this->occupationModal = true;
    }

    public function edit($id){
        $occupation = Occupation::findOrFail($id);
        $this->occupationId = $id;
        $this->name = $occupation->name;
        $this->isEditing = true;
        $this->occupationModal = true;
    }

    public function save(){
        $this->validate([
            'name' => ['required', 'min:3', 'max:50',
            Rule::unique('occupations', 'name')->ignore($this->isEditing ? $this->occupationId : null)]
        ]);

        if($this->isEditing){
            $occupation = Occupation::findOrFail($this->occupationId);
            $this->authorize('update', $occupation);

            $occupation->update(['name' => $this->name]);
            $this->notification()->success('Actualizado', 'los cambios se guardaron con éxito');
        } else {
            $this->authorize('create', Occupation::class);
            Occupation::create([
                'name' => $this->name,
            ]);
            $this->notification()->success('Cargo creado', 'Nuevo cargo registrado con éxito');
        }

        $this->occupationModal = false;
        unset($this->occupations);
        $this->dispatch('modal-updated');
    }

    public function confirmDelete($regionalId){
        $this->dialog()->confirm(
            ['title' => '¿Eliminar el cargo?',
            'description' => 'Esta accion no se puede deshacer.',
            'icon' => 'error',
            'accept' => [
                'label' => 'Eliminar',
                'method' => 'delete',
                'params' => $regionalId,
            ],
            'reject' => [
                'label' => 'Cancelar',
            ]
        ]);
    }

    public function delete($regionalId){
        try{
            $occupation = Occupation::withCount('collaborators')->findOrFail($regionalId);
            $this->authorize('delete', $occupation);

            if($occupation->collaborators_count > 0){
                $this->notification()->error('Accion denegada', "No puedes eliminar este cargo porque tiene {$occupation->collaborators_count} colaboradores asociados.");
                return;
            }
            $occupation->delete();
            $this->notification()->success('Éxito', 'Cargo eliminado correctamente');
            unset($this->occupations);
            
        } catch (\Illuminate\Auth\Access\AuthorizationException $e){
            $this->notification()->error('Acceso denegado', 'No tienes permisos para realizar esta acción.');
        } catch (\Exception $e){
            $this->notification()->error('Error', 'Ocurrió un error inesperado.' . $e);
        }
    }

    public function render()
    {
        return view('livewire.occupations.occupation-index');
    }
}
