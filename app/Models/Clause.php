<?php

namespace App\Models;

use App\Traits\HasAuditColumns;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;


class Clause extends Model
{
    use HasAuditColumns;
    protected $fillable = [
        'device_id',
        'people_id',
        'assignment_date',
        'return_date',
        'is_active',
        'cost_center_id',
        'observation',
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
