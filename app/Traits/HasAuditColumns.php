<?php
namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait HasAuditColumns {
    protected static function bootHasAuditColumns(){
        //para el metodo create
        static::creating(function ($model){
            if(Auth::check()){
                if(!$model->isDirty('created_by')){
                    $model->created_by = Auth::id();
                }
                if(!$model->isDirty('updated_by')){
                    $model->created_by = Auth::id();
                }
            }
        });

        //para el metodo update
        static::updating(function ($model){
            if(Auth::check()){
                if(!$model->isDirty('updated_by')){
                    $model->updated_by = Auth::id();
                }
            }
        });
    }
}
