<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        //creamos los roles necesarios
       $superadmin = Role::create(['name'=> 'Superadmin']);
       $manager = Role::create(['name'=> 'Manager']);
       $viewer = Role::create(['name'=> 'Viewer']);

       $dashboardPermission = Permission::firstOrCreate(['name' => 'dashboard']);
       $dashboardPermission->syncRoles([$superadmin]);

    $modules = [
        'users'              => ['admins' => [$superadmin], 'viewers' => []],
        'roles'              => ['admins' => [$superadmin], 'viewers' => []],
        'clausule'           => ['admins' => [$superadmin], 'viewers' => [$manager, $viewer]],
        'devices'            => ['admins' => [$superadmin], 'viewers' => [$manager, $viewer]],
        'accesories'         => ['admins' => [$superadmin], 'viewers' => [$manager, $viewer]],
        'simcards'           => ['admins' => [$superadmin], 'viewers' => []],
        'loans'              => ['admins' => [$superadmin, $manager], 'viewers' => [$viewer]],
        'support'            => ['admins' => [$superadmin], 'viewers' => [$manager, $viewer]],
        'reports'            => ['admins' => [$superadmin, $manager], 'viewers' => [$viewer]],
        'failures'           => ['admins' => [$superadmin, $manager], 'viewers' => [$viewer]],
        'collaborators'      => ['admins' => [$superadmin, $manager], 'viewers' => [$viewer]],
        'collaborators.import'=> ['admins' => [$superadmin, $manager], 'viewers' => []],
        'occupations'        => ['admins' => [$superadmin], 'viewers' => [$manager]],
        'assignments'        => ['admins' => [$superadmin], 'viewers' => [$manager]],
        'physicalstates'    => ['admins' => [$superadmin], 'viewers' => [$manager, $viewer]],
        'operationalstates' => ['admins' => [$superadmin], 'viewers' => [$manager, $viewer]],
        'accesoriesstates'  => ['admins' => [$superadmin], 'viewers' => [$manager, $viewer]],
        'failuretypes'      => ['admins' => [$superadmin], 'viewers' => [$manager, $viewer]],
        'brands'             => ['admins' => [$superadmin], 'viewers' => [$manager, $viewer]],
        'departments'        => ['admins' => [$superadmin], 'viewers' => []],
        'regionals'        => ['admins' => [$superadmin], 'viewers' => []],
    ];

       $actions = ['show', 'create', 'update', 'delete'];

       foreach($modules as $module =>$roles){
            $adminRoles = $roles['admins'];
            $viewRoles  = $roles['viewers'];

            foreach ($actions as $action) {
            $permissionName = "dashboard.{$module}.{$action}";
            $permission = Permission::firstOrCreate(
                ['name' => $permissionName,
                'guard_name' => 'web'
                ]);

            if ($action === 'show') {
                $permission->syncRoles(array_unique(array_merge($adminRoles, $viewRoles)));
            } else {
               $permission->syncRoles($adminRoles);
            }
        }
       }
    }
}
