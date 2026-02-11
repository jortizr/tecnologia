<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Role;

class RolePolicy
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

    public function viewAny(User $user): bool
    {
        return $user->can('dashboard.roles.show');
    }

    public function create(User $user): bool
    {
        return $user->can('dashboard.roles.create');
    }

    public function update(User $user, Role $role): bool
    {
        // Evitar que se edite el rol Superadmin si no es otro Superadmin
        if ($role->name === 'Superadmin') {
            return false;
        }
        return $user->can('dashboard.roles.update');
    }

    public function delete(User $user, Role $role): bool
    {
        // No se puede eliminar el rol Superadmin bajo ninguna circunstancia
        if ($role->name === 'Superadmin') {
            return false;
        }
        return $user->can('dashboard.roles.delete');
    }
}
