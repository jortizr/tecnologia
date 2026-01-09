<?php

namespace App\Livewire\Superadmin\Brand;

use Livewire\Component;
use Laravel\Jetstream\InteractsWithBanner;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use App\Models\Brand;
use Livewire\WithPagination;
use WireUi\Traits\WireUiActions;

class BrandList extends Component
{
    use WithPagination, InteractsWithBanner, AuthorizesRequests, WireUiActions;
    public bool $brandModal = false;
    public ?Brand $brand = null;//instancia de la marca a editar
    public $name;
    public $isEditing = false;

    protected $rules =[
        'name'=> 'required|min:3|max:50|unique:brands,name',
    ];

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

    //abrir el modal para crear
    public function create(){
        $this->reset(['name', 'isEditing', 'brand']);
        $this->brandModal = true;
    }

    //abrir el modal para editar
    public function edit(Brand $brand){
        $this->brand = $brand;
        $this->name = $brand->name;
        $this->isEditing = true;
        $this->brandModal = true;
    }

    public function save()
    {
        $this->validate($this->isEditing ? [
            'name' => 'required|min:3|max:50|unique:brands,name' .
            $this->brand->id
        ] : $this->rules);

        if($this->isEditing){
            $this->brand->update(['name' => $this->name,
                'updater_id' => Auth::user()->id
            ]);
            $this->notification()->success('Marca creada', 'Nueva marca registrada con éxito');
        }

        $this->brandModal = false;
    }

    public function delete($brandId)
    {
        try {
            $brand = Brand::findOrFail($brandId);

            // Si usas Policies de Spatie/Laravel
            // $this->authorize('delete', $brand);

            $brand->delete();

            // Notificación estilo WireUI (versión 2.x)
            $this->notification()->send([
                'icon'        => 'success',
                'title'       => 'Fabricante eliminado',
                'description' => 'El registro se borró correctamente.',
            ]);

        } catch (\Exception $e) {
            $this->notification()->send([
                'icon'        => 'error',
                'title'       => 'Error',
                'description' => 'No se pudo eliminar: ' . $e->getMessage(),
            ]);
        }
    }
}
