<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\CollaboratorObserver;

#[ObservedBy([CollaboratorObserver::class])]
class Collaborator extends Model
{
    /** @use HasFactory<\Database\Factories\CollaboratorFactory> */
    use HasFactory;

    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function regional(){
        return $this->belongsTo(Regional::class);
    }

    public function occupation(){
        return $this->belongsTo(Occupation::class);
    }
}
