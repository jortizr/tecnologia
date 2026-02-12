<?php

namespace App\Livewire\Regionals;

use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Traits\WithSearch;
use WireUi\Traits\WireUiActions;
use App\Models\Regional;

class RegionalIndex extends Component
{
    use AuthorizesRequests, WithSearch, WireUiActions;

    public function mount(){
        $this->authorize('viewAny', Regional::class);
    }

    public function render()
    {
        return view('livewire.regionals.regional-index');
    }
}
