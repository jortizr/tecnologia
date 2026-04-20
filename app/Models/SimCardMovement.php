<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SimCardMovement extends Model
{



    public function creator():BelongsTo{
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updater():BelongsTo{
        return $this->belongsTo(User::class, 'updated_by');
    }
}
