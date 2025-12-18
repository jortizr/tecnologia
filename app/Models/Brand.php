<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Brand extends Model
{
    /** @use HasFactory<\Database\Factories\BrandFactory> */
    use HasFactory;
    protected $fillable = [
        'name', 'created_by', 'updated_by'
    ];

    protected static function booted()
    {
        static::updating(function ($brand) {
            if (Auth::check()) {
                $brand->updated_by = Auth::id();
            }
        });

        static::creating(function ($brand) {
            if (Auth::check()) {
                $brand->created_by = Auth::id();
                $brand->updated_by = Auth::id();
            }
        });
    }
    public function device_model(){
        return $this->hasMany(DeviceModel::class);
    }
    public function creator(){
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updater(){
        return $this->belongsTo(User::class, 'updated_by');
    }
}
