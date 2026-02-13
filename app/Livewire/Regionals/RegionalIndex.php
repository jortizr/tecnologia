<?php

namespace App\Livewire\Regionals;

use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Traits\WithSearch;
use Livewire\WithPagination;
use WireUi\Traits\WireUiActions;
use Livewire\Attributes\{Locked, Computed};
use App\Models\Regional;

class RegionalIndex extends Component
{
    use WithPagination, AuthorizesRequests, WithSearch, WireUiActions;
    public bool $regionalModal = false;
    public ?Regional $regional = null;
    public bool $isEditing = false;
    public $name;

    #[Locked]
    public $regionalId;

    public function mount(){
        $this->authorize('viewAny', Regional::class);
    }

    #[Computed]
    public function regionals(){
        return Regional::query()->with(['creator:id,name', 'updater:id,name'])
            ->when($this->search, function($query){
                $query->where('name', 'like', "%{$this->search}%");
            })->latest()->paginate(10);
    }

    public function create(){
        $this->reset(['name', 'isEditing', 'regionalId']);
        $this->regionalModal = true;
    }

    public function edit($id){
        $regional = Regional::findOrFail($id);
        $this->regionalId = $id;
        $this->name = $regional->name;
        $this->isEditing = true;
        $this->regionalModal = true;
    }

    public function save(){
        $this->validate([
            'name' => 'required|min:3|max:50|unique:regionals,name,' . ($this->isEditing ? $this->regionalId : 'NULL')
        ]);

        if($this->isEditing){
            $regional = Regional::findOrFail($this->regionalId);
            $this->authorize('update', $regional);

            $regional->update(['name' => $this->name]);
            $this->notification()->success('Actualizado', 'Los cambios se guardaron con éxito');
        } else {
            $this->authorize('create', Regional::class);
            Regional::create([
                'name'       => $this->name,
            ]);
            $this->notification()->success('Regional creada', 'Nueva regional registrada con éxito');
        }

        $this->regionalModal = false;
        unset($this->regionals);
        $this->dispatch('modal-updated');
    }

        public function confirmDelete($regionalId)
    {
        $this->dialog()->confirm([
            'title'       => '¿Eliminar la regional?',
            'description' => 'Esta acción no se puede deshacer.',
            'icon'        => 'error',
            'accept'      => [
                'label'  => 'Eliminar',
                'method' => 'delete', // Llama a tu función delete existente
                'params' => $regionalId,
            ],
            'reject'      => [
                'label' => 'Cancelar',
            ],
        ]);
    }

    public function delete($regionalId)
    {
        try {
            $regional = Regional::withCount('collaborators')->findOrFail($regionalId);
            // Si usas Policies de Spatie/Laravel
            $this->authorize('delete', $regional);

            if($regional->collaborators_count > 0){
                $this->notification()->error('Accion denegada', "No puedes eliminar esta regional porque tiene {$regional->collaborators_count} colaboradores asociados.");
                return;
            }
            $regional->delete();
            $this->notification()->success('Éxito', 'Fabricante eliminado correctamente');
            unset($this->regionals);

        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            $this->notification()->error('Acceso denegado', 'No tienes permisos para realizar esta acción.');
        } catch (\Exception $e) {
            $this->notification()->error('Error', 'Ocurrió un error inesperado.'. $e);
        }
    }

    public function render()
    {
        return view('livewire.regionals.regional-index');
    }
}
