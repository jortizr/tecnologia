<?php
namespace App\Livewire\Brands;

use App\Models\Brand;
use App\Traits\WithSearch;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\{Locked, Computed};
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\WireUiActions;

class BrandIndex extends Component
{
    use WithPagination, WithSearch, AuthorizesRequests, WireUiActions;
    public bool $brandModal = false;
    public ?Brand $brand    = null; //instancia de la marca a editar
    public $name;
    public $isEditing      = false;

    #[Locked]
    public $brandId;

    public function mount(){
         $this->authorize('viewAny', Brand::class);
    }


    #[Computed]
    public function brands()
    {
        // La consulta se queda aquí para ser eficiente
        return Brand::with(['creator:id,name', 'updater:id,name'])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })->latest()
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.brands.brand-index');
    }

    public function create()
    {
        $this->reset(['name', 'isEditing', 'brand']);
        $this->brandModal = true;
    }

    //abrir el modal para editar
    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        $this->brandId = $id;
        $this->name = $brand->name;
        $this->isEditing  = true;
        $this->brandModal = true;
    }

    public function save()
    {
        $this->isEditing
        ? $this->authorize('update', $this->brand)
        : $this->authorize('create', Brand::class);


        $this->validate([
            'name' => 'required|min:3|max:50|unique:brands,name,' . ($this->isEditing ? $this->brandId : 'NULL'),
        ]);

        if ($this->isEditing) {
           $brand = Brand::findOrFail($this->brandId);

           $this->authorize('update', $brand);

           $brand->update(['name' => $this->name]);

            $this->notification()->success('Actualizado', 'Los cambios se guardaron con éxito');
        } else {
            $this->authorize('create', Brand::class);
            Brand::create([
                'name'       => $this->name,
            ]);
            $this->notification()->success('Marca creada', 'Nueva marca registrada con éxito');
        }

        $this->brandModal = false;
        unset($this->departments);
        $this->dispatch('model-updated');
    }

    public function confirmDelete($brandId)
    {
        $this->dialog()->confirm([
            'title'       => '¿Eliminar colaborador?',
            'description' => 'Esta acción no se puede deshacer.',
            'icon'        => 'error',
            'accept'      => [
                'label'  => 'Eliminar',
                'method' => 'delete', // Llama a tu función delete existente
                'params' => $brandId,
            ],
            'reject'      => [
                'label' => 'Cancelar',
            ],
        ]);
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
