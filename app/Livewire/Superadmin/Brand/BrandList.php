<?php

namespace App\Livewire\Superadmin\Brand;

use Livewire\Component;
use Laravel\Jetstream\InteractsWithBanner;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BrandList extends Component
{
    use InteractsWithBanner, AuthorizesRequests;
    public function render()
    {
        return view('livewire.superadmin.brand.brand-list');
    }
}
