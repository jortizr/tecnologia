<?php

namespace App\Livewire\Superadmin\Brand;

use Livewire\Component;
use Laravel\Jetstream\InteractsWithBanner;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Auth;
use App\Models\Brand;
use Livewire\WithPagination;

class BrandList extends Component
{
    use InteractsWithBanner, AuthorizesRequests, WithPagination;

    public function mount(){

    }
    public function render()
    {
        $brands = Brand::with(['creator:id,name', 'updater:id,name'])->paginate(10);

        $canManage = Auth::user()->hasAnyRole(['Superadmin', 'Manage']);
        return view('livewire.superadmin.brand.brand-list', [
            'brands' => $brands,
            'canManage' => $canManage,
        ]);
    }
}
