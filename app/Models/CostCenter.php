<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasAuditColumns;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class CostCenter extends Model
{
    use HasAuditColumns;

    protected $fillable = [
        'codigo',
        'department_id',
        'created_by',
        'updated_by'
    ];

    public function department():BelongsTo{
        return $this->belongsTo(Department::class);
    }

    public function creator():BelongsTo{
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updater():BelongsTo{
        return $this->belongsTo(User::class, 'updated_by');
    }
}
