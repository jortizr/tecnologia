<?php

namespace App\Livewire\Superadmin\Device;

use Livewire\Component;
use Laravel\Jetstream\InteractsWithBanner;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use App\Models\DeviceModel;
use Livewire\WithPagination;
use WireUi\Traits\WireUiActions;
use Livewire\Attributes\Computed;


class DeviceModelList extends Component
{
    use WithPagination, AuthorizesRequests, WireUiActions;
    public bool $deviceModelModal = false;
    public ?DeviceModel $deviceModel = null;
    public $name;
    public $isEditing = false;
    public $brand_id = [];

    protected $rules =[
        'name'=> 'required|min:3|max:50|unique:device_models,name',
        'brand_id' => 'required'
    ];
    #[Computed]
    public function deviceModels()
    {
        // La consulta se queda aquí para ser eficiente
        return DeviceModel::with(['brand_id','creator:id,name', 'updater:id,name'])->paginate(10);
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
        $this->reset(['name', 'brand_id', 'isEditing', 'deviceModels']);
        $this->deviceModelModal = true;
    }

    public function edit(DeviceModel $deviceModel){
        $this->deviceModel = $deviceModel;
        $this->name = $deviceModel->name;
        $this->isEditing = true;
        $this->deviceModelModal = true;
    }

    public function save()
    {
            // Validamos según si es edición o creación
        $this->validate($this->isEditing ? [
            'name' => 'required|min:3|max:50|unique:device_modals,name,'
        ] : $this->rules);

        if ($this->isEditing) {
            $this->deviceModel->update([
                'name'       => $this->name,
                'brand_id'  => $this->brand_id,
                'updater_id' => Auth::user()->id
            ]);
            $this->notification()->success('Marca actualizada', 'Los cambios se guardaron con éxito');
        } else {
            // LÓGICA PARA CREAR QUE FALTABA:
            Brand::create([
                'name'       => $this->name,
                'creator_id' => Auth::user()->id,
                'updater_id' => Auth::user()->id,
            ]);
            $this->notification()->success('Marca creada', 'Nueva marca registrada con éxito');
        }

        $this->brandModal = false;
        $this->reset(['name', 'isEditing', 'brand']); // Limpiar después de guardar
    }

        public function delete($deviceModelId)
    {
        try {
            $deviceModel = DeviceModel::findOrFail($deviceModelId);

            // Si usas Policies de Spatie/Laravel
            // $this->authorize('delete', $brand);

            $deviceModel->delete();

            // Notificación estilo WireUI (versión 2.x)
            $this->notification()->send([
                'icon'        => 'success',
                'title'       => 'Modelo eliminado',
                'description' => 'El registro se borró correctamente.',
            ]);

        } catch (\Exception $e) {
            $this->notification()->send([
                'icon'        => 'error',
                'title'       => 'Error',
                'description' => 'No se pudo eliminar: ' . $e->getMessage(),
            ]);
        }
    }
}
