<?php

namespace App\Models;

use App\Traits\HasAuditColumns;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;


class SimCard extends Model
{
    use HasAuditColumns;
    protected $fillable = [
        'phone_number',
        'ICCID',
        'mobile_operator_id',
        'plant_type_id',
        'data_plan_id',
        'sim_card_status_id',
        'device_id',
        'is_backup',
        'created_by',
        'updated_by'
    ];

    public function creator():BelongsTo{
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updater():BelongsTo{
        return $this->belongsTo(User::class, 'updated_by');
    }
}
