<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    /** @use HasFactory<\Database\Factories\DeviceFactory> */
    use HasFactory;
    protected $fillable = [
        'device_model_id',
        'device_type_id',
        'serial_number',
        'imei',
        'location_id',
        'operational_state_id',
        'physical_state_id',
        'acquisition_date',
        'created_by',
        'updated_by',
    ];

    public function device_model(){
        return $this->belongsTo(DeviceModel::class);
    }

    public function device_type(){
        return $this->belongsTo(DeviceType::class);
    }

    public function location(){
        return $this->belongsTo(Location::class);
    }

    public function operational_state(){
        return $this->belongsTo(OperationalState::class);
    }

    public function physical_state(){
        return $this->belongsTo(PhysicalState::class);
    }

    public function creator(){
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updater(){
        return $this->belongsTo(User::class, 'updated_by');
    }

}
