<?php

namespace App\Livewire\Superadmin\Collaborator;

use App\Models\Collaborator;
use Livewire\Component;

class CollaboratorList extends Component
{
    public function render()
    {
        return view('livewire.superadmin.collaborator.collaborator-list', [
            'collaborators'=> Collaborator::with(['regional', 'department', 'occupation'])->paginate(10),
        ]);
    }
}
