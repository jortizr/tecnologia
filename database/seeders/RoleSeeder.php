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

       Permission::create(['name'=> 'dashboard']);
       Permission::create(['name'=> 'dashboard.users.show']);
       Permission::create(['name'=> 'dashboard.users.create']);
       Permission::create(['name'=> 'dashboard.users.edit']);
       Permission::create(['name'=> 'dashboard.users.delete']);
       Permission::create(['name'=> 'dashboard.users.update']);

       Permission::create(['name'=> 'dashboard.clausule.show']);
       Permission::create(['name'=> 'dashboard.clausule.create']);
       Permission::create(['name'=> 'dashboard.clausule.edit']);
       Permission::create(['name'=> 'dashboard.clausule.delete']);
       Permission::create(['name'=> 'dashboard.clausule.update']);

       Permission::create(['name'=> 'dashboard.devices.show']);
       Permission::create(['name'=> 'dashboard.devices.create']);
       Permission::create(['name'=> 'dashboard.devices.edit']);
       Permission::create(['name'=> 'dashboard.devices.delete']);
       Permission::create(['name'=> 'dashboard.devices.update']);

       Permission::create(['name'=> 'dashboard.accesories.show']);
       Permission::create(['name'=> 'dashboard.accesories.create']);
       Permission::create(['name'=> 'dashboard.accesories.edit']);
       Permission::create(['name'=> 'dashboard.accesories.delete']);
       Permission::create(['name'=> 'dashboard.accesories.update']);

       Permission::create(['name'=> 'dashboard.assignments.show']);
       Permission::create(['name'=> 'dashboard.assignments.create']);
       Permission::create(['name'=> 'dashboard.assignments.edit']);
       Permission::create(['name'=> 'dashboard.assignments.delete']);
       Permission::create(['name'=> 'dashboard.assignments.update']);

       Permission::create(['name'=> 'dashboard.simcards.show']);
       Permission::create(['name'=> 'dashboard.simcards.create']);
       Permission::create(['name'=> 'dashboard.simcards.edit']);
       Permission::create(['name'=> 'dashboard.simcards.delete']);
       Permission::create(['name'=> 'dashboard.simcards.update']);

       Permission::create(['name'=> 'dashboard.loans.show']);
       Permission::create(['name'=> 'dashboard.loans.create']);
       Permission::create(['name'=> 'dashboard.loans.edit']);
       Permission::create(['name'=> 'dashboard.loans.delete']);
       Permission::create(['name'=> 'dashboard.loans.update']);

       Permission::create(['name'=> 'dashboard.support.show']);
       Permission::create(['name'=> 'dashboard.support.create']);
       Permission::create(['name'=> 'dashboard.support.edit']);
       Permission::create(['name'=> 'dashboard.support.delete']);
       Permission::create(['name'=> 'dashboard.support.update']);

       Permission::create(['name'=> 'dashboard.reports.show']);
       Permission::create(['name'=> 'dashboard.reports.create']);
       Permission::create(['name'=> 'dashboard.reports.edit']);
       Permission::create(['name'=> 'dashboard.reports.delete']);
       Permission::create(['name'=> 'dashboard.reports.update']);

    }
}
