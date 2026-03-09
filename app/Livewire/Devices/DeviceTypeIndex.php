<?php

namespace App\Livewire\Devices;

use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\DeviceType;
use Livewire\WithPagination;
use WireUi\Traits\WireUiActions;
use App\Traits\WithSearch;
use Livewire\Attributes\{Locked, Computed};
use Illuminate\Validation\Rule;

class DeviceTypeIndex extends Component
{
    use AuthorizesRequests, WithSearch, WireUiActions, WithPagination;
    public bool $deviceTypeModal = false;
    public bool $isEditing = false;
    public $name, $description;

    #[Locked]
    public $deviceTypeId;

    public function mount(){
        $this->authorize('viewAny', DeviceType::class);
    }

    #[Computed]
    public function deviceTypes(){
        return DeviceType::query()->with(['creator:id,name', 'updater:id,name'])
            ->when($this->search, function($query){
                $query->where('name', 'like', "%{$this->search}%");
            })
            ->latest()
            ->paginate(15);
    }

    public function create(){
        $this->reset('name', 'isEditing');
        $this->deviceTypeModal = true;
    }

    public function edit($id){
        $deviceType = DeviceType::findOrFail($id);
        $this->deviceTypeId = $id;
        $this->name = $deviceType->name;
        $this->isEditing = true;
        $this->deviceTypeModal = true;
    }

    public function save(){
        $data = $this->validate([
            'name' => [
                'required',
                'min:2',
                'max:25',
                Rule::unique(DeviceType::class, 'name')->ignore($this->isEditing ? $this->deviceTypeId : null)
            ],
            'description' => 'required|min:4|max:90'
        ]);

        if($this->isEditing){
            $deviceType = DeviceType::findOrFail($this->deviceTypeId);
            $this->authorize('update', DeviceType::class);

            $deviceType->update($data);
            $this->notification()->success('Actualizado', 'Los cambios se guardaron con éxito');
        } else {
            $this->authorize('create', DeviceType::class);
            DeviceType::create($data);
            $this->notification()->success('Creado', 'Nuevo tipo de dispositivo registrado');
        }
        $this->deviceTypeModal = false;
        unset($this->deviceTypes);
        $this->dispatch('modal-updated');
    }

    public function confirmDelete($deviceTypeId){
        $this->dialog()->confirm([
            'title'       => '¿Eliminar tipo de dispositivo?',
            'description' => 'Esta acción no se puede deshacer.',
            'icon'        => 'error',
            'accept'      =>   [
                'label'  => 'Eliminar',
                'method' => 'delete',
                'params' => $deviceTypeId,
            ],
            'reject' => [
                'label'  => 'Cancelar',
            ]
        ]);
    }

    public function delete($deviceTypeId){
        try {
            $deviceType = DeviceType::withCount('deviceModels')->findOrFail($deviceTypeId);
            $this->authorize('delete', $deviceType);

            if($deviceType->device_models_count > 0){
                $this->notification()->error('Accion denegada', "No puedes eliminar este tipo de dispositivo porque tiene {$deviceType->device_models_count} modelos asociados.");
                return;
            }

            $deviceType->delete();
            $this->notification()->success('Notificacion', 'Tipo de dispositivo eliminado con éxito');
            unset($this->deviceTypes);

        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            $this->notification()->error('Acceso denegado', 'No tienes permisos para realizar esta acción.');
        } catch (\Exception $e) {
            $this->notification()->error('Error', 'Ocurrió un error inesperado.');
        }
    }

    public function render()
    {
        return view('livewire.devices.device-type-index');
    }
}
