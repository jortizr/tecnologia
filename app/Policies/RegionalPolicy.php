<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Regional;

class RegionalPolicy
{
    /**
     * El método before permite al Superadmin saltarse las validaciones.
     */
    public function before(User $user, $ability)
    {
        if ($user->hasRole('Superadmin')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user, Regional $regional){
        return $user->can('dashboard.regionals.show');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Regional $regional): bool
    {
        return $user->can('dashboard.departments.show');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('dashboard.departments.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Regional $regional): bool
    {
        return $user->can('dashboard.departments.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Regional $regional): bool
    {
        return $user->can('dashboard.departments.delete');
    }

}
