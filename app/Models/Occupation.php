<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasAuditColumns;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Occupation extends Model
{
    /** @use HasFactory<\Database\Factories\OccupationFactory> */
    use HasFactory, HasAuditColumns;

    protected $fillable = [
        'name', 'created_by', 'updated_by'
    ];

    protected function name(): Attribute{
        return Attribute::make(
            set: fn (string $value) => strtoupper(trim($value)),
        );
    }

    public function collaborators(){
        return $this->hasMany(Collaborator::class);
    }

    public function creator(){
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updater(){
        return $this->belongsTo(User::class, 'updated_by');
    }
}
