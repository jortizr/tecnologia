<?php

namespace App\Livewire\Superadmin;

use Livewire\Component;
use Laravel\Jetstream\InteractsWithBanner;
use Livewire\WithPagination;
use WireUi\Traits\WireUiActions;

class GenericCatalog extends Component
{
    use WithPagination, InteractsWithBanner, WireUiActions;
    public $modelPath;
    public $modelName;
    public $withRelationships = [];
    public $isOpen = false;

    //campos del form
    public $selectedId;
    public $name;

    public function mount($model, $with = []){
        $this->modelName = $model;
        $this->modelPath = "App\\Models\\" . $model;
        $this->withRelationships = $with;
    }

    public function render()
    {
        $query = $this->modelPath::query();

        if (!empty($this->withRelationships)) {
            $query->with($this->withRelationships);
        }

        $user = Auth::user();
        $canManage = $user ? $user->hasAnyRole(['Superadmin', 'Manage']) : false;

        return view('livewire.superadmin.generic-catalog', [
            'items' => $query->paginate(10),
            'canManage' => $canManage
        ]);
    }

    public function create()
    {
        $this->reset(['name', 'selectedId']);
        $this->isOpen = true;
    }

    public function edit($id)
    {
        $record = $this->modelPath::findOrFail($id);
        $this->selectedId = $id;
        $this->name = $record->name;
        $this->isOpen = true;
    }

    public function save(){
        $this->validate(['name' => 'required|min:3']);

        $this->modelPath::updateOrCreate(
            ['id' => $this->selectedId],
            ['name' => $this->name]
        );

        $this->notification()->success(
            $title = $this->selectedId ? 'Actualizado' : 'Creado',
            $description = "El registro en {$this->modelName} se guardó con éxito."
        );

        $this->isOpen = false;
    }

    public function deleteConfirm($id)
    {
        $this->dialog()->confirm([
            'title'       => '¿Estás seguro?',
            'description' => 'Esta acción no se puede deshacer.',
            'icon'        => 'error',
            'accept'      => [
                'label'  => 'Sí, eliminar',
                'method' => 'delete',
                'params' => $id,
            ],
        ]);
    }

    public function delete($id)
    {
        $this->modelPath::destroy($id);
        // try {
        //     $record = $this->modelPath::findOrFail($id);
        //     // $this->authorize('delete', $record); // Opcional si usas Policies
        //     $record->delete();
        //     $this->banner('Registro eliminado correctamente.');
        // } catch (\Exception $e) {
        //     $this->dangerBanner('Error al eliminar: ' . $e->getMessage());
        // }
    }
}
