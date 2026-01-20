<?php

namespace App\Livewire\Collaborators;

use App\Models\Collaborator;
use Laravel\Jetstream\InteractsWithBanner;
use Livewire\Attributes\On;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use App\Models\User;

class CollaboratorIndex extends Component
{
    use InteractsWithBanner, AuthorizesRequests;

    public function mount(){
        $this->authorize('viewAny', Collaborator::class);
    }

    #[On('toggleStatus')]
    public function toggleStatus($collaboratorId)
    {
        $collaborator = Collaborator::findOrFail($collaboratorId);
        // $this->authorize('update', $collaborator); // Optional: Add authorization if needed

        try{
            $collaborator->is_active = !$collaborator->is_active;
            $collaborator->save();

            $this->banner($collaborator->is_active ? 'Colaborador activado correctamente.' : 'Colaborador desactivado correctamente.');
        }
        catch(\Exception $e){
            $this->dangerBanner('Error al cambiar el estado del colaborador. ' . $e->getMessage());
        }

    }

    #[On(['collaboratorCreated', 'collaborator-updated'])]
    public function render()
    {
        return view('livewire.collaborators.collaborator-index', [
            'collaborators'=> Collaborator::with(['regional', 'department', 'occupation'])->paginate(10),
        ]);
    }

    public function delete($collaboratorId)
    {
        $collaborator = Collaborator::findOrFail($collaboratorId);
        $this->authorize('delete', $collaborator);

        try {
            $collaborator->delete();
            $this->banner('Colaborador eliminado correctamente.');
        } catch (\Exception $e) {
            $this->dangerBanner('Error al eliminar el colaborador. ' . $e->getMessage());
        }
    }
}
