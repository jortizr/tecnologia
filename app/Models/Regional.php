<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasAuditColumns;

class Regional extends Model
{
    /** @use HasFactory<\Database\Factories\RegionalFactory> */
    use HasFactory, HasAuditColumns;

    public function collaborator(){
        return $this->hasMany(Collaborator::class);
    }
}
