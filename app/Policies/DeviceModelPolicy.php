<?php

namespace App\Policies;

use App\Models\DeviceModel;
use App\Models\User;

class DeviceModelPolicy
{
    /**
     * Create a new policy instance.
     */
    public function before(User $user, $ability)
    {
        if($user->hasRole('Superadmin')){
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool{
        return $user->can('dashboard.devicemodels.show');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, DeviceModel $deviceModel){
        return $user->can('dashboard.devicemodels.show');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool {
        return $user->can('dashboard.devicemodels.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DeviceModel $deviceModel): bool{
        return $user->can('dashboard.devicemodels.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DeviceModel $deviceModel): bool {
        return $user->can('dashboard.devicemodels.delete');
    }

}
