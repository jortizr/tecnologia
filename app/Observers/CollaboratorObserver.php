<?php

namespace App\Observers;

use App\Models\Collaborator;
use Illuminate\Support\Facades\Auth;

class CollaboratorObserver
{
    /**
     * Handle the Collaborator "created" event.
     */
    public function created(Collaborator $collaborator): void
    {
        $collaborator->created_by = Auth::id();
        $collaborator->updated_by = Auth::id();
    }

    /**
     * Handle the Collaborator "updated" event.
     */
    public function updated(Collaborator $collaborator): void
    {
        $collaborator->updated_by = Auth::id();
    }

    /**
     * Handle the Collaborator "deleted" event.
     */
    public function deleted(Collaborator $collaborator): void
    {
        //
    }

    /**
     * Handle the Collaborator "restored" event.
     */
    public function restored(Collaborator $collaborator): void
    {
        //
    }

    /**
     * Handle the Collaborator "force deleted" event.
     */
    public function forceDeleted(Collaborator $collaborator): void
    {
        //
    }
}
