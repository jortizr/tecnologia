<?php
namespace App\Livewire\Brands;

use App\Models\Brand;
use App\Traits\WithSearch;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
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
        unset($this->brands);
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
            $brand = Brand::withCount('deviceModels')->findOrFail($brandId);
            // Si usas Policies de Spatie/Laravel
            $this->authorize('delete', $brand);

            if($brand->device_models_count > 0){
                $this->notification()->error('Accion denegada', "No puedes eliminar esta marca porque tiene {$brand->device_models_count} modelos asociados. modelos asociados.");
                return;
            }
            $brand->delete();
            $this->notification()->success('Éxito', 'Fabricante eliminado correctamente');
            unset($this->brands);

        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            $this->notification()->error('Acceso denegado', 'No tienes permisos para realizar esta acción.');
        } catch (\Exception $e) {
            $this->notification()->error('Error', 'Ocurrió un error inesperado.');
        }
    }

    public function render()
    {
        return view('livewire.brands.brand-index');
    }
}
