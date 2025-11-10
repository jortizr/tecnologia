<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Observers\CollaboratorObserver;

#[ObservedBy([CollaboratorObserver::class])]
class Collaborator extends Model
{
    /** @use HasFactory<\Database\Factories\CollaboratorFactory> */
    use HasFactory;

       protected $fillable = [
        'names',
        'last_name',
        'identification',
        'payroll_code',
        'department_id',
        'regional_id',
        'occupation_id',
        'is_active',

    ];

    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function regional(){
        return $this->belongsTo(Regional::class);
    }

    public function occupation(){
        return $this->belongsTo(Occupation::class);
    }

    public function creator(){
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updater(){
        return $this->belongsTo(User::class, 'updated_by');
    }
}
