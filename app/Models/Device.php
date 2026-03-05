<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasAuditColumns;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Device extends Model
{
    /** @use HasFactory<\Database\Factories\DeviceFactory> */
    use HasFactory, HasAuditColumns;
    protected $fillable = [
        'device_model_id',
        'brand_id',
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

    public function deviceModel():BelongsTo{
        return $this->belongsTo(DeviceModel::class, 'device_model_id');
    }

    public function location():BelongsTo{
        return $this->belongsTo(Location::class);
    }

    public function operationalState():BelongsTo{
        return $this->belongsTo(OperationalState::class);
    }

    public function physicalState():BelongsTo {
        return $this->belongsTo(PhysicalState::class);
    }

    public function creator():BelongsTo{
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updater():BelongsTo{
        return $this->belongsTo(User::class, 'updated_by');
    }

}
