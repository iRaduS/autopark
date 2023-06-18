<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset the cached roles & perms
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Users
//        Permission::create(['name' => 'general users']);
//        Permission::create(['name' => 'create user']);
//        Permission::create(['name' => 'edit user']);
//        Permission::create(['name' => 'delete user']);
//        Permission::create(['name' => 'view user']);
//        Permission::create(['name' => 'edit role']);
//        Permission::create(['name' => 'general logs']);
//        Permission::create(['name' => 'general employees']);
//        Permission::create(['name' => 'create employee']);
//        Permission::create(['name' => 'delete employee']);
//        Permission::create(['name' => 'update employee']);
//        Permission::create(['name' => 'departures employee']);
//        Permission::create(['name' => 'project employee']);
//        Permission::create(['name' => 'ssm employee']);
//        Permission::create(['name' => 'health employee']);
//        Permission::create(['name' => 'form employee']);
//        Permission::create(['name' => 'negociation employee']);
//        Permission::create(['name' => 'general salaries']);
//        Permission::create(['name' => 'delete salary']);
//        Permission::create(['name' => 'create salary']);
//        Permission::create(['name' => 'general locations']);
//        Permission::create(['name' => 'create location']);
//        Permission::create(['name' => 'delete location']);
//        Permission::create(['name' => 'general projects']);
//        Permission::create(['name' => 'create project']);
//        Permission::create(['name' => 'delete project']);
//        Permission::create(['name' => 'general auto']);
//        Permission::create(['name' => 'general pontaj']);
//        Permission::create(['name' => 'cost pontaj']);
//        Permission::create(['name' => 'general reports']);
//        Permission::create(['name' => 'health report']);
//        Permission::create(['name' => 'ssm report']);
//        Permission::create(['name' => 'form report']);
//        Permission::create(['name' => 'auto report']);
//        Permission::create(['name' => 'departure report']);
//        Permission::create(['name' => 'general departures']);

//        $role = Role::create(['name' => 'Basic']);
        $role = Role::where('name', 'Basic')->first();
        $role->givePermissionTo('general employees');

//        $role = Role::create(['name' => 'Administrator']);
        $role = Role::where('name', 'Administrator')->first();
        $role->givePermissionTo(Permission::all());
    }
}
