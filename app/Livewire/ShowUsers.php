<?php

namespace App\Livewire;

use App\Models\Role;
use Livewire\Component;
use App\Models\User;

class ShowUsers extends Component
{
    public function render()
    {
        return view('livewire.show-users');
    }
}
