<?php

namespace App\Policies;

use App\Models\Device;
use App\Models\User;

class DevicePolicy
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
        return $user->can('dashboard.devices.show');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Device $device): bool
    {
        return $user->can('dashboard.devices.show');
    }

   /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('dashboard.devices.create');
    }

   /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Device $device): bool
    {
        return $user->can('dashboard.devices.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Device $device): bool
    {
        return $user->can('dashboard.devices.delete');
    }

}
