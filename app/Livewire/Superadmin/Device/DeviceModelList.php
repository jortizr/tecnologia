<?php

namespace App\Livewire\Superadmin\Device;

use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use App\Models\DeviceModel;
use Livewire\WithPagination;
use WireUi\Traits\WireUiActions;
use Livewire\Attributes\Computed;
use App\Models\Brand;


class DeviceModelList extends Component
{
    use WithPagination, AuthorizesRequests, WireUiActions;
    public bool $deviceModelModal = false;
    public ?DeviceModel $deviceModel = null;
    public $name;
    public $isEditing = false;
    public $brand_id;

    protected $rules =[
        'name'=> 'required|min:3|max:50|unique:device_models,name',
        'brand_id' => 'required'
    ];
    #[Computed]
    public function deviceModels()
    {
        // La consulta se queda aquí para ser eficiente
        return DeviceModel::with(['brand:id,name','creator:id,name', 'updater:id,name'])->paginate(10);
    }
    #[Computed]
    public function brands()
    {
        return Brand::select('id', 'name')->orderBy('name', 'asc')->get();
    }


    public function render()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $canManage = $user ? $user->hasAnyRole(['Superadmin', 'Manage']) : false;
        return view('livewire.superadmin.device.device-model', [
            'canManage' => $canManage
        ]);
    }

    public function create(){
        $this->reset(['name', 'brand_id', 'isEditing']);
        $this->deviceModelModal = true;
    }

    public function edit(DeviceModel $deviceModel){
        $this->deviceModel = $deviceModel;
        $this->name = $deviceModel->name;
        $this->brand_id = $deviceModel->brand_id;
        $this->isEditing = true;
        $this->deviceModelModal = true;
    }

    public function save()
    {
        // Validamos: si editamos, ignoramos el nombre del modelo actual en el unique
        $this->validate([
            'name' => 'required|min:3|max:50|unique:device_models,name,' . ($this->isEditing ? $this->deviceModel->id : 'NULL'),
            'brand_id' => 'required|exists:brands,id',
        ]);
        $data = [
            'name' => $this->name,
            'brand_id' => $this->brand_id,
            'updated_by' => Auth::user()->id,
        ];

        if ($this->isEditing) {
            $this->deviceModel->update($data);
            $this->notification()->success( 'Modelo actualizado.', 'Modelo actualizado con éxito');
        } else {
            $data['created_by'] = Auth::user()->id;
            DeviceModel::create($data);
            $this->notification()->success('Modelo creado.', 'Nuevo modelo registrado');
        }

        $this->deviceModelModal = false;
        $this->reset(['name', 'brand_id', 'isEditing']); // Limpiar después de guardar
    }

        public function delete($deviceModelId)
    {
        try {
            $deviceModel = DeviceModel::findOrFail($deviceModelId);
            // $this->authorize('delete', $deviceModel);

            $deviceModel->delete();

            // Notificación estilo WireUI (versión 2.x)
            $this->notification()->success( 'Notificacion', 'Modelo eliminado con éxito');

        } catch (\Exception $e) {
            $this->notification()->send([
                'icon'        => 'error',
                'title'       => 'Notificacion de Error',
                'description' => 'No se pudo eliminar: ' . $e->getMessage(),
            ]);
        }
    }
}
