<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasAuditColumns;
use Illuminate\Database\Eloquent\Casts\Attribute;

class PhysicalState extends Model
{
    /** @use HasFactory<\Database\Factories\PhysicalStateFactory> */
    use HasFactory, HasAuditColumns;

    protected $fillable =[
        'name',
        'description',
        'created_by',
        'updated_by'
    ];

    protected function name(): Attribute{
        return Attribute::make(
            set: fn (string $value) => strtoupper(trim($value)),
        );
    }

    protected function description(): Attribute{
        return Attribute::make(
            set: fn (string $value) => strtoupper(trim($value)),
        );
    }

    public function devices(){
        return $this->hasMany(Device::class);
    }

    public function creator(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(){
        return $this->belongsTo(User::class, 'updated_by');
    }

}
