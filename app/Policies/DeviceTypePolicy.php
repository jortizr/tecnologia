<?php

namespace App\Policies;

use App\Models\DeviceType;
use App\Models\User;

class DeviceTypePolicy
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
        return $user->can('dashboard.devicetypes.show');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, DeviceType $deviceType): bool
    {
        return $user->can('dashboard.devicetypes.show');
    }

   /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('dashboard.devicetypes.create');
    }

   /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DeviceType $deviceType): bool
    {
        return $user->can('dashboard.devicetypes.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DeviceType $deviceType): bool
    {
        return $user->can('dashboard.devicetypes.delete');
    }

}
