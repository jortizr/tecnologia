<?php

namespace App\Livewire\Devices;

use App\Models\Device;
use App\Models\Brand;
use App\Models\DeviceType;
use App\Models\DeviceModel;
use App\Models\Location;
use App\Models\OperationalState;
use App\Models\PhysicalState;
use App\Traits\WithSearch;
use Livewire\Attributes\{Locked, Computed};
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\WireUiActions;

class DeviceIndex extends Component
{
    use WithPagination, WithSearch, AuthorizesRequests, WireUiActions;
    public bool $deviceModal = false;
    public bool $isEditing = false;
    public ?Device $device;
    public $serial_number, $imei, $acquisitionDate, $deviceTypeId, $deviceModelId, $locationId, $operationalStateId, $physicalStateId, $brandId;

    #[Locked]
    public $deviceId;

    public function mount(){
        $this->authorize('viewAny', Device::class);
    }


    #[Computed]
    public function devices(){
        return Device::query()
            ->with(['deviceModel.brand','deviceModel.deviceType', 'location:id,name', 'operationalState:id,name', 'physicalState:id,name'])
            ->when($this->search, function($query){
                $query->where('serial_number', 'like', "%{$this->search}%")
                    ->orWhere('imei', 'like', "%{$this->search}%");
            })->latest()->paginate(10);
    }

    #[Computed]
    public function deviceTypes(){
        return DeviceType::select('id', 'name')->orderBy('name', 'asc')->get();
    }

    #[Computed]
    public function brands(){
       if(!$this->deviceTypeId) return [];
       return Brand::whereHas('deviceModels', function($q){
            $q->where('device_type_id', $this->deviceTypeId);
       })->select('id', 'name')->get();
    }

    #[Computed]
    public function filterModels(){
        if(!$this->brandId || !$this->deviceTypeId) return [];

        return DeviceModel::where('brand_id', $this->brandId)
            ->where('device_type_id', $this->deviceTypeId)
            ->select('id', 'name')
            ->get();
    }

    #[Computed]
    public function locations(){
        return Location::select('id', 'name')->orderBy('name')->get();
    }

    #[Computed]
    public function operationalStates(){
        return OperationalState::select('id', 'name')->orderBy('name')->get();
    }

    #[Computed]
    public function physicalStates(){
        return PhysicalState::select('id','name')->orderBy('name')->get();
    }

    public function updatedDeviceTypeId()
    {
        $this->brandId = null;
        $this->deviceModelId = null;
    }

    public function updatedBrandId()
    {
        $this->deviceModelId = null;
    }

    public function create(){
        $this->reset('serial_number', 'imei', 'acquisitionDate', 'isEditing', 'deviceTypeId', 'brandId','deviceModelId', 'locationId', 'operationalStateId', 'physicalStateId');
        $this->deviceModal = true;
    }

    public function render()
    {
        return view('livewire.devices.device-index');
    }
}
