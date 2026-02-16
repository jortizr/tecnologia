<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Occupation;

class OccupationPolicy
{
    /**
     * Create a new policy instance.
     */
    public function before(User $user, $ability){
        if($user->hasRole('Superadmin')){
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user):bool {
        return $user->can('dashboard.occupations.show');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Occupation $occupation): bool {
        return $user->can('dashboard.occupations.show');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool {
        return $user->can('dashboard.occupations.create');
    }

    /**
     * Determine whether the user can update the model.
     */

    public function update(User $user, Occupation $occupation): bool {
        return $user->can('dashboard.occupations.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Occupation $occupation): bool{
        return $user->can('dashboard.occupations.delete');
    }
}
