<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationalState extends Model
{
    /** @use HasFactory<\Database\Factories\OperationalStateFactory> */
    use HasFactory;
    protected $fillable =[
        'name',
        'description',
    ];

    public function device(){
        return $this->hasMany(Device::class);
    }

    public function create(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(){
        return $this->belongsTo(User::class, 'updated_by');
    }
}
