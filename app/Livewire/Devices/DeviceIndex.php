<?php

namespace App\Livewire\Devices;

use App\Models\Device;
use App\Models\DeviceModel;
use App\Models\DeviceType;
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
    public $serial_number, $imei, $acquisition_date, $deviceTypeId, $deviceModelId, $locationId, $operationalStateId, $physicalStateId;

    #[Locked]
    public $deviceId;

    public function mount(){
        $this->authorize('viewAny', Device::class);
    }


    #[Computed]
    public function devices(){
        return Device::query()->with(['deviceModel:id,name', 'deviceType:id,name', 'location:id,name', 'operationalState:id,name', 'physicalState:id,name','creator:id,name', 'updater:id,name'])
        ->when($this->search, function($query){
            $query->wheere('serial', 'like', "%{$this->search}%");
        })
        ->latest()->paginate(10);
    }

    #[Computed]
    public function deviceTypes(){
        return DeviceType::select('id', 'name')->orderBy('name', 'asc')->get();
    }

    #[Computed]
    public function deviceModels(){
        return DeviceModel::select('id', 'name')->orderBy('name', 'asc')->get();
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

    public function create(){
        $this->reset('serial_number', 'imei', 'acquisition_date', 'isEditing');
    }

    public function render()
    {
        return view('livewire.devices.device-index');
    }
}
