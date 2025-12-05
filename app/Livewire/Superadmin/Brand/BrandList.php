<?php

namespace App\Livewire\Superadmin\Brand;

use Livewire\Component;
use Laravel\Jetstream\InteractsWithBanner;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use App\Models\Brand;
use Livewire\WithPagination;
use Spatie\Permission\Traits\HasRoles;

class BrandList extends Component
{
    use WithPagination;


    public function render()
    {
        $brands = Brand::with(['creator:id,name', 'updater:id,name'])->paginate(10);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Verificación de nulidad por si no hay usuario logueado (buena práctica)
        $canManage = $user ? $user->hasAnyRole(['Superadmin', 'Manage']) : false;
        return view('livewire.superadmin.brand.brand-list', [
            'brands' => $brands,
            'canManage' => $canManage,
        ]);
    }

    public function delete($brandId)
    {
        $brand= Brand::findOrFail($brandId);
        $this->authorize('delete', $brand);

        try {
            $brand->delete();
            $this->banner('Fabricante eliminado correctamente.');
        } catch (\Exception $e) {
            $this->dangerBanner('Error al eliminar el fabricante. ' . $e->getMessage());
        }
    }
}
