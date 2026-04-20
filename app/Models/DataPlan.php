<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasAuditColumns;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;

class DataPlan extends Model
{
    use HasAuditColumns;

    protected $fillable = [
        'name',
        'created_by',
        'updated_by'
    ];

    protected function name(): Attribute{
        return Attribute::make(
            set: fn (string $value) => strtoupper(trim($value)),
        );
    }

    public function creator():BelongsTo{
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updater():BelongsTo{
        return $this->belongsTo(User::class, 'updated_by');
    }
}
