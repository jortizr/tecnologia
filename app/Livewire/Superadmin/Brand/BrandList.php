<?php

namespace App\Livewire\Superadmin\Brand;

use Livewire\Component;
use Laravel\Jetstream\InteractsWithBanner;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Brand;

class BrandList extends Component
{
    use InteractsWithBanner, AuthorizesRequests;
    public $brans;

    public function mount(){
        $this->authorize('viewAny', Brand::class);
    }
    public function render()
    {
        return view('livewire.superadmin.brand.brand-list', [
            'brands' => Brand::all()->paginate(10),
        ]);
    }
}
