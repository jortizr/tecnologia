<?php

namespace App\Livewire\Superadmin\Device;

use Livewire\Component;
use Laravel\Jetstream\InteractsWithBanner;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use App\Models\DeviceModel;
use Livewire\WithPagination;
use WireUi\Traits\WireUiActions;


class DeviceModelList extends Component
{
    use WithPagination, InteractsWithBanner, AuthorizesRequests, WireUiActions;
    public bool $deviceModelModal = false;
    public ?DeviceModel $deviceModel = null;
    public $name;
    public $isEditing = false;

    protected $rules =[
        'name'=> 'required|min:3|max:50|unique:device_models,name',
        'brand_id' => 'required'
    ];

    public function render()
    {
        $models = DeviceModel::with(['creator:id,name', 'updater:id,name'])->paginate(10);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $canManage = $user ? $user->hasAnyRole(['Superadmin', 'Manage']) : false;

        return view('livewire.superadmin.device.device-model', [
            'models' => $models,
            'canManage' => $canManage
        ]);
    }

    public function create(){
        $this->reset(['name', 'isEditing', 'deviceModels']);
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
