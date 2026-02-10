<?php

namespace App\Livewire\Devices;

use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use App\Models\DeviceModel;
use Livewire\WithPagination;
use WireUi\Traits\WireUiActions;
use Livewire\Attributes\{Locked, Computed};
use App\Models\Brand;
use App\Traits\WithSearch;//trait para el input de busquedas

class ModelIndex extends Component
{
    use WithPagination, AuthorizesRequests, WireUiActions, WithSearch;
    public bool $deviceModelModal = false;
    public ?DeviceModel $deviceModel = null;
    public bool $isEditing = false;
    public $name;

    public $brandId;

    #[Locked]
    public $deviceModelId;

    public function mount(){
        $this->authorize('viewAny', DeviceModel::class);
    }

    #[Computed]
    public function deviceModels()
    {
        // La consulta se queda aquí para ser eficiente
        return DeviceModel::query()->with(['brand:id,name','creator:id,name', 'updater:id,name'])
        ->when($this->search, function($query){
            $query->where(function($q){ //agrupacion del OR
                $q->where('name', 'like', "%{$this->search}%")
                ->orWhereHas('brand', function($q2){
                    $q2->where('name', 'like', "%{$this->search}%");
                });
            });
        })->latest()->paginate(10);
    }
    #[Computed]
    public function brands()
    {
        return Brand::select('id', 'name')->orderBy('name', 'asc')->get();
    }

    public function render()
    {
        return view('livewire.devices.model-index');
    }

    public function create(){
        $this->reset(['name', 'brandId', 'isEditing']);
        $this->deviceModelModal = true;
    }

    public function edit($id){
        $deviceModel = DeviceModel::findOrFail($id);
        $this->deviceModelId = $id;
        $this->name = $deviceModel->name;
        $this->brandId = $deviceModel->brand_id;
        $this->isEditing = true;
        $this->deviceModelModal = true;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|min:3|max:50|unique:device_models,name,' . ($this->isEditing ? $this->deviceModelId : 'NULL'),
            'brandId' => 'required|exists:brands,id',
        ]);

        if ($this->isEditing) {
            $deviceModel = DeviceModel::findOrFail($this->deviceModelId);
            $this->authorize('update', $deviceModel);

            $deviceModel->update([
                    'name' => $this->name,
                    'brand_id' => $this->brandId
            ]);
            $this->notification()->success( 'Actualizado.', 'Modelo actualizado con éxito');
        } else {
            $this->authorize('create', DeviceModel::class);
            DeviceModel::create([
                'name' => $this->name,
                'brand_id' => $this->brandId
            ]);
            $this->notification()->success('Modelo creado.', 'Nuevo modelo registrado');
        }

        $this->deviceModelModal = false;
        unset($this->deviceModels);
        $this->dispatch('model-updated');
    }

    public function confirmDelete($modelId)
    {
        $this->dialog()->confirm([
            'title'       => '¿Eliminar colaborador?',
            'description' => 'Esta acción no se puede deshacer.',
            'icon'        => 'error',
            'accept'      => [
                'label'  => 'Eliminar',
                'method' => 'delete', // Llama a tu función delete existente
                'params' => $modelId,
            ],
            'reject' => [
                'label'  => 'Cancelar',
            ],
        ]);
    }

    public function delete($deviceModelId)
    {
        try {
            $deviceModel = DeviceModel::findOrFail($deviceModelId);
            $this->authorize('delete', $deviceModel);
            $deviceModel->delete();
            $this->notification()->success( 'Notificacion', 'Modelo eliminado con éxito');
            unset($this->deviceModels);

        } catch (\Exception $e) {
            $this->notification()->error('Error', 'Ocurrió un error inesperado.');
        }
    }
}
