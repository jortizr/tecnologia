<?php

namespace App\Livewire\Superadmin\Brand;

use Livewire\Component;
use Laravel\Jetstream\InteractsWithBanner;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Brand;
use Livewire\WithPagination;

class BrandList extends Component
{
    use InteractsWithBanner, AuthorizesRequests, WithPagination;
    public $brands;
    public $canViewBrands;

    public function mount(){
        // $this->authorize('viewAny', Brand::class);

    }
    public function render()
    {
        $this->brands = Brand::with(['creator', 'updater'])->paginate(10);

        return view('livewire.superadmin.brand.brand-list', [
            'brands' => $this->brands,
        ]);
    }
}
