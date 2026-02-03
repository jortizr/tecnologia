<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Casts\Attribute;
use App\Traits\HasAuditColumns;
class DeviceModel extends Model
{
    /** @use HasFactory<\Database\Factories\DeviceModelFactory> */
    use HasFactory, HasAuditColumns;
    protected $fillable =[
        'name',
        'brand_id',
        'created_by',
        'updated_by',
    ];

    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => strtoupper(trim($value)),
        );
    }

    public function brand(){
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function creator(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(){
        return $this->belongsTo(User::class, 'updated_by');
    }
}
