<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceModel extends Model
{
    /** @use HasFactory<\Database\Factories\DeviceModelFactory> */
    use HasFactory;
    protected $fillable =[
        'name',
        'brand_id',
    ];

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function create(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(){
        return $this->belongsTo(User::class, 'updated_by');
    }
}
