<?php

namespace App\Policies;

use App\Models\OperationalState;
use App\Models\User;

class OperationalStatePolicy
{
    /**
     * El método before permite al Superadmin saltarse las validaciones.
     */
    public function before(User $user, $ability){
        if($user->hasRole('Superadmin')){
            return true;
        }
    }

        /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool {
        return $user->can('dashboard.operationalstates.show');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, OperationalState $operationalState): bool
    {
        return $user->can('dashboard.operationalstates.show');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('dashboard.operationalstates.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, OperationalState $operationalState): bool
    {
        return $user->can('dashboard.operationalstates.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, OperationalState $operationalState): bool
    {
        return $user->can('dashboard.operationalstates.delete');
    }

}
