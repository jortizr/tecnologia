<?php

namespace App\Livewire\Brands;

use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use App\Models\Brand;
use Livewire\WithPagination;
use WireUi\Traits\WireUiActions;
use Livewire\Attributes\Computed;
use App\Traits\WithSearch;

class BrandIndex extends Component
{
    use WithPagination,  WithSearch, AuthorizesRequests, WireUiActions;
    public bool $brandModal = false;
    public ?Brand $brand = null;//instancia de la marca a editar
    public $name;
    public $isEditing = false;
    public bool $canManage = false;

    protected $rules =[
        'name'=> 'required|min:3|max:50|unique:brands,name',
    ];

    #[Computed]
    public function brands()
    {
        // La consulta se queda aquí para ser eficiente
        return Brand::with(['creator:id,name', 'updater:id,name'])
            ->when($this->search, function($query){
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);
    }


    public function render()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $this->canManage = $user?->hasAnyRole(['Superadmin', 'Manage']) ?? false;

        return view('livewire.brands.brand-index', [
            'canManage' => $this->canManage,
        ]);
    }

    public function create(){
        $this->brandModal = true;
        $this->reset(['name', 'isEditing', 'brand']);
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
            // Validamos según si es edición o creación
        $this->validate($this->isEditing ? [
            'name' => 'required|min:3|max:50|unique:brands,name,' . $this->brand->id
        ] : $this->rules);

        if ($this->isEditing) {
            $this->brand->update([
                'name'       => $this->name,
                'updater_id' => Auth::user()->id
            ]);
            $this->notification()->success('Marca actualizada', 'Los cambios se guardaron con éxito');
        } else {
            // LÓGICA PARA CREAR QUE FALTABA:
            Brand::create([
                'name'       => $this->name,
                'creator_id' => Auth::user()->id,
                'updater_id' => Auth::user()->id,
            ]);
            $this->notification()->success('Marca creada', 'Nueva marca registrada con éxito');
        }

        $this->brandModal = false;
        $this->reset(['name', 'isEditing', 'brand']); // Limpiar después de guardar
    }

    public function delete($brandId)
    {
        try {
            $brand = Brand::findOrFail($brandId);
            // Si usas Policies de Spatie/Laravel
            $this->authorize('delete', $brand);
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
