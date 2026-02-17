<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    //el trait HasFactory para habilitar el uso de Role::factory()
    use HasFactory;
    protected $fillable = [
        'name',
    ];


    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }
}
