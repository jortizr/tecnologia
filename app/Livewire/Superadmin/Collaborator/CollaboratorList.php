<?php

namespace App\Livewire\Superadmin\Collaborator;

use App\Models\Collaborator;
use Laravel\Jetstream\InteractsWithBanner;
use Livewire\Attributes\On;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class CollaboratorList extends Component
{
    use InteractsWithBanner, AuthorizesRequests;

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
        return view('livewire.superadmin.collaborator.collaborator-list', [
            'collaborators'=> Collaborator::with(['regional', 'department', 'occupation'])->paginate(10),
        ]);
    }
}
