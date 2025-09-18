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
        //creamos los roles necesarios
       $superadminRole = Role::create(['name'=> 'Superadmin']);
       $managerRole = Role::create(['name'=> 'Manager']);
       $viewerRole = Role::create(['name'=> 'Viewer']);

       Permission::create(['name'=> 'dashboard'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.users.show'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.users.create'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.users.delete'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.users.update'])->syncRoles([$superadminRole]);

       Permission::create(['name'=> 'dashboard.clausule.show'])->syncRoles([$superadminRole, $managerRole, $viewerRole]);
       Permission::create(['name'=> 'dashboard.clausule.create'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.clausule.delete'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.clausule.update'])->syncRoles([$superadminRole]);

       Permission::create(['name'=> 'dashboard.devices.show'])->syncRoles([$superadminRole, $managerRole, $viewerRole]);
       Permission::create(['name'=> 'dashboard.devices.create'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.devices.delete'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.devices.update'])->syncRoles([$superadminRole]);

       Permission::create(['name'=> 'dashboard.accesories.show'])->syncRoles([$superadminRole, $managerRole, $viewerRole]);
       Permission::create(['name'=> 'dashboard.accesories.create'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.accesories.delete'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.accesories.update'])->syncRoles([$superadminRole, $managerRole]);

       Permission::create(['name'=> 'dashboard.simcards.show'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.simcards.create'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.simcards.delete'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.simcards.update'])->syncRoles([$superadminRole]);

       Permission::create(['name'=> 'dashboard.loans.show'])->syncRoles([$superadminRole, $managerRole, $viewerRole]);
       Permission::create(['name'=> 'dashboard.loans.create'])->syncRoles([$superadminRole, $managerRole]);
       Permission::create(['name'=> 'dashboard.loans.delete'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.loans.update'])->syncRoles([$superadminRole, $managerRole]);

       Permission::create(['name'=> 'dashboard.support.show'])->syncRoles([$superadminRole, $managerRole, $viewerRole]);
       Permission::create(['name'=> 'dashboard.support.create'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.support.delete'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.support.update'])->syncRoles([$superadminRole]);

       Permission::create(['name'=> 'dashboard.reports.show'])->syncRoles([$superadminRole, $managerRole, $viewerRole]);
       Permission::create(['name'=> 'dashboard.reports.create'])->syncRoles([$superadminRole, $managerRole]);
       Permission::create(['name'=> 'dashboard.reports.delete'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.reports.update'])->syncRoles([$superadminRole, $managerRole]);

       Permission::create(['name'=> 'dashboard.failures.show'])->syncRoles([$superadminRole, $managerRole, $viewerRole]);
       Permission::create(['name'=> 'dashboard.failures.create'])->syncRoles([$superadminRole, $managerRole]);
       Permission::create(['name'=> 'dashboard.failures.delete'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.failures.update'])->syncRoles([$superadminRole, $managerRole]);

       Permission::create(['name'=> 'dashboard.people.show'])->syncRoles([$superadminRole, $managerRole, $viewerRole]);
       Permission::create(['name'=> 'dashboard.people.create'])->syncRoles([$superadminRole, $managerRole]);
       Permission::create(['name'=> 'dashboard.people.delete'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.people.update'])->syncRoles([$superadminRole, $managerRole, $viewerRole]);

       Permission::create(['name'=> 'dashboard.assignments.show'])->syncRoles([$superadminRole, $managerRole]);
       Permission::create(['name'=> 'dashboard.assignments.create'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.assignments.delete'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.assignments.update'])->syncRoles([$superadminRole, $managerRole]);

       Permission::create(['name'=> 'dashboard.physical.states.show'])->syncRoles([$superadminRole, $managerRole, $viewerRole]);
       Permission::create(['name'=> 'dashboard.physical.states.create'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.physical.states.delete'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.physical.states.update'])->syncRoles([$superadminRole, $managerRole]);

       Permission::create(['name'=> 'dashboard.operational.states.show'])->syncRoles([$superadminRole, $managerRole, $viewerRole]);
       Permission::create(['name'=> 'dashboard.operational.states.create'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.operational.states.delete'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.operational.states.update'])->syncRoles([$superadminRole]);

       Permission::create(['name'=> 'dashboard.accesories.states.show'])->syncRoles([$superadminRole, $managerRole, $viewerRole]);
       Permission::create(['name'=> 'dashboard.accesories.states.create'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.accesories.states.delete'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.accesories.states.update'])->syncRoles([$superadminRole]);

       Permission::create(['name'=> 'dashboard.failure.types.show'])->syncRoles([$superadminRole, $managerRole, $viewerRole]);
       Permission::create(['name'=> 'dashboard.failure.types.create'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.failure.types.delete'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.failure.types.update'])->syncRoles([$superadminRole]);




    }

}
