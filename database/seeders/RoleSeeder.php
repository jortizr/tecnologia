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
       Permission::create(['name'=> 'dashboard.users.edit'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.users.delete'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.users.update'])->syncRoles([$superadminRole]);

       Permission::create(['name'=> 'dashboard.clausule.show'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.clausule.create'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.clausule.edit'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.clausule.delete'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.clausule.update'])->syncRoles([$superadminRole]);

       Permission::create(['name'=> 'dashboard.devices.show'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.devices.create'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.devices.edit'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.devices.delete'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.devices.update'])->syncRoles([$superadminRole]);

       Permission::create(['name'=> 'dashboard.accesories.show'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.accesories.create'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.accesories.edit'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.accesories.delete'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.accesories.update'])->syncRoles([$superadminRole]);

       Permission::create(['name'=> 'dashboard.assignments.show'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.assignments.create'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.assignments.edit'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.assignments.delete'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.assignments.update'])->syncRoles([$superadminRole]);

       Permission::create(['name'=> 'dashboard.simcards.show'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.simcards.create'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.simcards.edit'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.simcards.delete'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.simcards.update'])->syncRoles([$superadminRole]);

       Permission::create(['name'=> 'dashboard.loans.show'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.loans.create'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.loans.edit'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.loans.delete'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.loans.update'])->syncRoles([$superadminRole]);

       Permission::create(['name'=> 'dashboard.support.show'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.support.create'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.support.edit'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.support.delete'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.support.update'])->syncRoles([$superadminRole]);

       Permission::create(['name'=> 'dashboard.reports.show'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.reports.create'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.reports.edit'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.reports.delete'])->syncRoles([$superadminRole]);
       Permission::create(['name'=> 'dashboard.reports.update'])->syncRoles([$superadminRole]);

       Permission::create(['name'=> 'manager.reports.show'])->syncRoles([$managerRole]);
       Permission::create(['name'=> 'manager.reports.create'])->syncRoles([$managerRole]);
       Permission::create(['name'=> 'manager.reports.edit'])->syncRoles([$managerRole]);
       Permission::create(['name'=> 'manager.reports.update'])->syncRoles([$managerRole]);

       Permission::create(['name'=> 'manager.loans.show'])->syncRoles([$managerRole]);
       Permission::create(['name'=> 'manager.loans.create'])->syncRoles([$managerRole]);
       Permission::create(['name'=> 'manager.loans.edit'])->syncRoles([$managerRole]);
       Permission::create(['name'=> 'manager.loans.update'])->syncRoles([$managerRole]);

       Permission::create(['name'=> 'manager.support.show'])->syncRoles([$managerRole]);

       Permission::create(['name'=> 'manager.devices.show'])->syncRoles([$managerRole]);

       Permission::create(['name'=> 'manager.failures.show'])->syncRoles([$managerRole]);

       Permission::create(['name'=> 'manager.accesories.show'])->syncRoles([$managerRole]);
       Permission::create(['name'=> 'manager.accesories.update'])->syncRoles([$managerRole]);

       Permission::create(['name'=> 'manager.people.show'])->syncRoles([$managerRole]);
       Permission::create(['name'=> 'manager.people.update'])->syncRoles([$managerRole]);

       Permission::create(['name'=> 'manager.assignments.show'])->syncRoles([$managerRole]);

       Permission::create(['name'=> 'manager.physical.states.show'])->syncRoles([$managerRole]);
       Permission::create(['name'=> 'manager.operational.states.show'])->syncRoles([$managerRole]);
       Permission::create(['name'=> 'manager.accesories.states.show'])->syncRoles([$managerRole]);
       Permission::create(['name'=> 'manager.failure.types.show'])->syncRoles([$managerRole]);

       Permission::create(['name'=> 'viewer.people.show'])->syncRoles([$viewerRole]);
       Permission::create(['name'=> 'viewer.devices.show'])->syncRoles([$viewerRole]);
       Permission::create(['name'=> 'viewer.loans.show'])->syncRoles([$viewerRole]);
       Permission::create(['name'=> 'viewer.support.show'])->syncRoles([$viewerRole]);
       Permission::create(['name'=> 'viewer.accesories.show'])->syncRoles([$viewerRole]);
       Permission::create(['name'=> 'viewer.reports.show'])->syncRoles([$viewerRole]);
       Permission::create(['name'=> 'viewer.failures.show'])->syncRoles([$viewerRole]);

    }


}
