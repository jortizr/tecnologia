<?php

namespace App\Traits;

trait WithSearch{
    public $search = '';

    public function updatedSearch(){
        if(method_exists($this, 'resetPage')){
        }
    }
}
