<?php

namespace App\Livewire\Superadmin\Brand;

use Livewire\Component;
use App\Models\Brand;
use Laravel\Jetstream\InteractsWithBanner;
use Illuminate\Support\Facades\Auth;

class BrandEdit extends Component
{
use InteractsWithBanner;
    public Brand $brand;
    public $name;

    public function mount(Brand $brand){
        $this->name = $brand->name;
    }


    public function update(){
        $this->authorize('update', $this->brand);
        $validateData = $this->validate(
            [
                'name'=> 'required',
            ]
        );

        $this->brand->update($validateData);
        $this->banner('Fabricante actualizada con éxito');
        $this->dispatch('brand-updated');
        return redirect()->route('dashboard.brands.show');
    }

    public function cancel(){
        return redirect()->route('dashboard.brands.show');
    }
    public function render()
    {
        return view('livewire.superadmin.brand.brand-edit');
    }
}
