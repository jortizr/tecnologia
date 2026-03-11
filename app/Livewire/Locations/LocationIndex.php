<?php

namespace App\Livewire\Locations;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\{Locked, Computed};
use App\Models\Location;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\WireUiActions;
use Illuminate\Validation\Rule;
use App\Traits\WithSearch;

class LocationIndex extends Component
{
    use WithPagination, AuthorizesRequests, WireUiActions, WithSearch;
    public bool $locationModal = false;
    public bool $isEditing = false;
    public ?Location $location = null;
    public $name;

    #[Locked]
    public $locationId;

    public function mount(){
        $this->authorize('viewAny', Location::class);
    }

    #[Computed]
    public function locations(){
        return Location::query()->with(['creator:id,name', 'updater:id,name'])->when($this->search, function($query){
            $query->where('name', 'like', "%{$this->search}%");
        })->latest()->paginate(10);
    }

    public function create(){
        $this->reset(['name', 'locationId', 'isEditing']);
        $this->locationModal = true;
    }

    public function edit($id){
        $location = Location::findOrFail($id);
        $this->authorize('update', $location);
        $this->locationId = $id;
        $this->name = $location->name;
        $this->isEditing = true;
        $this->locationModal = true;
    }

    public function save()
    {
        $this->validate([
            'name' => ['required','min:3', 'max:50', Rule::unique('locations', 'name')->ignore($this->isEditing ? $this->locationId : null)],
        ]);

        if ($this->isEditing) {
            $location = Location::findOrFail($this->locationId);
            $this->authorize('update', $location);

            $location->update([
                    'name' => $this->name,
            ]);
            $this->notification()->success( 'Actualizado.', 'Ubicacion actualizada con éxito');
        } else {
            $this->authorize('create', Location::class);
            Location::create([
                'name' => $this->name,
            ]);
            $this->notification()->success('Ubicacion creada.', 'Nuevo ubicacion registrada');
        }
        $this->locationModal = false;
        unset($this->locations);
        $this->dispatch('model-updated');
    }

    public function confirmDelete($id)
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

    public function delete($locationId){
        try{
            $location = Location::withCount('devices')->findOrFail($locationId);
            $this->authorize('delete', $location);

            if($location->devices_count > 0){
                $this->notification()->error('Accion denegada', "No puedes eliminar este Estado porque tiene {$location->devices_count} dispositivos asociados.");
                return;
            }

            $location->delete();
            $this->notification()->success('Eliminando', 'Ubicacion eliminada correctamente');
            unset($this->locations);

        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            $this->notification()->error('Acceso denegado', 'No tienes permisos para realizar esta acción.');
        } catch (\Exception $e) {
            $this->notification()->error('Error', 'Ocurrió un error inesperado.'. $e);
        }
    }

    public function render()
    {
        return view('livewire.locations.location-index');
    }
}
